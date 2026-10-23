<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Filterable\LandingPagesFilterable;
use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\PageRequest;
use App\Models\LandingPage;
use App\Models\Language;
use App\Traits\UploadImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    use UploadImage;
    const SAVE_AND_EXIT = 'save';
    const IMAGE_PATH = 'landing_pages';
    const REMOVE_IMAGE = 1;
    protected array $languageSlugs; // Explicitly define the type as an array
    public function __construct(protected LandingPage $landingPage)
    {
        $statusCounts = LandingPage::withTrashed()
            ->selectRaw("
                CASE
                    WHEN deleted_at IS NOT NULL THEN 'trashed'
                    ELSE status
                END as status_group,
                COUNT(*) as total_count
            ")
            ->groupBy('status_group')
            ->pluck('total_count', 'status_group');
        view()->share(['statusCounts' => $statusCounts]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Initialize the pageContents array
        $landingPageContents = [];
        // Get pages with contents
        $landingPages = $this->landingPage->withTrashed()->filterable(LandingPagesFilterable::class)->with('contents','admin')->get();
        // Iterate over pages and their associated contents
        $landingPages->each(function ($landingPage) use (&$landingPageContents) {
            $landingPage->contents->each(function ($content) use (&$landingPageContents) {
                $landingPageContents[$content->page_id][$content->language_code] = [
                    'name'  => $content->name,
                    'image' => $content->image
                ];
            });
        });
        return view('admin.landing-page.index', compact('landingPages', 'landingPageContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.landing-page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $landingPage = $this->page->create($request->input());
            // sync Image and request
            $request['image'] = $this->uploadImage(
                $request->file('file'),
                self::IMAGE_PATH
            );
            $landingPageContent = $landingPage->contents()->create($request->except('tags'));
            $this->makeTags($landingPageContent, $request->tags);
            DB::commit();
            toastr()->success(__('site.notification.create_success'));
            if($request['submitter'] == self::SAVE_AND_EXIT) {
                return redirect()->route('pages.index');
            }
            return redirect()->route('pages.edit',$landingPage);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.create_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $landingPage): RedirectResponse
    {
        return redirect()->route('pages.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $landingPage): View|RedirectResponse
    {
        // Returns 'en' if present, null if not
        $refLang = request('ref_lang') ?? config('app.locale');
        $languageVersionName = LanguageHelper::getLanguageNameBySlug($refLang);
        $tagNames = '';
        if($languageVersionName) //check ref_lang
        {
            $landingPageContent = $landingPage->content($refLang);
            if ($landingPageContent) {
                $tags = $landingPageContent->tags()
                    ->with([
                        'translations' => fn ($q) => $q->locale($refLang),
                    ])
                    ->get();
                $tagNames = $tags->pluck('translations.0.name')
                    ->filter()
                    ->implode(',');
            }
            return view('admin.page.edit', compact('page', 'pageContent', 'languageVersionName', 'refLang', 'tagNames'));
        }
        toastr()->error(__('site.page.language_does_not_exists'));
        return redirect()->route('pages.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $landingPage): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $landingPage->update($request->input());
            // sync Image and request
            if($request['remove_image'] == self::REMOVE_IMAGE){
                $request['image'] = null;
            }
            $request['image'] = $this->uploadImage(
                $request->file('file'),
                self::IMAGE_PATH,
                $landingPage->image
            );
            $landingPageContent = $landingPage->contents()->updateOrCreate(
                ['language_code' => $request->language_code, 'page_id' => $landingPage->id],
                $request->except('tags')
            );
            $this->makeTags($landingPageContent, $request->tags);
            DB::commit();
            toastr()->success(__('site.notification.update_success'));
            if($request['submitter'] == self::SAVE_AND_EXIT) {
                return redirect()->route('pages.index');
            }
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.update_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $landingPage): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $landingPage->delete();
            toastr()->success(__('site.notification.move_to_trash_success'));
            DB::commit();
            return redirect()->route('pages.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.move_to_trash_fail'));
            return redirect()->back()->withInput();
        }
    }

    public function trash(): View
    {
        $landingPageTrash = true;
        $landingPageContents = [];
        $landingPages = $this->page->onlyTrashed()->with('contents','admin')->get();
        // Initialize the pageContents array
        // Iterate over pages and their associated contents
        $landingPages->each(function ($landingPage) use (&$landingPageContents) {
            $landingPage->contents->each(function ($content) use (&$landingPageContents) {
                $landingPageContents[$content->page_id][$content->language_code] = [
                    'name'  => $content->name,
                    'image' => $content->image
                ];
            });
        });
        return view('admin.page.index', compact('pages', 'pageContents','pageTrash'));
    }

    // Restore a soft-deleted item
    public function restore($landingPageId): RedirectResponse
    {
        $landingPage = Page::withTrashed()->find($landingPageId);
        if ($landingPage) {
            $landingPage->restore();
            toastr()->success(__('site.notification.restored'));
        } else {
            toastr()->error(__('site.notification.restore_fail'));
        }
        return redirect()->back();
    }

    // Permanently delete a soft-deleted item
    public function forceDelete($id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $landingPage = Page::withTrashed()->findOrFail($id);
                $landingPage->forceDelete();
            });
            toastr()->success(__('site.notification.delete_success'));
        } catch (\Throwable $e) {
            toastr()->error(__('site.notification.delete_fail'));
        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Helpers\LanguageHelper;
use App\Http\Requests\Admins\PageRequest;
use App\Models\Page;
use App\Filters\Filterable\PagesFilterable;
use App\Traits\UploadImage;
use App\Services\TagService;
use Illuminate\Support\Facades\Auth;

class PageController extends BaseController
{
    use UploadImage;
    const SAVE = 'save';
    const SAVE_AND_EXIT = 'save_and_exit';
    const IMAGE_PATH = 'pages';
    const REMOVE_IMAGE = 1;
    protected array $languageSlugs; // Explicitly define the type as an array
    public function __construct(protected Page $page)
    {
        $statusCounts = Page::withTrashed()
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
        $pageContents = [];
        // Get pages with contents
        $pages = $this->page->withTrashed()->filterable(PagesFilterable::class)->with('contents','admin')->get();
        // Iterate over pages and their associated contents
        $pages->each(function ($page) use (&$pageContents) {
            $page->contents->each(function ($content) use (&$pageContents) {
                $pageContents[$content->page_id][$content->language_code] = [
                    'name'  => $content->name,
                    'image' => $content->image
                ];
            });
        });
        return view('admin.page.index', compact('pages', 'pageContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $page = $this->page->create($request->input());
            // sync Image and request
            $request['image'] = $this->uploadImage(
                $request->file('image'),
                self::IMAGE_PATH
            );
            $pageContent = $page->contents()->create($request->except('tags'));
            $this->makeTags($pageContent, $request->tags);
            DB::commit();
            toastr()->success(__('site.notification.create_success'));
            if($request['submitter'] == self::SAVE_AND_EXIT) {
                return redirect()->route('pages.index');
            }
            return redirect()->route('pages.edit',$page);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.create_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page): RedirectResponse
    {
        return redirect()->route('pages.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page): View|RedirectResponse
    {
        // Returns 'en' if present, null if not
        $refLang = request('ref_lang') ?? config('app.locale');
        $languageVersionName = LanguageHelper::getLanguageNameBySlug($refLang);
        if($languageVersionName) //check ref_lang
        {
            $pageContent = $page->content($refLang);
            $tags = $pageContent->tags()
                ->with(['translations' => fn($q) => $q->locale($refLang)])
                ->get();

            $tagNames = $tags->pluck('translations.0.name')
                        ->filter()
                        ->implode(',');

            return view('admin.page.edit', compact('page', 'pageContent', 'languageVersionName', 'refLang', 'tagNames'));
        }
        toastr()->error(__('site.page.language_does_not_exists'));
        return redirect()->route('pages.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $page->update($request->input());
            // sync Image and request
            if($request['remove_image'] == self::REMOVE_IMAGE){
                $request['image'] = null;
            }
            $request['image'] = $this->uploadImage(
                $request->file('image'),
                self::IMAGE_PATH,
                $page->image
            );
            $pageContent = $page->contents()->updateOrCreate(
                ['language_code' => $request->language_code, 'page_id' => $page->id],
                $request->except('tags')
            );
            $this->makeTags($pageContent, $request->tags);
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
    public function destroy(Page $page): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $page->delete();
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
        $pageTrash = true;
        $pageContents = [];
        $pages = $this->page->onlyTrashed()->with('contents','admin')->get();
        // Initialize the pageContents array
        // Iterate over pages and their associated contents
        $pages->each(function ($page) use (&$pageContents) {
            $page->contents->each(function ($content) use (&$pageContents) {
                $pageContents[$content->page_id][$content->language_code] = [
                    'name'  => $content->name,
                    'image' => $content->image
                ];
            });
        });
        return view('admin.page.index', compact('pages', 'pageContents','pageTrash'));
    }

    // Restore a soft-deleted item
    public function restore($pageId): RedirectResponse
    {
        $page = Page::withTrashed()->find($pageId);
        if ($page) {
            $page->restore();
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
                $page = Page::withTrashed()->findOrFail($id);
                $page->forceDelete();
            });
            toastr()->success(__('site.notification.delete_success'));
        } catch (\Throwable $e) {
            toastr()->error(__('site.notification.delete_fail'));
        }
        return redirect()->back();
    }

    private function makeTags($pageContent, $tags): void
    {
        if (!$tags) {
            return;
        }
        app(TagService::class)->sync(
            $pageContent,
            explode(',', $tags)
        );
    }
}

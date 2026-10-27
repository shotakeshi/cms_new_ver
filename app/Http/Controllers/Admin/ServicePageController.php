<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Filterable\ServicePagesFilterable;
use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\ServicePageRequest;
use App\Models\ServicePage;
use App\Models\Widget;
use App\Traits\UploadImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    use UploadImage;

    const SAVE_AND_EXIT = 'save';

    const IMAGE_PATH = 'service_pages';

    const REMOVE_IMAGE = 1;

    protected array $languageSlugs; // Explicitly define the type as an array

    public function __construct(protected ServicePage $servicePage)
    {
        $statusCounts = ServicePage::withTrashed()
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
        $servicePageContents = [];
        // Get pages with contents
        $servicePages = $this->servicePage->withTrashed()->filterable(ServicePagesFilterable::class)->with('contents', 'admin')->get();
        // Iterate over pages and their associated contents
        $servicePages->each(function ($servicePage) use (&$servicePageContents) {
            $servicePage->contents->each(function ($content) use (&$servicePageContents) {
                $servicePageContents[$content->service_page_id][$content->language_code] = [
                    'name' => $content->name,
                    'image' => $content->image,
                ];
            });
        });

        return view('admin.service-page.index', compact('servicePages', 'servicePageContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $widgets = Widget::active()->get();

        return view('admin.service-page.create', compact('widgets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServicePageRequest $request): RedirectResponse
    {
        $uploadedImage = null;
        DB::beginTransaction();
        try {
            $servicePage = $this->servicePage->create($request->input());
            // sync Image and request
            $request['image'] = $this->uploadImage(
                $request->file('file'),
                self::IMAGE_PATH
            );
            $uploadedImage = $request['image'];
            $servicePage->contents()->create($request->except(['file', 'remove_image', 'submitter']));
            DB::commit();
            toastr()->success(__('site.notification.create_success'));
            if ($request['submitter'] == self::SAVE_AND_EXIT) {
                return redirect()->route('service-pages.index');
            }

            return redirect()->route('service-pages.edit', $servicePage);
        } catch (\Throwable $e) {
            DB::rollBack();
            if (! empty($uploadedImage)) {
                Storage::disk('public')->delete($uploadedImage);
            }
            report($e);
            toastr()->error(__('site.notification.create_fail'));

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServicePage $servicePage): RedirectResponse
    {
        return redirect()->route('service-pages.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicePage $servicePage): View|RedirectResponse
    {
        $widgets = Widget::active()->get();
        // Returns 'en' if present, null if not
        $refLang = request('ref_lang') ?? config('app.locale');
        $languageVersionName = LanguageHelper::getLanguageNameBySlug($refLang);
        if ($languageVersionName) { // check ref_lang
            $servicePageContent = $servicePage->content($refLang);

            return view('admin.service-page.edit', compact('servicePage', 'servicePageContent', 'languageVersionName', 'refLang', 'widgets'));
        }
        toastr()->error(__('site.page.language_does_not_exists'));

        return redirect()->route('service-pages.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServicePageRequest $request, ServicePage $servicePage): RedirectResponse
    {
        $uploadedImage = null;
        DB::beginTransaction();
        try {
            $servicePage->update($request->input());
            $oldContent = $servicePage->content($request->language_code);
            $data = $request->except(['file', 'remove_image', 'submitter']);
            $removeImage = $request['remove_image'] == self::REMOVE_IMAGE;
            if ($removeImage) {
                $data['image'] = null;
            }
            if ($request->hasFile('file')) {
                $uploadedImage = $this->uploadImage(
                    $request->file('file'),
                    self::IMAGE_PATH,
                    $oldContent?->image
                );
                $data['image'] = $uploadedImage;
            }
            $servicePage->contents()->updateOrCreate(
                ['language_code' => $request->language_code, 'service_page_id' => $servicePage->id],
                $data
            );
            DB::commit();
            toastr()->success(__('site.notification.update_success'));
            if ($request['submitter'] == self::SAVE_AND_EXIT) {
                return redirect()->route('service-pages.index');
            }

            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($uploadedImage) {
                Storage::disk('public')->delete($uploadedImage);
            }
            report($e);
            toastr()->error(__('site.notification.update_fail'));

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicePage $servicePage): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $servicePage->delete();
            toastr()->success(__('site.notification.move_to_trash_success'));
            DB::commit();

            return redirect()->route('service-pages.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.move_to_trash_fail'));

            return redirect()->back()->withInput();
        }
    }

    public function trash(): View
    {
        $servicePageTrash = true;
        $servicePageContents = [];
        $servicePages = $this->servicePage->onlyTrashed()->with('contents', 'admin')->get();
        // Initialize the pageContents array
        // Iterate over pages and their associated contents
        $servicePages->each(function ($servicePage) use (&$servicePageContents) {
            $servicePage->contents->each(function ($content) use (&$servicePageContents) {
                $servicePageContents[$content->service_page_id][$content->language_code] = [
                    'name' => $content->name,
                    'image' => $content->image,
                ];
            });
        });

        return view('admin.service-page.index', compact('servicePages', 'servicePageContents', 'servicePageTrash'));
    }

    // Restore a soft-deleted item
    public function restore($servicePageId): RedirectResponse
    {
        $servicePage = ServicePage::withTrashed()->find($servicePageId);
        if ($servicePage) {
            $servicePage->restore();
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
            DB::transaction(function () use ($id, &$images) {
                $servicePage = ServicePage::withTrashed()->findOrFail($id);
                $servicePage->forceDelete();
            });
            toastr()->success(__('site.notification.delete_success'));
        } catch (\Throwable $e) {
            report($e);
            toastr()->error(__('site.notification.delete_fail'));
        }

        return redirect()->back();
    }
}

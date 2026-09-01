<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Helpers\LanguageHelper;
use App\Http\Requests\Admins\BlogCategoryRequest;
use App\Services\BlogCategoryService;

class BlogCategoryController extends BaseController
{
    const SAVE = 'save';
    protected array $languageSlugs;
    public function __construct(
        protected BlogCategory $blogCategory,
        protected BlogCategoryService $blogCategoryService,
    ){
        $this->languageSlugs = Language::active()->pluck('slug')->toArray();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(
            'admin.blog.category.index',
            $this->blogCategoryService->getIndexData()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $blogCategory = $this->blogCategory->create($request->input());
            $blogCategory->contents()->create($request->input());
            DB::commit();
            toastr()->success(__('site.notification.create_success'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.create_fail'));
            return redirect()->back()->withInput();
        }
    }

    public function edit(BlogCategory $blogCategory): View|RedirectResponse
    {
        $refLang = request('ref_lang') ?: config('app.locale');
        $languageVersionName = LanguageHelper::getLanguageNameBySlug($refLang);
        if (!$languageVersionName) {
            toastr()->error(__('site.page.language_does_not_exists'));
            return redirect()->route('blog-categories.index');
        }

        $categoryData = $this->blogCategoryService->getIndexData();

        $availableCategories = $this->blogCategoryService
            ->getAvailableParentCategories(
                $blogCategory,
                $categoryData['blogCategories']
            );

        $blogCategoryContent = $blogCategory->content($refLang);

        return view('admin.blog.category.index', [
            'blogCategories' => $categoryData['blogCategories'],
            'blogCategoryContents' => $categoryData['blogCategoryContents'],

            'availableCategories' => $availableCategories,
            'availableCategoryContents' => $categoryData['blogCategoryContents'],

            'blogCategory' => $blogCategory,
            'blogCategoryContent' => $blogCategoryContent,

            'languageVersionName' => $languageVersionName,
            'refLang' => $refLang,
            'isEditMode' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $blogCategory->update($request->input());
            $blogCategory->contents()->updateOrCreate(
                ['language_code' => $request->language_code, 'blog_category_id' => $blogCategory->id],
                $request->all()
            );
            DB::commit();
            toastr()->success(__('site.notification.update_success'));
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
    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        try {
            DB::transaction(fn () => $blogCategory->delete());
            toastr()->success(__('site.notification.delete_success'));
            return back();
        } catch (\Throwable $e) {
            report($e);
            toastr()->error(__('site.notification.delete_fail'));
            return back()->withInput();
        }
    }
}

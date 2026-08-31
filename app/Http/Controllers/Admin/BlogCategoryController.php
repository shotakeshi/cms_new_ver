<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Helpers\LanguageHelper;
use App\Http\Requests\Admins\BlogCategoryRequest;

class BlogCategoryController extends BaseController
{
    const SAVE = 'save';
    protected array $languageSlugs;
    public function __construct(protected BlogCategory $blogCategory)
    {
        $this->languageSlugs = Language::active()->pluck('slug')->toArray();
        $blogCategoryContents = [];

        $blogCategories = $this->blogCategory
            ->where('parent_id', 0)
            ->with([
                'contents',
                'admin',
                'childrenRecursive'
            ])
            ->get();

        $this->buildCategoryContents($blogCategories, $blogCategoryContents);
        view()->share([
            'blogCategories' => $blogCategories,
            'blogCategoryContents' => $blogCategoryContents
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('admin.blog.category.index');
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory): View|RedirectResponse
    {
        $refLang = request('ref_lang') ?: config('app.locale');
        //check ref_lang
        $languageVersionName = LanguageHelper::getLanguageNameBySlug($refLang);
        if (!$languageVersionName) {
            toastr()->error(
                __('site.page.language_does_not_exists')
            );
            return redirect()->route('blog-categories.index');
        }

        /*
         * Get all Blog Category.
         */
        $allCategories = $this->blogCategory
            ->with('contents')
            ->orderBy('parent_id')
            ->orderBy('id')
            ->get();
        /*
         * Tìm current category + toàn bộ descendants
         * hoàn toàn trong memory.
         */
        $excludedIds = collect([$blogCategory->id]);

        $findChildren = function (int $parentId) use (
            &$findChildren,
            $allCategories,
            &$excludedIds
        ): void {
            $allCategories
                ->where('parent_id', $parentId)
                ->each(function ($child) use (
                    &$findChildren,
                    &$excludedIds
                ): void {
                    $excludedIds->push($child->id);

                    $findChildren($child->id);
                });
        };
        $findChildren($blogCategory->id);

        /*
         * Build category tree.
         */
        $buildTree = function (
            $categories,
            int $parentId = 0
        ) use (&$buildTree) {
            return $categories
                ->where('parent_id', $parentId)
                ->map(function ($category) use (
                    &$buildTree,
                    $categories
                ) {
                    $category->setRelation(
                        'children',
                        $buildTree($categories, $category->id)
                    );
                    return $category;
                })
                ->values();
        };

        /*
         * Loại current category + descendants
         * ngay trên dataset.
         */
        $availableCategories = $allCategories
            ->reject(
                fn ($category) => $excludedIds->contains($category->id)
            );
        $availableCategories = $buildTree($availableCategories);

        /*
         * Build contents map.
         */
        $availableCategoryContents = [];
        foreach ($allCategories as $category) {
            foreach ($category->contents as $content) {
                $availableCategoryContents[$category->id][$content->language_code] = [
                    'name' => $content->name,
                ];
            }
        }
        /*
         * Current language content.
         */
        $blogCategoryContent = $blogCategory->content($refLang);
        $isEditMode = true;
        return view('admin.blog.category.index', compact(
            'blogCategory',
            'availableCategories',
            'availableCategoryContents',
            'blogCategoryContent',
            'languageVersionName',
            'refLang',
            'isEditMode'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        dd($request->all());
        DB::beginTransaction();
        try {
            $page->update($request->all());
            // sync Image and request
            $request['image'] = $this->handleImageUpload($request, $request->image);
            $page->contents()->updateOrCreate(
                ['language_code' => $request->language_code, 'page_id' => $page->id],
                $request->all()
            );
            DB::commit();
            toastr()->success(__('site.notification.update_success'));
            if($request->submitter == self::SAVE) {
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

    private function buildCategoryContents($categories, &$blogCategoryContents)
    {
        foreach ($categories as $category) {

            foreach ($category->contents as $content) {
                $blogCategoryContents[$content->blog_category_id][$content->language_code] = [
                    'name' => $content->name,
                    'language_code' => $content->language_code,
                    'slug' => $content->slug
                ];
            }

            if ($category->children && $category->children->count()) {
                $this->buildCategoryContents($category->children, $blogCategoryContents);
            }
        }
    }
}

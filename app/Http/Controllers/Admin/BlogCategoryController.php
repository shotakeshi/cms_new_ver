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
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
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

        return view('admin.blog.category.index', compact('blogCategories', 'blogCategoryContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.blog.category.create');
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
    public function edit(BlogCategoryRequest $blogCategoryRequest): View|RedirectResponse
    {
//        $refLang = request('ref_lang') ?? config('app.locale'); // Returns 'en' if present, null if not
//        $languageVersionName = LanguageHelper::getLanguageNameBySlug($refLang);
//        if($languageVersionName) //check ref_lang
//        {
//            $pageContent = $page->content($refLang);
//            return view('admin.page.edit', compact('page', 'pageContent', 'languageVersionName', 'refLang'));
//        }
//        toastr()->error(__('site.page.language_does_not_exists'));
        return redirect()->route('pages.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page): RedirectResponse
    {
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
        DB::beginTransaction();
        try {
            $blogCategory->contents()->delete();
            $blogCategory->delete();
            toastr()->success(__('site.notification.delete_success'));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.delete_fail'));
        }
        return redirect()->back()->withInput();
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

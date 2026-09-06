<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Language;

class BlogPostController extends Controller
{
    public function __construct(protected BlogCategory $blogCategory)
    {
        $this->languageSlugs = Language::active()->pluck('slug')->toArray();
//        $blogCategoryContents = [];
//
//        $blogCategories = $this->blogCategory
//            ->where('parent_id', 0)
//            ->with([
//                'contents',
//                'admin',
//                'childrenRecursive'
//            ])
//            ->get();
//
//        $this->buildCategoryContents($blogCategories, $blogCategoryContents);
//
//        view()->share([
//            'blogCategories' => $blogCategories,
//            'blogCategoryContents' => $blogCategoryContents
//        ]);
    }

    public function index(){
        $statusCounts = 0;
        return view(
            'admin.blog.posts.index',
            compact('statusCounts')
        );
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

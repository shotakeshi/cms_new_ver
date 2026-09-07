<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Language;
use App\Services\BlogCategoryService;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function __construct(
        protected BlogCategoryService $blogCategoryService
    ){
        $this->languageSlugs = Language::active()->pluck('slug')->toArray();
    }

    public function index(){
        $statusCounts = 0;
        return view(
            'admin.blog.posts.index',
            compact('statusCounts')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view(
            'admin.blog.posts.create',
            $this->blogCategoryService->getIndexData()
        );
    }
}

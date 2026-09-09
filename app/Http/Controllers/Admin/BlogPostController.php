<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Language;
use App\Services\BlogCategoryService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Requests\Admins\BlogPostRequest;
use App\Traits\UploadImage;
use App\Enums\BlogPostStatus;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BlogPostController extends Controller
{
    use UploadImage;
    const SAVE_AND_EXIT = 'save';
    const IMAGE_PATH = 'blog';
    const REMOVE_IMAGE = 1;

    public function __construct(
        protected BlogCategoryService $blogCategoryService,
        protected BlogPost $blogPost
    ){
        $this->languageSlugs = Language::active()->pluck('slug')->toArray();
    }

    public function index(){
        $statusCounts = 0;
        return view(
            'admin.blog.posts.index',
            compact('statusCounts'),
            $this->blogCategoryService->getIndexData()
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

    public function store(BlogPostRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $blogPost = $this->blogPost->create($request->input());
            // sync Image and request
            $request['image'] = $this->uploadImage(
                $request->file('file'),
                self::IMAGE_PATH
            );
            $blogPostContent = $blogPost->contents()->create($request->except('tags'));
            $blogPost->categories()->attach($request->blog_category_id);
            $this->makeTags($blogPostContent, $request->tags);
            DB::commit();
            toastr()->success(__('site.notification.create_success'));
            if($request['submitter'] == self::SAVE_AND_EXIT) {
                return redirect()->route('blog-posts.index');
            }
            return redirect()->route('blog-posts.edit',$blogPost);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('site.notification.create_fail'));
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost): View|RedirectResponse
    {
        // Returns 'en' if present, null if not
        $refLang = request('ref_lang') ?? config('app.locale');
        $languageVersionName = LanguageHelper::getLanguageNameBySlug($refLang);
        $tagNames = '';
        if($languageVersionName) //check ref_lang
        {
            $blogPostContent = $blogPost->content($refLang);
            if ($blogPostContent) {
                $tags = $blogPostContent->tags()
                    ->with([
                        'translations' => fn ($q) => $q->locale($refLang),
                    ])
                    ->get();
                $tagNames = $tags->pluck('translations.0.name')
                    ->filter()
                    ->implode(',');
            }
            return view('admin.blog.posts.edit', compact('blogPost', 'blogPostContent', 'languageVersionName', 'refLang', 'tagNames'),
                $this->blogCategoryService->getIndexData()
            );
        }
        toastr()->error(__('site.page.language_does_not_exists'));
        return redirect()->route('blog-posts.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BlogPostRequest $request,
        BlogPost $blogPost
    ): RedirectResponse {
        DB::beginTransaction();
        try {
            $data = $request->all();

            // Publication status
            $data = $this->preparePublicationData(
                $blogPost,
                $data
            );

            // Post password
            if ($request->boolean('remove_post_password')) {
                $data['post_password'] = null;
            } else {
                unset($data['post_password']);
            }

            // Upload image
            if ($request->hasFile('file')) {
                $data['image'] = $this->uploadImage(
                    $request->file('file'),
                    self::IMAGE_PATH,
                    $blogPost->content($request->language_code)?->image
                );
            }

            // Update Blog Post
            $blogPost->update($data);

            // Remove image
            if (($data['remove_image'] ?? null) === self::REMOVE_IMAGE) {
                $data['image'] = null;
            }

            // Update Blog Post Content
            $blogPostContent = $blogPost->contents()->updateOrCreate(
                [
                    'language_code' => $data['language_code'],
                    'blog_post_id' => $blogPost->id,
                ],
                collect($data)->except([
                    'tags',
                    'status',
                    'published_at',
                    'post_password',
                    'remove_post_password',
                    'remove_image',
                    'blog_category_id',
                    'submitter',
                    'file',
                ])->toArray()
            );

            // Sync categories
            $blogPost->categories()->sync( $data['blog_category_id'] );

            // Sync tags
            $this->makeTags(
                $blogPostContent,
                $data['tags'] ?? []
            );
            DB::commit();
            toastr()->success(__('site.notification.update_success'));

            if (($data['submitter'] ?? null) === self::SAVE_AND_EXIT) {
                return redirect()->route('blog-posts.index');
            }

            return redirect()->back();

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            toastr()->error(  __('site.notification.update_fail') );

            return redirect()->back()->withInput();
        }
    }

    private function makeTags($blogPostContent, $tags): void
    {
        if (!$tags) {
            return;
        }
        app(TagService::class)->sync(
            $blogPostContent,
            explode(',', $tags)
        );
    }

    protected function preparePublicationData(
        BlogPost $blogPost,
        array $data
    ): array {
        $status = BlogPostStatus::from($data['status']);

        switch ($status) {
            case BlogPostStatus::DRAFT:
            case BlogPostStatus::PRIVATE:
                $data['published_at'] = null;
                break;

            case BlogPostStatus::SCHEDULE:
                if (blank($data['published_at'] ?? null)) {
                    throw ValidationException::withMessages([
                        'published_at' => __('site.blog.posts.published_at_scheduled'),
                    ]);
                }

                $publishedAt = Carbon::createFromFormat(
                    'd/m/Y - H:i',
                    $data['published_at']
                );

                if ($publishedAt->lte(now())) {
                    throw ValidationException::withMessages([
                        'published_at' => __('site.blog.posts.published_at_ltd'),
                    ]);
                }
                break;
            case BlogPostStatus::PUBLISH:
                // Chuyển từ Draft / Private / Schedule -> Published
                if ($blogPost->status !== BlogPostStatus::PUBLISH) {
                    $data['published_at'] = now()->format('d/m/Y - H:i');
                } else {
                    unset($data['published_at']);
                }
                break;
        }
        return $data;
    }
}

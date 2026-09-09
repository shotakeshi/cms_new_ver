<?php

namespace App\Http\Requests\Admins;

use App\Enums\DefaultStatus;
use App\Enums\BlogPostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogPost = $this->route('blog_post');
        $content = $blogPost?->contents()
            ->where('language_code', $this->input('language_code'))
            ->first();
        return [
            /*
             * Blog post content
             */
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blog_post_contents', 'slug')
                    ->where(
                        fn ($query) => $query->where(
                            'language_code',
                            $this->input('language_code')
                        )
                    )
                    ->ignore($content?->id),
            ],

            'excerpt' => [
                'required',
                'string',
            ],

            'content' => [
                'required',
                'string',
            ],

            /*
             * Category
             */
            'blog_category_id' => [
                'nullable',
                'array',
                'min:1',
            ],

            'blog_category_id.*' => [
                'integer',
                'exists:blog_categories,id',
            ],

            /*
             * SEO
             */
            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
            ],

            /*
             * Post settings
             */
            'post_password' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status_comment' => [
                'integer',
                Rule::in(
                    array_column(
                        DefaultStatus::cases(),
                        'value'
                    )
                ),
            ],

            'tags' => [
                'nullable',
                'string',
            ],

            'published_at' => [
                'nullable',
                'date_format:d/m/Y - H:i'
            ],

            /*
             * Image
             */
            'file' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('site.blog.posts.name'),
            'slug' => __('site.page.slug'),
            'excerpt' => __('site.blog.posts.excerpt'),
            'content' => __('site.page.content'),
            'blog_category_id' => __('site.blog.posts.categories'),
            'post_password' => __('site.blog.posts.post_password'),
            'status_comment' => __('site.page.status_comment'),
            'meta_title' => __('site.page.meta_title'),
            'meta_description' => __('site.page.meta_description'),
            'meta_keywords' => __('site.page.meta_keywords'),
            'published_at' => __('site.page.published_at'),
            'file' => __('site.page.avatar'),
            'tags' => __('site.tags'),
        ];
    }
}
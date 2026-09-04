<?php

namespace App\Services;

use App\Models\BlogCategory;
use Illuminate\Support\Collection;

class BlogCategoryService
{
    public function __construct(
        protected BlogCategory $blogCategory,
    ) {
    }

    /**
     * Get all categories as flat collection.
     */
    public function getAllCategories(): Collection
    {
        return $this->blogCategory
            ->newQuery()
            ->with('contents')
            ->orderBy('parent_id')
            ->orderBy('id')
            ->get();
    }

    /**
     * Get all categories and build tree in memory.
     */
    public function getCategoryTree(): Collection
    {
        return $this->buildTree(
            $this->getAllCategories()
        );
    }

    /**
     * Build category tree from flat collection.
     */
    public function buildTree(
        Collection $categories,
        int $parentId = 0,
    ): Collection {
        $grouped = $categories->groupBy('parent_id');

        $build = function (int $parentId) use (
            &$build,
            $grouped
        ): Collection {
            return $grouped
                ->get($parentId, collect())
                ->map(
                    function (BlogCategory $category) use (&$build): BlogCategory {
                        $category->setRelation(
                            'children',
                            $build($category->id)
                        );

                        return $category;
                    }
                )
                ->values();
        };

        return $build($parentId);
    }

    /**
     * Build category content map.
     */
    public function buildCategoryContents(
        Collection $categories
    ): array {
        $result = [];

        $stack = $categories->values()->all();

        while ($stack) {
            /** @var BlogCategory $category */
            $category = array_pop($stack);

            foreach ($category->contents as $content) {
                $result[$category->id][$content->language_code] = [
                    'name' => $content->name,
                    'language_code' => $content->language_code,
                    'slug' => $content->slug,
                ];
            }

            foreach ($category->children as $child) {
                $stack[] = $child;
            }
        }

        return $result;
    }

    /**
     * Get all data used by index page.
     */
    public function getIndexData(): array
    {
        $blogCategories = $this->getCategoryTree();

        return [
            'blogCategories' => $blogCategories,
            'blogCategoryContents' => $this->buildCategoryContents(
                $blogCategories
            ),
        ];
    }

    /**
     * Get category IDs that cannot be selected as parent.
     */
    public function getExcludedIds(
        BlogCategory $currentCategory,
        Collection $categories,
    ): array {
        $grouped = $categories->groupBy('parent_id');

        $excluded = [$currentCategory->id];
        $stack = [$currentCategory->id];

        while ($stack !== []) {
            $parentId = array_pop($stack);

            foreach ($grouped->get($parentId, collect()) as $child) {
                $excluded[] = $child->id;
                $stack[] = $child->id;
            }
        }

        return array_values(array_unique($excluded));
    }

    /**
     * Get available parent categories for edit.
     */
    public function getAvailableParentCategories(
        BlogCategory $currentCategory,
    ): Collection {
        // Always use flat collection here.
        $categories = $this->getAllCategories();

        $excludedIds = $this->getExcludedIds(
            $currentCategory,
            $categories
        );

        $available = $categories->reject(
            fn (BlogCategory $category): bool =>
            in_array($category->id, $excludedIds, true)
        );

        return $this->buildTree($available);
    }
}
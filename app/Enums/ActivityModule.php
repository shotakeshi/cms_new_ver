<?php

namespace App\Enums;

enum ActivityModule: string
{
    case MEDIA   = 'media';
    case PRODUCT = 'product';
    case AUTH    = 'auth';
    case USER    = 'user';
    case SYSTEM  = 'system';
    case PAGE  = 'page';
    case PAGE_CONTENT  = 'page_content';
    case ADMIN   = 'admin';

    case BLOG_POST    = 'blog_post';

    case BLOG_CATEGORY = 'blog_category';

    case BLOG_CATEGORY_CONTENT = 'blog_category_content';
}

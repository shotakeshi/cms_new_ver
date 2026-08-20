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
}

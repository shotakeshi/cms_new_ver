<?php

namespace App\Observers;

use App\Models\Image;
use App\Services\Image\ImageStorageManager;

class ImageObserver
{
    public function updated(Image $image): void
    {
        app(ImageStorageManager::class)->deleteFile($image->path);

    }
}

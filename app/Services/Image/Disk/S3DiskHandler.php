<?php

namespace App\Services\Image\Disk;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3DiskHandler implements DiskHandler
{
    public function upload(UploadedFile $file, string $folder, string $filename): string
    {
        Storage::disk('s3')->putFileAs($folder, $file, $filename);
    }

    public function delete(string $path): bool
    {
        Storage::disk('s3')->delete($path);
    }
}

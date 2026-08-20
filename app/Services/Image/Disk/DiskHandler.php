<?php

namespace App\Services\Image\Disk;

use Illuminate\Http\UploadedFile;

interface DiskHandler
{
    public function upload(UploadedFile $file, string $folder, string $filename): string;
    public function delete(string $path): bool;
}

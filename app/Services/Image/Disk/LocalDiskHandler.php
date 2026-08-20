<?php

namespace App\Services\Image\Disk;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalDiskHandler implements DiskHandler
{
    public function upload(UploadedFile $file, string $folder, string $filename): string
    {
        return $file->storeAs($folder, $filename, 'public');
    }

    public function delete(string $path): bool
    {
        Storage::disk('public')->delete($path);
    }
}

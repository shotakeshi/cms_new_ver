<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImage
{
    /**
     * Upload image and return path
     *
     * @param UploadedFile|null $file
     * @param string $folder
     * @param string|null $oldPath
     * @return string|null
     */
    protected function uploadImage(
        ?UploadedFile $file,
        string $folder,
        ?string $oldPath = null,
        ?string $slug = null
    ): ?string {
        if (!$file) {
            return $oldPath;
        }
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        $extension = $file->getClientOriginalExtension();

        $name = $slug
            ? Str::slug($slug)
            : Str::slug(pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ));

        $filename = $name . '.' . $extension;

        return $file->storeAs($folder, $filename, 'public');
    }

    protected function prepareImage(
        ?UploadedFile $file,
        ?string $slug = null
    ): ?array {
        $extension = $file->getClientOriginalExtension();

        $name = $slug
            ? Str::slug($slug)
            : Str::slug(pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ));

        $filename = $name . '.' . $extension;

        return [
            'file' => $file,
            'extension' => $extension,
            'filename' => $filename,
        ];
    }


    //upload multi image
    protected function uploadImages(array $files, string $folder): array
    {
        return collect($files)
            ->map(fn ($file) => $file->store($folder, 'public'))
            ->toArray();
    }
}

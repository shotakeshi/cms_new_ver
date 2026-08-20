<?php

namespace App\Services\Image;
use App\Models\Image;
use App\Services\Image\Disk\DiskHandler;

class ImageStorageManager {
    public function __construct(
        protected DiskHandler $disk
    ){}

    /**
     * Store new image
     *
     * @param array $data
     * @param string $folder
     * @param int|null $adminId
     * @return Image
     */
    public function store(array $data, string $folder = 'images', ?int $adminId = null): Image
    {
        $path = $this->disk->upload(
            $data['file'],
            $folder,
            $data['filename']
        );

        return Image::create([
            'name'     => $data['filename'],
            'path'     => $folder,
            'type'     => $data['extension'],
            'admin_id' => $adminId,
        ]);
    }

    /**
     * Replace exists image
     *
     * @param Image $image
     * @param array $data
     * @param string $folder
     * @return Image
     */
    public function update(Image $image, array $data, string $folder = 'images'): Image
    {
        $newPath = $this->disk->upload(
            $data['file'],
            $folder,
            $data['filename']
        );

        $this->disk->delete($image->path);

        $image->update([
            'name'     => $data['filename'],
            'path'     => $newPath,
            'type'     => $data['extension'],
        ]);

        return $image;
    }

    /**
     * Delete file only used by Observe
     * @param string $path
     * @return bool
     */
    public function deleteFile(string $path): bool
    {
        return $this->disk->delete($path);
    }
}
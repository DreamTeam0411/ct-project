<?php

namespace App\Services\Service;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ServiceImageStorage
{
    protected Filesystem $storage;
    protected const DISK = 'service-photos';
    protected const PATH = '/';

    public function __construct()
    {
        $this->storage = Storage::disk(self::DISK);
    }

    /**
     * @param string $filename
     * @return string|null
     */
    public function getImage(string $filename): ?string
    {
        return $this->storage->get($filename);
    }

    /**
     * @param UploadedFile $file
     * @return void
     */
    public function saveImage(UploadedFile $file): void
    {
        $this->storage->put(self::PATH, $file);
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function isImageExists(string $filename): bool
    {
        return $this->storage->exists($filename);
    }

    /**
     * @param string $filename
     * @return void
     */
    public function deleteImage(string $filename): void
    {
        $this->storage->delete(self::PATH . $filename);
    }
}

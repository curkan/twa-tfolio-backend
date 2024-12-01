<?php

declare(strict_types=1);

namespace App\Ship\Services\Storages;

use DateTimeInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

abstract class AbstractStorage
{
    /**
     * @return Filesystem
     */
    public function filesystem(): Filesystem
    {
        return Storage::disk($this->disk());
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function urlOrFail(string $path): string
    {
        abort_if($this->filesystem()->missing($path), 404);

        return $this->filesystem()->url($path);
    }

    /**
     * @param string $path
     * @param DateTimeInterface|null $expiration
     * @param ?array $options
     *
     * @return string
     */
    public function temporaryUrlOrFail(string $path, ?DateTimeInterface $expiration = null, ?array $options = []): string
    {
        abort_if($this->filesystem()->missing($path), 404);

        return $this->filesystem()->temporaryUrl($path, $expiration, $options);
    }

    /**
     * @param string|null $directory
     *
     * @return Collection
     */
    public function allFilesAsCollection(?string $directory = null): Collection
    {
        return collect($this->filesystem()->allFiles($directory));
    }

    /**
     * @param string $path
     * @param File|string|UploadedFile $file
     * @param string $fileName
     *
     * @return false|string
     */
    public function putNamedFile(string $path, $file, string $fileName)
    {
        return $this->filesystem()->putFile($path, $file, [], $fileName); /* @phpstan-ignore-line */
    }

    /**
     * @return string
     */
    abstract protected function disk(): string;
}

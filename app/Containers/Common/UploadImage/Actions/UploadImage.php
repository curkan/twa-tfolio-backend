<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadImage\Actions;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use App\Ship\Parents\Models\Image as ModelsImage;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\Node;
use App\Ship\Services\Storages\YandexProfileStorage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Str;

final class UploadImage
{
    private const TEMP_HEIC_STORAGE_DIR = 'app/heic_images/';

    /**
     * @param UploadedFile $file
     *
     * @return Node
     */
    public function run(UploadedFile $file): Node
    {
        if ($file->getMimeType() == 'image/heic') {
            $image = $this->convertHeic($file);
        } else {
            $image = Image::make($file->path());
        }

        $sizes = [
            'original' => null,
            'md' => [800, null],
            'sm' => [400, null],
            'xs' => [200, null],
        ];

        /**
         * @var Model $imageModel
         */
        $imageModel = new ModelsImage();
        $imageModel->user_id = Auth::id();

        foreach ($sizes as $size => $dimensions) {
            if ($size === 'original') {
                $image->encode('webp', 100);
                $nameFile = resolve(YandexProfileStorage::class)->filesystem()->putFile(
                    Auth::id() . '/',
                    $image->basePath()
                );
                $imageModel->original = Str::contains($nameFile, '/') ? Str::afterLast($nameFile, '/') : $nameFile; /* @phpstan-ignore-line */
            } else {
                $image->resize($dimensions[0], null, function ($constraint): void {
                    $constraint->aspectRatio();
                })->encode('webp', 100);
                $nameFile = resolve(YandexProfileStorage::class)->filesystem()->putFile(
                    Auth::id() . '/',
                    $image->basePath()
                );
                $imageModel->{$size} = Str::contains($nameFile, '/') ? Str::afterLast($nameFile, '/') : $nameFile;
            }
        }

        $imageModel->save();

        $lastNode = Node::where('user_id', Auth::id())->orderByDesc('sort')->first();

        $file = new Filesystem();
        $file->cleanDirectory('storage/app/heic_images');

        return Node::create([
            'user_id' => Auth::id(),
            'image_id' => $imageModel->getKey(),
            'type' => NodeTypeEnum::Image,
            'x' => 0,
            'y' => 0,
            'w' => 2,
            'h' => 2,
            'sort' => $lastNode === null ? 1 : ++$lastNode->sort,
        ]);
    }

    /**
     * @param UploadedFile $file
     */
    private function convertHeic(UploadedFile $file): \Intervention\Image\Image
    {
        $extension = $file->getClientOriginalExtension();

        $randomFilename = bin2hex(random_bytes(8));

        $tmpFilepath = storage_path(
            self::TEMP_HEIC_STORAGE_DIR .
            $randomFilename . ".{$extension}"
        );

        $convertedFilepath = storage_path(
            self::TEMP_HEIC_STORAGE_DIR .
            $randomFilename . '.jpg'
        );

        File::put($tmpFilepath, $file->getContent());

        exec('convert "' . $tmpFilepath . '" "' . $convertedFilepath . '"');

        return Image::make($convertedFilepath);
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadVideo\Actions;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use App\Ship\Parents\Models\Image as ModelsImage;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\Video;
use App\Ship\Parents\Models\VideoPoster;
use App\Ship\Services\Storages\YandexProfileStorage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Str;

final class UploadFileVideo
{
    /**
     * @param UploadedFile $file
     *
     * @return Node
     */
    public function run(UploadedFile $file): Node
    {
        $fileName = $this->createFilename($file);
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date('Y-m-W');

        // Build the file path
        $filePath = "upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path('app/' . $filePath);

        // move the file name
        $file = $file->move($finalPath, $fileName);

        $sizes = [
            'original' => null,
            'md' => [1200, null],
            'sm' => [800, null],
            'xs' => [400, null],
        ];

        /**
         * @var Model $imageModel
         */
        $video = new Video();
        $video->user_id = Auth::id();
        $video->save();

        $nameFile = resolve(YandexProfileStorage::class)->filesystem()->putFile(
            Auth::id() . '/videos/' . $video->getKey() . '/',
            $finalPath . '/' . $fileName
        );

        VideoPoster::create([
            'video_id' => $video,
            'original' => null,
        ]);

        // foreach ($sizes as $size => $dimensions) {
        //     if ($size === 'original') {
        //         $image->encode('webp', 100)->save($image->basePath(), 100, 'webp');
        //         $nameFile = resolve(YandexProfileStorage::class)->filesystem()->putFile(
        //             Auth::id() . '/' . $imageModel->getKey() . '/',
        //             $image->basePath()
        //         );
        //         $imageModel->original = Str::contains($nameFile, '/') ? Str::afterLast($nameFile, '/') : $nameFile; /* @phpstan-ignore-line */
        //     } else {
        //         $image->resize($dimensions[0], null, function ($constraint): void {
        //             $constraint->aspectRatio();
        //         })->encode('webp', 100)->save($image->basePath(), 100, 'webp');
        //         $nameFile = resolve(YandexProfileStorage::class)->filesystem()->putFile(
        //             Auth::id() . '/' . $imageModel->getKey() . '/',
        //             $image->basePath()
        //         );
        //         $imageModel->{$size} = Str::contains($nameFile, '/') ? Str::afterLast($nameFile, '/') : $nameFile;
        //     }
        // }
        //
        // unset($image);
        // $imageModel->save();
        // unlink($file->getPathname());

        $lastNode = Node::where('user_id', Auth::id())->orderByDesc('sort')->first();

        $file = new Filesystem();

        return Node::create([
            'user_id' => Auth::id(),
            'video_id' => $video->getKey(),
            'type' => NodeTypeEnum::Video,
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
    private function createFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace('.' . $extension, '', $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= '_' . md5((string) time()) . '.' . $extension;

        return $filename;
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadVideo\Actions;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\Video;
use App\Ship\Services\Storages\YandexVideosStorage;
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

        $pathToFile = $finalPath . '/' . $fileName;

        /**
         * @var Video $video
         */
        $video = new Video();
        $video->user_id = Auth::id();
        $video->save();

        $nameFile = resolve(YandexVideosStorage::class)->filesystem()->putFile(
            Auth::id() . '/' . $video->getKey() . '/',
            $pathToFile
        );

        $video->link = Str::contains($nameFile, '/') ? Str::afterLast($nameFile, '/') : $nameFile;
        $video->save();

        (new MakePoster())->run($video, $pathToFile, $finalPath);

        $lastNode = Node::where('user_id', Auth::id())->orderByDesc('sort')->first();

        $file = new Filesystem();

        unlink($pathToFile);

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
        $uuid = Str::uuid();

        return $uuid->toString();
    }
}

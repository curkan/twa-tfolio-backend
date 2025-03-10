<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadVideo\Actions;

use App\Ship\Parents\Models\Video;
use App\Ship\Parents\Models\VideoPoster;
use App\Ship\Services\Storages\YandexVideosStorage;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Media\Video as MediaVideo;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Str;

final class MakePoster
{
    /**
     * @param Video $video
     * @param string $pathToFile
     * @param string $finalPath
     *
     * @return void
     */
    public function run(Video $video, string $pathToFile, string $finalPath): void
    {
        $sizes = [
            'original' => null,
            'md' => [1200, null],
            'sm' => [800, null],
            'xs' => [400, null],
        ];

        $posterPath = $this->extractFirstFrame($pathToFile, $finalPath);

        $videoPoster = new VideoPoster([
            'video_id' => $video->getKey(),
            'original' => null,
        ]);

        $image = Image::make($posterPath);

        foreach ($sizes as $size => $dimensions) {
            if ($size === 'original') {
                $image->encode('webp', 100)->save($image->basePath(), 100, 'webp');
                $nameFile = resolve(YandexVideosStorage::class)->filesystem()->putFile(
                    Auth::id() . '/' . $video->getKey() . '/posters/',
                    $image->basePath()
                );
                $videoPoster->original = Str::contains($nameFile, '/') ? Str::afterLast($nameFile, '/') : $nameFile; /* @phpstan-ignore-line */
            } else {
                $image->resize($dimensions[0], null, function ($constraint): void {
                    $constraint->aspectRatio();
                })->encode('webp', 100)->save($image->basePath(), 100, 'webp');
                $nameFile = resolve(YandexVideosStorage::class)->filesystem()->putFile(
                    Auth::id() . '/' . $video->getKey() . '/posters/',
                    $image->basePath()
                );
                $videoPoster->{$size} = Str::contains($nameFile, '/') ? Str::afterLast($nameFile, '/') : $nameFile;
            }
        }

        unlink($posterPath);
        unset($posterPath, $image);

        $videoPoster->save();
    }

    /**
     * Extract the first frame from the video.
     *
     * @param string $videoPath
     * @param string $outputPath
     * @return string
     */
    private function extractFirstFrame(string $videoPath, string $outputPath): string
    {
        $ffmpeg = FFMpeg::create();

        /**
         * @var MediaVideo
         */
        $video = $ffmpeg->open($videoPath);

        $posterFilename = 'poster_' . Str::uuid()->toString() . '.jpg';
        $posterPath = $outputPath . '/' . $posterFilename;

        $video->frame(TimeCode::fromSeconds(0))
            ->save($posterPath);

        return $posterPath;
    }
}

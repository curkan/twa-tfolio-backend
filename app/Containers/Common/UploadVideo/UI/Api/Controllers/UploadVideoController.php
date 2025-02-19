<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadVideo\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\NodeResource;
use App\Containers\Common\UploadVideo\Actions\UploadFileVideo;
use App\Containers\Common\UploadVideo\UI\Api\Resources\FileProcessResource;
use App\Containers\Common\UploadVideo\UI\Api\Requests\UploadVideoRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

final class UploadVideoController extends ApiController
{
    /**
     * @param UploadVideoRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(UploadVideoRequest $request): JsonResponse
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            $node = (new UploadFileVideo())->run($save->getFile());

            return $this->resourceShow(NodeResource::make($node));
        }

        $handler = $save->handler();

        return $this->resourceStored(FileProcessResource::make((object) ['process' => $handler->getPercentageDone(), 'status' => true]));
    }
}

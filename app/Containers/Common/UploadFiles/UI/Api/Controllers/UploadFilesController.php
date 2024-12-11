<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadFiles\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\NodeResource;
use App\Containers\Common\UploadFiles\Actions\UploadFileImage;
use App\Containers\Common\UploadFiles\UI\Api\Requests\UploadFilesRequest;
use App\Containers\Common\UploadFiles\UI\Api\Resources\FileProcessResource;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

final class UploadFilesController extends ApiController
{
    /**
     * @param UploadFilesRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(UploadFilesRequest $request): JsonResponse
    {
        $receiver = new FileReceiver('files', $request, HandlerFactory::classFromRequest($request));

        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            $node = (new UploadFileImage())->run($save->getFile());

            return $this->resourceShow(NodeResource::make($node));
        }

        $handler = $save->handler();

        return $this->resourceStored(FileProcessResource::make((object) ['process' => $handler->getPercentageDone(), 'status' => true]));
    }
}

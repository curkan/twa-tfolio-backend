<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadImage\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\NodeResource;
use App\Containers\Common\UploadImage\Actions\UploadImage;
use App\Containers\Common\UploadImage\UI\Api\Requests\UploadImageRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

final class UploadImageController extends ApiController
{
    public function __invoke(UploadImageRequest $request): JsonResponse
    {
        $node = (new UploadImage())->run($request->file('picture'));

        return $this->resourceShow(NodeResource::make($node));
    }
}

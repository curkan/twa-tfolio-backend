<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadImage\UI\Api\Controllers;

use App\Containers\Common\Grid\UI\Api\Resources\NodeResource;
use App\Containers\Common\UploadImage\Actions\UploadImage;
use App\Containers\Common\UploadImage\UI\Api\Requests\UploadImageRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

final class UploadImageController extends ApiController
{
    public function __invoke(UploadImageRequest $request): JsonResponse
    {
        DB::beginTransaction();
        $node = (new UploadImage())->run($request->file('picture'));
        DB::commit();

        return $this->resourceShow(NodeResource::make($node));
    }
}

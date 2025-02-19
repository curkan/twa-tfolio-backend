<?php

declare(strict_types=1);

namespace App\Containers\Common\UploadVideo\UI\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *  schema="FileProcess",
 *  title="File process resource",
 * 	@OA\Property(
 * 		property="process",
 * 		type="int",
 *      example="23"
 * 	),
 * 	@OA\Property(
 * 		property="status",
 * 		type="bool",
 *      example="true"
 * 	),
 * )
 */
final class FileProcessResource extends JsonResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'process' => $this->process,
            'status' => $this->status,
        ];
    }
}

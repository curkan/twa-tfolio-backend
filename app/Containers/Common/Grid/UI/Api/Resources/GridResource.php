<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class GridResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => (int) $this->id,
            'grid' => NodeResource::collection($this->nodes),
        ];
    }
}

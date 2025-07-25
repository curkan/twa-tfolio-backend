<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserNodeResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'photo_url' => $this->photo_url,
            'display_name' => $this->display_name,
        ];
    }
}

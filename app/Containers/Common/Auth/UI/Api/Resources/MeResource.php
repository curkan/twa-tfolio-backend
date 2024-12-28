<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\UI\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MeResource extends JsonResource
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
            'biography' => $this->biography,
            'settings' => [
                'enabled_send_me_button' => $this->settings->get('enabled_send_me_button'),
            ],
        ];
    }
}

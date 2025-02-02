<?php

declare(strict_types=1);

namespace App\Containers\Common\SocialLinks\UI\Api\Controllers;

use App\Containers\Common\SocialLinks\UI\Api\Resources\SocialLinkResource;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\SocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetSocialLinksController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->has('user_id')) {
            $socialLinks = SocialLink::where('user_id', $request->input('user_id'))->orderBy('created_at')->get();
        } else {
            $socialLinks = SocialLink::forAuthUser()->orderBy('created_at')->get();
        }

        return $this->resourceCollection(SocialLinkResource::collection($socialLinks));
    }
}

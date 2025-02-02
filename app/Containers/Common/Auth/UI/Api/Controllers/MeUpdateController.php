<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\UI\Api\Controllers;

use App\Containers\Common\Auth\UI\Api\Requests\MeUpdateRequest;
use App\Containers\Common\Auth\UI\Api\Resources\MeResource;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Models\SocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class MeUpdateController extends ApiController
{
    /**
     * @param MeUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(MeUpdateRequest $request): JsonResponse
    {
        $user = Auth::user();

        $user->update(array_filter([
            'display_name' => $request->input('displayName'),
            'biography' => $request->input('biography'),
        ]));

        if ($request->has('socials')) {
            $socialLinksData = $request->input('socials');
            $socialLinksIds = [];

            foreach ($socialLinksData as $socialLink) {
                $socialLink = SocialLink::where('id', $socialLink['id'])->forAuthUser()->updateOrCreate(
                    [
                        'id' => $socialLink['id'],
                    ],
                    [
                        'url' => $socialLink['url'],
                        'user_id' => Auth::id(),
                    ]
                );

                $socialLinksIds[] = $socialLink->getKey();
            }

            SocialLink::whereNotIn('id', $socialLinksIds)->forAuthUser()->delete();
        }

        if (null !== $request->input('settings.enabled_send_me_button')) {
            $user->settings->set('enabled_send_me_button', $request->input('settings.enabled_send_me_button'));
        }

        return $this->resourceUpdated(MeResource::make($user));
    }
}

<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\Middlewares;

use App\Containers\Common\Auth\Actions\TWAAuth;
use App\Containers\Common\Auth\Data\DTO\User;
use App\Ship\Parents\Models\User as ModelsUser;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AuthMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $token = $request->bearerToken();
        $queryString = base64_decode($token);
        $twaAuth = new TWAAuth($queryString);
        parse_str($queryString, $queryParams);

        if (!$twaAuth->isValid()) {
            throw new AuthenticationException();
        }

        $user = User::fromArray(json_decode($queryParams['user'], true));

        if (blank($user->getId())) {
            throw new AuthenticationException('User not isset in auth data');
        }

        $authUser = ModelsUser::find($user->getId());

        if (!$authUser) {
            $authUser = ModelsUser::create([
                'id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'username' => $user->getUsername(),
                'language_code' => $user->getLanguageCode(),
                'allows_write_to_pm' => $user->getAllowsWriteToPm(),
            ]);
        }

        app('auth')->setUser($authUser);

        return $next($request);
    }
}

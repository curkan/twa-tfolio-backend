<?php

declare(strict_types=1);

namespace App\Ship\Parents\Controllers;

use App\Ship\Core\Abstracts\Controllers\ApiController as AbstractApiController;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class: ApiController.
 *
 * @see AbstractApiController
 * @abstract
 *
 *   @OA\Info(
 *     title="my-sybscribers",
 *     version="1.0.0"
 *   )
 *   @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Custom domain",
 *   )
 */
abstract class ApiController extends AbstractApiController
{
    /**
     * success response method.
     *
     * @param mixed $result
     * @param mixed $message
     *
     * @return JsonResponse
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * return error response.
     *
     * @param mixed $error
     * @param mixed $errorMessages
     * @param mixed $code
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}

<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\BusinessLogicException;
use App\Ship\Services\Responses\Messages;
use App\Ship\Services\Responses\Responses;
use App\Ship\Services\Traits\Exceptions\ContextMessageSerializer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class Handler extends ExceptionHandler
{
    use ContextMessageSerializer;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */ protected $levels = [ //
        ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
            //
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response_json(Messages::RESOURCE_NOT_FOUND, null, null, $e->getStatusCode());
        });

        $this->renderable(function (InvalidArgumentException $e) {
            return response_json(Messages::INTERNAL_ERROR, null, $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $this->renderable(function (ValidationException $e) {
            $errors = $e->errors();

            foreach ($errors as &$error) {
                foreach ($error as &$err) {
                    $err = $this
                        ->deserializeContextMessage($err)
                        ->toArray();
                }
            }

            return Responses::error($errors, Messages::VALIDATION_FAIL, $e->status);
        });

        $this->renderable(function (BusinessLogicException $e) {
            return $e->toResponse();
        });

        $this->renderable(function (AuthenticationException $e) {
            return response_json($e->getMessage(), null, null, Response::HTTP_UNAUTHORIZED);
        });

        $this->renderable(function (AccessDeniedHttpException $e) {
            return Responses::empty($e->getMessage(), Response::HTTP_FORBIDDEN);
        });

        $this->renderable(function (UnauthorizedException $e) {
            $errors = null;
            if ($e->getPrevious() instanceof UnauthorizedException) {
                $errors = $e->getPrevious()->getErrors(); /* @phpstan-ignore-line */
            }

            return response_json($e->getMessage(), null, $errors, Response::HTTP_FORBIDDEN);
        });

        $this->renderable(function (Throwable $e) {
            $message = ($e instanceof HttpException || app()->isLocal() || config('app.env') === 'testing') ? $e->getMessage() : Messages::INTERNAL_ERROR;
            $status = $e instanceof HttpException ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            Log::error("Exc: {$e->getMessage()}: \n {$e->getTraceAsString()}");

            return Responses::empty($message, $status);
        });

    }
}

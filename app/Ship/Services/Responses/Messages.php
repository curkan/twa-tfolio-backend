<?php

declare(strict_types=1);

namespace App\Ship\Services\Responses;

final class Messages
{
    public const SUCCESS = 'Success.';
    public const VALIDATION_FAIL = 'Request validation fail.';
    public const RESOURCE_NOT_FOUND = 'Resource not found.';
    public const RESOURCE_ALREADY_EXISTS = 'Resource already exists.';
    public const UNPROCESSABLE_ACTION = 'Unprocessable action.';
    public const INTERNAL_ERROR = 'Internal error.';
    public const UNAUTHORIZED = 'This action is unauthorized.';
    public const FORBIDDEN = 'This action is forbidden.';
    public const FORBIDDEN_TO_CHANGE_ATTRIBUTE = 'Forbidden to change attribute.';
    public const CREATION_ON_SLAVE_NODE_IS_NOT_ALLOWED = 'Creation on slave node is not allowed.';
    public const DELETION_ON_SLAVE_NODE_IS_NOT_ALLOWED = 'Deletion on slave node is not allowed.';
    public const EXTERNAL_SERVICE_ERROR = 'External service error.';
    public const VERIFICATION_CODE_SEND = 'Verification code sent by email.';
    public const ERROR_HAS_OCCURRED = 'An error has occurred.';
}

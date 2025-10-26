<?php

namespace App\Factory\Reponse;

use App\Model\Response\ErrorResponse;

class ErrorResponseFactory
{
    public static function create(int $status, string $message): ErrorResponse
    {
        return new ErrorResponse($status, $message);
    }
}

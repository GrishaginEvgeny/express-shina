<?php

namespace App\Factory\Reponse;

use App\Model\Response\SuccessResponse;

class SuccessResponseFactory
{
    public static function create(mixed $result): SuccessResponse
    {
        return new SuccessResponse($result);
    }
}

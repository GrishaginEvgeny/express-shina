<?php

namespace App\Model\Response;

use Symfony\Component\HttpFoundation\Response;

class SuccessResponse
{
    public function __construct(public mixed $result)
    {
    }

    public int $status = Response::HTTP_OK;
}

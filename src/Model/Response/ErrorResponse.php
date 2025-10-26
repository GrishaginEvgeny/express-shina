<?php

namespace App\Model\Response;

class ErrorResponse
{
    public function __construct(public int $status,public string $message)
    {
    }
}

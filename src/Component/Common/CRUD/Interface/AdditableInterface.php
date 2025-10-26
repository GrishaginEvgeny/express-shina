<?php

namespace App\Component\Common\CRUD\Interface;

use Symfony\Component\Uid\Uuid;

interface AdditableInterface
{
    public function addById(Uuid $uuid);
}

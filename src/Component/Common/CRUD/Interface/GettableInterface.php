<?php

namespace App\Component\Common\CRUD\Interface;

use Symfony\Component\Uid\Uuid;

interface GettableInterface
{
    public function getById(Uuid $uuid);
}

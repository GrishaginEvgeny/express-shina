<?php

namespace App\Component\Common\CRUD\Interface;

use Symfony\Component\Uid\Uuid;

interface DeletableInterface
{
    public function deleteById(Uuid $uuid);
}

<?php

namespace App\Component\Common\CRUD\Interface;

use Symfony\Component\Uid\Uuid;

interface MassGettableInterface
{
    public function getBatch(?Uuid $lastUuid = null);

    public function getCountItems();
}

<?php

namespace App\Facade\Cart;

use Doctrine\ORM\EntityManagerInterface;

class CartManagementFacade
{
    use GetTrait;
    use DeleteTrait;
    use AddTrait;

    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }
}

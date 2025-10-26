<?php

namespace App\Component\Cart\Session;

use App\Entity\Cart;
use App\Facade\Cart\CartManagementFacade;

readonly class CartSessionFactory
{
    public function __construct(
        private CartManagementFacade $managementFacade
    ) {
    }

    public function createCartSession(?Cart $cart): ?CartSession
    {
        return null === $cart ? null : new CartSession(
            $cart,
            $this->managementFacade
        );
    }
}

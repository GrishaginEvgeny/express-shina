<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractSessionController extends AbstractController
{
    function __construct(
        private readonly RequestStack $requestStack
    ) {
    }

    private const CART_SESSION_KEY = 'cart_key';

    protected function getCartKey()
    {
        return $this->requestStack->getSession()->get(self::CART_SESSION_KEY);
    }
}

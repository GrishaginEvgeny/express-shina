<?php

namespace App\Facade\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\CartItemsRepository;
use Symfony\Component\Uid\Uuid;

trait DeleteTrait
{
    public function deleteProductByIdFromCart(Cart $cart, Uuid $uuid): void
    {
        $cartItem = $this->em->getRepository(CartItemsRepository::class)
            ->getItemByCartAndProduct($cart, $uuid);

        if (null !== $cartItem) {
            $cart->removeCartItem($cartItem);
            $this->em->persist($cart);
            $this->em->flush();
        }
    }
}

<?php

namespace App\Facade\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Uid\Uuid;

trait AddTrait
{
    public function addProductByIdToCart(Cart $cart, Uuid $uuid): void
    {
        $product = $this->em->getRepository(ProductRepository::class)->findOneBy([
            'id' => $uuid
        ]);
        $cartItem = new CartItem();
        $cartItem->setCart($cart);
        $cartItem->setProduct($product);
        $this->em->persist($cartItem);
        $this->em->flush();
    }
}

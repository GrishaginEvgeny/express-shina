<?php

namespace App\Facade\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\CartRepository;
use Symfony\Component\Uid\Uuid;

trait GetTrait
{
    private const CARD_ITEMS_ONE_BATCH_LIMIT = 100;

    public function getCountItems(Cart $cart): int
    {
        return $cart->getCartItems()->count();
    }

    public function getAmount(Cart $cart): float
    {
        return $this->em->getRepository(CartRepository::class)->getAmountOfCart($cart);
    }


    /** @return Product[] */
    public function getCartItemsBatch(Cart $cart, ?Uuid $uuid = null): array
    {
        return $this->em->getRepository(CartRepository::class)->getCartItemsBatch(
            $cart,
            self::CARD_ITEMS_ONE_BATCH_LIMIT,
            $uuid
        );
    }

    public function getCart(Uuid $cartId)
    {
        return $this->em->getRepository(CartRepository::class)->findOneBy([
            'id' => $cartId
        ]);
    }
}

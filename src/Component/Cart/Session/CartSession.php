<?php

namespace App\Component\Cart\Session;

use App\Component\Common\CRUD\Interface\AdditableInterface;
use App\Component\Common\CRUD\Interface\CostGettableInterface;
use App\Component\Common\CRUD\Interface\DeletableInterface;
use App\Component\Common\CRUD\Interface\GettableInterface;
use App\Component\Common\CRUD\Interface\MassGettableInterface;
use App\Entity\Cart;
use App\Entity\Product;
use App\Facade\Cart\CartManagementFacade;
use Symfony\Component\Uid\Uuid;

readonly class CartSession implements AdditableInterface, DeletableInterface, GettableInterface, CostGettableInterface, MassGettableInterface
{
    public function __construct(
        private Cart $cart,
        private CartManagementFacade $managementFacade
    ) {
    }

    public function addById(Uuid $uuid): void
    {
        $this->managementFacade->addProductByIdToCart(
            $this->cart,
            $uuid
        );
    }

    public function deleteById(Uuid $uuid): void
    {
        $this->managementFacade->deleteProductByIdFromCart(
            $this->cart,
            $uuid
        );
    }

    public function getAmount(): float
    {
        return $this->managementFacade->getAmount(
            $this->cart
        );
    }

    /**
     * @param Uuid|null $lastUuid
     * @return Product[]
     */
    public function getBatch(?Uuid $lastUuid = null): array
    {
        return $this->managementFacade->getCartItemsBatch(
            $this->cart,
            $lastUuid
        );
    }

    public function getCountItems(): int
    {
        return $this->managementFacade->getCountItems($this->cart);
    }
}

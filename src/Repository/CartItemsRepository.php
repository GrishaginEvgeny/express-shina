<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<CartItem>
 */
class CartItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    public function getItemByCartAndProduct(Cart $cart, Uuid $uuid): ?CartItem
    {
        $qb = $this->createQueryBuilder('ci');

        return $qb
            ->select('ci')
            ->from('App\Entity\CartItem', 'ci')
            ->innerJoin('ci.cart', 'c')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('ci.cart', ':cart'),
                    $qb->expr()->eq('ci.product.uuid', ':uuid')
                )
            )
            ->setParameter('cart', $cart)
            ->setParameter('product', $uuid)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

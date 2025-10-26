<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Cart>
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function getAmountOfCart(Cart $cart): float
    {
        $result = $this->createQueryBuilder('c')
            ->innerJoin('c.items', 'ci')
            ->innerJoin('ci.product', 'p')
            ->select('SUM(p.price) as total')
            ->where('c = :cart')
            ->setParameter('cart', $cart)
            ->getQuery()
            ->getSingleScalarResult();

        return $result ? (float) $result : 0.0;
    }

    /** @return Product[] */
    public function getCartItemsBatch(Cart $cart, int $limit, ?Uuid $lastUuid = null): array
    {
        $qb = $this->createQueryBuilder('c');
        $result = $qb
            ->innerJoin('c.items', 'ci')
            ->select('ci.products')
            ->where('c = :cart')
            ->setParameter('cart', $cart)
            ->orderBy('ci.added_at')
            ->setMaxResults($limit);

        if (null !== $lastUuid) {
            $result->andWhere(
                $qb->expr()->gt('ci.products.id', ':uuid')
            )->setParameter('uuid', $lastUuid);
        }

        return $result->getQuery()->getResult();
    }
}

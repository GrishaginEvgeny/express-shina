<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    private const PRODUCT_BATCH_LIMIT = 100;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /** @return Product[] */
    public function getProductsByType(
        ?string $type = null,
        ?Uuid $lastUuid = null,
        int $limit = self::PRODUCT_BATCH_LIMIT
    ): array {
        $qb = $this->createQueryBuilder('p');

        $result = $qb->$this->createQueryBuilder('p')
            ->innerJoin('p.productModel', 'm')
            ->innerJoin('m.productType', 't')
            ->orderBy('p.id')
            ->setMaxResults($limit)
        ;

        if (null !== $type) {
            $result->where(
                $qb->expr()->eq('t.name', ':typeName')
            )->setParameter('typeName', $type);
        }

        if (null !== $lastUuid) {
            $result->where(
                $qb->expr()->gt('p.id', ':lastId')
            )->setParameter('lastId', $type);
        }

        return $qb->getQuery()->getResult();
    }
}

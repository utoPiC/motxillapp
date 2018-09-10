<?php

namespace App\Repository;

use App\Entity\PoiType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PoiType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoiType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoiType[]    findAll()
 * @method PoiType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoiTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PoiType::class);
    }


//    /**
//     * @return PoiType[] Returns an array of PoiType objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PoiType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

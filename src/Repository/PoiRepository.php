<?php

namespace App\Repository;

use App\Entity\Poi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Poi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poi[]    findAll()
 * @method Poi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Poi::class);
    }


        public function findPoiLocations($proj_id)
        {


          $conn = $this->getEntityManager()->getConnection();

             $sql = '
                 SELECT p.*, icon FROM poi p
                 LEFT JOIN poi_type on p.point_type_id=poi_type.id
                 WHERE p.project_id_id = :val
                 ORDER BY p.id ASC
                 ';

             $stmt = $conn->prepare($sql);
             $stmt->execute(['val' => $proj_id]);

             // returns an array of arrays (i.e. a raw data set)
             return $stmt->fetchAll();


        }

//    /**
//     * @return Poi[] Returns an array of Poi objects
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
    public function findOneBySomeField($value): ?Poi
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

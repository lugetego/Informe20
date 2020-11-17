<?php

namespace App\Repository;

use App\Entity\Academico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Academico|null find($id, $lockMode = null, $lockVersion = null)
 * @method Academico|null findOneBy(array $criteria, array $orderBy = null)
 * @method Academico[]    findAll()
 * @method Academico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcademicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Academico::class);
    }

    // /**
    //  * @return Academico[] Returns an array of Academico objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Academico
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

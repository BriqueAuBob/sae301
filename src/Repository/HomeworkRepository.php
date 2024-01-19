<?php

namespace App\Repository;

use App\Entity\Homework;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Homework>
 *
 * @method Homework|null find($id, $lockMode = null, $lockVersion = null)
 * @method Homework|null findOneBy(array $criteria, array $orderBy = null)
 * @method Homework[]    findAll()
 * @method Homework[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Homework::class);
    }

    public function findByGroupAndYear($group, $year)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.group = :group')
            ->andWhere('h.year = :year')
            ->setParameter('group', $group)
            ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Homework[] Returns an array of Homework objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function search($value): array
    {
        return $this->createQueryBuilder('h')
            ->andWHere('h.name LIKE :val')
            ->orWhere('h.description LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Homework
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

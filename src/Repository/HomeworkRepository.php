<?php

namespace App\Repository;

use App\Entity\Homework;
use App\Entity\User;
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

    public function search($value, User $user): array
    {
        return $this->createQueryBuilder('h')
            ->andWHere('h.name LIKE :val')
            ->orWhere('h.description LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->andWhere('h.group = :group')
            ->setParameter('group', $user->getGroup())
            ->andWhere('h.year = :year')
            ->setParameter('year', $user->getYear())
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

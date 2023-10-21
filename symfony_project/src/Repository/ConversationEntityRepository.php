<?php

namespace App\Repository;

use App\Entity\ConversationEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConversationEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationEntity[]    findAll()
 * @method ConversationEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationEntity::class);
    }

    // /**
    //  * @return ConversationEntity[] Returns an array of ConversationEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConversationEntity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

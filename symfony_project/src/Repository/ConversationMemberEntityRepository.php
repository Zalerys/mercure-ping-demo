<?php

namespace App\Repository;

use App\Entity\ConversationMemberEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConversationMemberEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationMemberEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationMemberEntity[]    findAll()
 * @method ConversationMemberEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationMemberEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationMemberEntity::class);
    }

    // /**
    //  * @return ConversationMemberEntity[] Returns an array of ConversationMemberEntity objects
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
    public function findOneBySomeField($value): ?ConversationMemberEntity
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

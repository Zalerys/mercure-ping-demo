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


     @return ConversationEntity[] Returns an array of ConversationEntity objects


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

    public function findOneBySomeField($value): ?ConversationEntity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function getOne(string $id, string $name): ConversationEntity
    {
        $id = $this->db->createQuery('SELECT * FROM ConversationEntity WHERE id = :id');
        $name = $this->db->createQuery('SELECT * FROM ConversationEntity WHERE name = :name');
        $createQuery->execute();

        return $this->getOne($id);
    }

    public function postOne(string $id, string $name): ConversationEntity
    {
        $e =json_decode(file_get_contents('php://input');
        $uniqId = uniqid('conversation');
        $id = $this->db->createQuery('INSERT INTO ConversationEntity (id) VALUES (:id)');
        $name = $this->db->createQuery('INSERT INTO ConversationEntity (name) VALUES (:name)');
        $createQuery->bindValue(':id', $uniqId);
        $createQuery->bindValue(':name', $e);
        $createQuery->execute();

        return $this->getOne($uniqId);
    }

    public function deleteOne(string $id): void
    {
        $id = $this->db->createQuery('DELETE FROM ConversationEntity WHERE id = :id');
        $createQuery->execute();
    }

    public function getByUser($string $id): array {
        $id = $this->db->createQuery('SELECT * FROM ConversationEntity where user_id = :id');
        $createQuery->execute();
        $conversation = [];
        while ($data = $createQuery->fetch($id)) {
            $conversation = new ConversationEntity($data);
        }

        return $conversation;
    }
}

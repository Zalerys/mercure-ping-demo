<?php

namespace App\Repository;

use App\Entity\MessageEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageEntity[]    findAll()
 * @method MessageEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageEntity::class);
    }

    public function getOne($string $id): MessageEntity {
        $id = $this->db->createQuery('SELECT * FROM MessageEntity WHERE id = :id');
        $createQuery->execute();

        return $this->getOne($id);
    }

    public function postOne(): MessageEntity
    {
        $e =json_decode(file_get_contents('php://input');
        $uniqId = uniqid('message');
        $id = $this->db->createQuery('INSERT INTO MessageEntity (id, conversation_id, user_id, content, date_sent) VALUES (:id, :conversation_id, :user_id, :content, :date_sent)');
        $createQuery->bindValue(':id', $uniqId);
        $createQuery->bindValue(':conversation_id', $e['conversation_id']);
        $createQuery->bindValue(':user_id', $e['user_id']);
        $createQuery->bindValue(':content', $e['content']);
        $createQuery->bindValue(':date_sent', $e['date_sent']);
        $createQuery->execute();

        return $this->getOne($uniqId);
    }

    public function deleteOne(string $id): void
    {
        $id = $this->db->createQuery('DELETE FROM MessageEntity WHERE id = :id');
        $createQuery->execute();
    }

    public function getByUser($string $id): array {
        $id = $this->db->createQuery('SELECT * FROM MessageEntity where user_id = :id');
        $createQuery->execute();
        $message = [];
        while ($data = $createQuery->fetch($id)) {
            $message = new MessageEntity($data);
        }

        return $message;
    }

    public function getByConversation($string $id): array {
        $id = $this->db->createQuery('SELECT * FROM MessageEntity where conversation_id = :id');
        $createQuery->execute();
        $message = [];
        while ($data = $createQuery->fetch($id)) {
            $message = new MessageEntity($data);
        }

        return $message;
    }

    // /**
    //  * @return MessageEntity[] Returns an array of MessageEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageEntity
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

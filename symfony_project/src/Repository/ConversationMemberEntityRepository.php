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

    public function getOne(string $id): ConversationMemberEntity
    {
        $id = $this->db->createQuery('SELECT * FROM ConversationMemberEntity WHERE id = :id');
        $createQuery->execute();

        return $this->getOne($id);
    }

    public function getByUser(string $id): array {
        $id = $this->db->createQuery('SELECT * FROM ConversationMemberEntity where user_id = :id');
        $createQuery->execute();
        $conversation_member = [];
        while ($data = $createQuery->fetch($id)) {
            $conversation_member = new ConversationMemberEntity($data);
        }

        return $conversation_member;
    }

    public function getByConversation(string $id): array {
        $id = $this->db->createQuery('SELECT * FROM ConversationMemberEntity where conversation_id = :id');
        $createQuery->execute();
        $message = [];
        while ($data = $createQuery->fetch($id)) {
            $conversation_member = new ConversationMemberEntity($data);
        }

        return $conversation_member;
    }
}

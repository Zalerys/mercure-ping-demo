<?php

namespace App\Entity;

use App\Repository\MessageEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageEntityRepository::class)]
class MessageEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $conversation_id;

    #[ORM\Column(type: 'integer')]
    private $user_id;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime')]
    private $date_sent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConversationId(): ?int
    {
        return $this->conversation_id;
    }

    public function setConversationId(int $conversation_id): self
    {
        $this->conversation_id = $conversation_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateSent(): ?\DateTimeInterface
    {
        return $this->date_sent;
    }

    public function setDateSent(\DateTimeInterface $date_sent): self
    {
        $this->date_sent = $date_sent;

        return $this;
    }
}

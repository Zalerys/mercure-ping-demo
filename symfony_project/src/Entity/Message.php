<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\HasLifecycleCallbacks()]

class Message
{
    use Timestamp;


     #[ORM\Id]
     #[ORM\GeneratedValue]
     #[ORM\Column(type: "integer")]

    private $id;


     #[ORM\Column(type: "text")]

    private ?string $content;

     #[ORM\ManyToOne(targetEntity: "User", inversedBy: "messages")]

    private ?User $user;


     #[ORM\ManyToOne(targetEntity: "Conversation", inversedBy: "messages")]

    private ?Conversation $conversation;

    private mixed $mine;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(?Conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMine(): mixed
    {
        return $this->mine;
    }

    /**
     * @param mixed $mine
     */
    public function setMine(mixed $mine): void
    {
        $this->mine = $mine;
    }
}
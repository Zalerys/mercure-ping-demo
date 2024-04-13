<?php
// src/Entity/Message.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Message
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "text")]
    private $content;

    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(nullable: false)]
    private $sender;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Conversation", inversedBy: "messages")]
    #[ORM\JoinColumn(nullable: false)]
    private $conversation;

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

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

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
}

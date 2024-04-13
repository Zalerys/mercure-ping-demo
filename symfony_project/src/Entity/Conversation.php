<?php
// src/Entity/Conversation.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity()]
 class Conversation
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToMany(targetEntity: "App\Entity\User")]
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $user): self
    {
        if (!$this->participants->contains($user)) {
            $this->participants[] = $user;
        }

        return $this;
    }

    public function removeParticipant(User $user): self
    {
        $this->participants->removeElement($user);

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_to;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Mailbox", inversedBy="message", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_inmailbox;

    /**
     * @ORM\Column(type="boolean")
     */
    private $old;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserTo(): ?User
    {
        return $this->user_to;
    }

    public function setUserTo(?User $user_to): self
    {
        $this->user_to = $user_to;

        return $this;
    }

    public function getIdInmailbox(): ?Mailbox
    {
        return $this->id_inmailbox;
    }

    public function setIdInmailbox(Mailbox $id_inmailbox): self
    {
        $this->id_inmailbox = $id_inmailbox;

        return $this;
    }

    public function getOld(): ?bool
    {
        return $this->old;
    }

    public function setOld(bool $old): self
    {
        $this->old = $old;

        return $this;
    }
}

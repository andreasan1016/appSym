<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HeaderRepository")
 */
class Header
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="headers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_to;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $old = '0';

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

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

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

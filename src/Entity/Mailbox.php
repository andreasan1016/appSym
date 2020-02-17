<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MailboxRepository")
 */
class Mailbox
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_from;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sent_when;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Message", mappedBy="id_inmailbox", cascade={"persist", "remove"})
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserFrom(): ?User
    {
        return $this->user_from;
    }

    public function setUserFrom(?User $user_from): self
    {
        $this->user_from = $user_from;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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

    public function getSentWhen(): ?\DateTimeInterface
    {
        return $this->sent_when;
    }

    public function setSentWhen(\DateTimeInterface $sent_when): self
    {
        $this->sent_when = $sent_when;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): self
    {
        $this->message = $message;

        // set the owning side of the relation if necessary
        if ($message->getIdInmailbox() !== $this) {
            $message->setIdInmailbox($this);
        }

        return $this;
    }
}

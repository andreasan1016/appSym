<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipsRepository")
 */
class Friendships
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="myFriendships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="friendsWithMe", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $friend_id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getFriendId(): ?User
    {
        return $this->friend_id;
    }

    public function setFriendId(User $friend_id): self
    {
        $this->friend_id = $friend_id;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $avatar_src;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Groups", mappedBy="group_owner", orphanRemoval=true)
     */
    private $myGroups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="user_to", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Groups", mappedBy="users_inside")
     */
    private $groups_in;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Friendships", mappedBy="user_id", orphanRemoval=true)
     */
    private $myFriendships;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Friendships", mappedBy="friend_id", cascade={"persist", "remove"})
     */
    private $friendsWithMe;

    public function __construct()
    {
        $this->myGroups = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->groups_in = new ArrayCollection();
        $this->myFriendships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAvatarSrc(): ?string
    {
        return $this->avatar_src;
    }

    public function setAvatarSrc(?string $avatar_src): self
    {
        $this->avatar_src = $avatar_src;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|Groups[]
     */
    public function getMyGroups(): Collection
    {
        return $this->myGroups;
    }

    public function addMyGroup(Groups $myGroup): self
    {
        if (!$this->myGroups->contains($myGroup)) {
            $this->myGroups[] = $myGroup;
            $myGroup->setGroupOwner($this);
        }

        return $this;
    }

    public function removeMyGroup(Groups $myGroup): self
    {
        if ($this->myGroups->contains($myGroup)) {
            $this->myGroups->removeElement($myGroup);
            // set the owning side to null (unless already changed)
            if ($myGroup->getGroupOwner() === $this) {
                $myGroup->setGroupOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUserTo($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUserTo() === $this) {
                $message->setUserTo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Groups[]
     */
    public function getGroupsIn(): Collection
    {
        return $this->groups_in;
    }

    public function addGroupsIn(Groups $groupsIn): self
    {
        if (!$this->groups_in->contains($groupsIn)) {
            $this->groups_in[] = $groupsIn;
            $groupsIn->setUsersInside($this);
        }

        return $this;
    }

    public function removeGroupsIn(Groups $groupsIn): self
    {
        if ($this->groups_in->contains($groupsIn)) {
            $this->groups_in->removeElement($groupsIn);
            // set the owning side to null (unless already changed)
            if ($groupsIn->getUsersInside() === $this) {
                $groupsIn->setUsersInside(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Friendships[]
     */
    public function getMyFriendships(): Collection
    {
        return $this->myFriendships;
    }

    public function addMyFriendship(Friendships $myFriendship): self
    {
        if (!$this->myFriendships->contains($myFriendship)) {
            $this->myFriendships[] = $myFriendship;
            $myFriendship->setUserId($this);
        }

        return $this;
    }

    public function removeMyFriendship(Friendships $myFriendship): self
    {
        if ($this->myFriendships->contains($myFriendship)) {
            $this->myFriendships->removeElement($myFriendship);
            // set the owning side to null (unless already changed)
            if ($myFriendship->getUserId() === $this) {
                $myFriendship->setUserId(null);
            }
        }

        return $this;
    }

    public function getFriendsWithMe(): ?Friendships
    {
        return $this->friendsWithMe;
    }

    public function setFriendsWithMe(Friendships $friendsWithMe): self
    {
        $this->friendsWithMe = $friendsWithMe;

        // set the owning side of the relation if necessary
        if ($friendsWithMe->getFriendId() !== $this) {
            $friendsWithMe->setFriendId($this);
        }

        return $this;
    }
}

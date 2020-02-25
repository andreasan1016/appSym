<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Friendship", mappedBy="user")
     */
    private $friendships;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Friendship", mappedBy="friend")
     */
    private $friendswithme;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="owner", orphanRemoval=true)
     */
    private $mygroups;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", inversedBy="users")
     */
    private $groupsin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Header", mappedBy="user_to", orphanRemoval=true)
     */
    private $headers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar_src = 'default.png';


    public function __construct()
    {
        $this->friendships = new ArrayCollection();
        $this->friendswithme = new ArrayCollection();
        $this->mygroups = new ArrayCollection();
        $this->groupsin = new ArrayCollection();
        $this->headers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Friendship[]
     */
    public function getFriendships(): Collection
    {
        return array_merge($this->friendships,$this->friendswithme);
     }

    public function addFriendship(Friendship $friendship): self
    {
        if (!$this->friendships->contains($friendship)) {
            $this->friendships[] = $friendship;
            $friendship->setUser($this);
        }

        return $this;
    }

    public function removeFriendship(Friendship $friendship): self
    {
        if ($this->friendships->contains($friendship)) {
            $this->friendships->removeElement($friendship);
            // set the owning side to null (unless already changed)
            if ($friendship->getUser() === $this) {
                $friendship->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Friendship[]
     */
    public function getFriendswithme(): Collection
    {
        return $this->friendswithme;
    }

    public function addFriendswithme(Friendship $friendswithme): self
    {
        if (!$this->friendswithme->contains($friendswithme)) {
            $this->friendswithme[] = $friendswithme;
            $friendswithme->setFriend($this);
        }

        return $this;
    }

    public function removeFriendswithme(Friendship $friendswithme): self
    {
        if ($this->friendswithme->contains($friendswithme)) {
            $this->friendswithme->removeElement($friendswithme);
            // set the owning side to null (unless already changed)
            if ($friendswithme->getFriend() === $this) {
                $friendswithme->setFriend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getMygroups(): Collection
    {
        return $this->mygroups;
    }

    public function addMygroup(Group $mygroup): self
    {
        if (!$this->mygroups->contains($mygroup)) {
            $this->mygroups[] = $mygroup;
            $mygroup->setOwner($this);
        }

        return $this;
    }

    public function removeMygroup(Group $mygroup): self
    {
        if ($this->mygroups->contains($mygroup)) {
            $this->mygroups->removeElement($mygroup);
            // set the owning side to null (unless already changed)
            if ($mygroup->getOwner() === $this) {
                $mygroup->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroupsin(): Collection
    {
        return $this->groupsin;
    }

    public function addGroupsin(Group $groupsin): self
    {
        if (!$this->groupsin->contains($groupsin)) {
            $this->groupsin[] = $groupsin;
        }

        return $this;
    }

    public function removeGroupsin(Group $groupsin): self
    {
        if ($this->groupsin->contains($groupsin)) {
            $this->groupsin->removeElement($groupsin);
        }

        return $this;
    }

    /**
     * @return Collection|Header[]
     */
    public function getHeaders(): Collection
    {
        return $this->headers;
    }

    public function addHeader(Header $header): self
    {
        if (!$this->headers->contains($header)) {
            $this->headers[] = $header;
            $header->setUserTo($this);
        }

        return $this;
    }

    public function removeHeader(Header $header): self
    {
        if ($this->headers->contains($header)) {
            $this->headers->removeElement($header);
            // set the owning side to null (unless already changed)
            if ($header->getUserTo() === $this) {
                $header->setUserTo(null);
            }
        }

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatarSrc(): ?string
    {
        return $this->avatar_src;
    }

    public function setAvatarSrc(string $avatar_src): self
    {
        $this->avatar_src = $avatar_src;

        return $this;
    }

}

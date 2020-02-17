<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupsRepository")
 */
class Groups
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
    private $group_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="myGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $group_owner;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groups_in")
     */
    private $users_inside;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupName(): ?string
    {
        return $this->group_name;
    }

    public function setGroupName(string $group_name): self
    {
        $this->group_name = $group_name;

        return $this;
    }

    public function getGroupOwner(): ?User
    {
        return $this->group_owner;
    }

    public function setGroupOwner(?User $group_owner): self
    {
        $this->group_owner = $group_owner;

        return $this;
    }

    public function getUsersInside(): ?User
    {
        return $this->users_inside;
    }

    public function setUsersInside(?User $users_inside): self
    {
        $this->users_inside = $users_inside;

        return $this;
    }
}

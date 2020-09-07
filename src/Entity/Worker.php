<?php

namespace App\Entity;

use App\Repository\WorkerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)
 */
class Worker implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("worker:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("worker:read")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("worker:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("worker:read")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("worker:read")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("worker:read")
     */
    private $role;

    /**
     * @ORM\Column(type="date")
     * @Groups("worker:read")
     */
    private $recruitmentDate;

    /**
     * @ORM\OneToMany(targetEntity=Operation::class, mappedBy="idWorker")
     */
    private $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRecruitmentDate(): ?\DateTimeInterface
    {
        return $this->recruitmentDate;
    }

    public function setRecruitmentDate(\DateTimeInterface $recruitmentDate): self
    {
        $this->recruitmentDate = $recruitmentDate;

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setIdWorker($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getIdWorker() === $this) {
                $operation->setIdWorker(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}

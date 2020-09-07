<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("operation:read")
     * @Groups("worker:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("operation:read")
     * @Groups("worker:read")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("operation:read")
     * @Groups("worker:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("operation:read")
     * @Groups("worker:read")
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=Operation::class, mappedBy="idCustomer")
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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
            $operation->setIdCustomer($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getIdCustomer() === $this) {
                $operation->setIdCustomer(null);
            }
        }

        return $this;
    }
}

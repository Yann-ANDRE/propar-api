<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("operation:read")
     */
    public $id;

    /**
     * @ORM\Column(type="date")
     * @Groups("operation:read")
     */
    public $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("operation:read")
     */
    private $endDate;

    /**
     * @ORM\Column(type="text")
     * @Groups("operation:read")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Worker::class, inversedBy="operations")
     */
    private $idWorker;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCustomer;

    /**
     * @ORM\ManyToOne(targetEntity=TypeForOperation::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idOperationType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIdWorker(): ?Worker
    {
        return $this->idWorker;
    }

    public function setIdWorker(?Worker $idWorker): self
    {
        $this->idWorker = $idWorker;

        return $this;
    }

    public function getIdCustomer(): ?Customer
    {
        return $this->idCustomer;
    }

    public function setIdCustomer(?Customer $idCustomer): self
    {
        $this->idCustomer = $idCustomer;

        return $this;
    }

    public function getIdOperationType(): ?TypeForOperation
    {
        return $this->idOperationType;
    }

    public function setIdOperationType(?TypeForOperation $idOperationType): self
    {
        $this->idOperationType = $idOperationType;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="transactionsAsOrigin")
     */
    private $origin;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="transationsAsTarget")
     */
    private $target;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authorization;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $submitterId;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrigin(): ?Account
    {
        return $this->origin;
    }

    public function setOrigin(?Account $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getTarget(): ?Account
    {
        return $this->target;
    }

    public function setTarget(?Account $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getAuthorization(): ?string
    {
        return $this->authorization;
    }

    public function setAuthorization(string $authorization): self
    {
        $this->authorization = $authorization;

        return $this;
    }

    public function getSubmitterId(): ?string
    {
        return $this->submitterId;
    }

    public function setSubmitterId(string $submitterId): self
    {
        $this->submitterId = $submitterId;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}

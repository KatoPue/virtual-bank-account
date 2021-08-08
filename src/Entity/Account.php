<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=22)
     */
    private string $iban = '';

    /**
     * @ORM\Column(type="integer")
     */
    private int $balance = 0;

    /**
     * @ORM\OneToOne(targetEntity=AccountHolder::class, inversedBy="account", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?AccountHolder $accountHolder = null;

    public function __toString()
    {
        return $this->getIban();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getAccountHolder(): ?AccountHolder
    {
        return $this->accountHolder;
    }

    public function setAccountHolder(AccountHolder $accountHolder): self
    {
        $this->accountHolder = $accountHolder;

        return $this;
    }
}

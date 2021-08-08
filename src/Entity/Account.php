<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="origin")
     */
    private ArrayCollection $transactionsAsOrigin;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="target")
     */
    private ArrayCollection $transactionsAsTarget;

    public function __construct()
    {
        $this->transactionsAsOrigin = new ArrayCollection();
        $this->transactionsAsTarget = new ArrayCollection();
    }

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

    /**
     * @return Collection<Transaction>
     */
    public function getTransactionsAsOrigin(): Collection
    {
        return $this->transactionsAsOrigin;
    }

    public function addTransactionsAsOrigin(Transaction $transactionsAsOrigin): self
    {
        if (!$this->transactionsAsOrigin->contains($transactionsAsOrigin)) {
            $this->transactionsAsOrigin[] = $transactionsAsOrigin;
            $transactionsAsOrigin->setOrigin($this);
        }

        return $this;
    }

    public function removeTransactionsAsOrigin(Transaction $transactionsAsOrigin): self
    {
        if ($this->transactionsAsOrigin->removeElement($transactionsAsOrigin)) {
            // set the owning side to null (unless already changed)
            if ($transactionsAsOrigin->getOrigin() === $this) {
                $transactionsAsOrigin->setOrigin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<Transaction>
     */
    public function getTransactionsAsTarget(): Collection
    {
        return $this->transactionsAsTarget;
    }

    public function addTransactionsAsTarget(Transaction $transationsAsTarget): self
    {
        if (!$this->transactionsAsTarget->contains($transationsAsTarget)) {
            $this->transactionsAsTarget[] = $transationsAsTarget;
            $transationsAsTarget->setTarget($this);
        }

        return $this;
    }

    public function removeTransactionsAsTarget(Transaction $transactionsAsTarget): self
    {
        if ($this->transactionsAsTarget->removeElement($transactionsAsTarget)) {
            // set the owning side to null (unless already changed)
            if ($transactionsAsTarget->getTarget() === $this) {
                $transactionsAsTarget->setTarget(null);
            }
        }

        return $this;
    }
}

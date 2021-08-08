<?php

namespace App\Entity;

use App\Repository\AccountHolderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountHolderRepository::class)
 */
class AccountHolder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name = '';

    /**
     * @ORM\OneToOne(targetEntity=Account::class, mappedBy="accountHolder", cascade={"persist", "remove"})
     */
    private ?Account $account = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        // set the owning side of the relation if necessary
        if ($account->getAccountHolder() !== $this) {
            $account->setAccountHolder($this);
        }

        $this->account = $account;

        return $this;
    }
}

<?php

namespace App\DTO;

use App\Entity\Account;
use App\Entity\Transaction;

class TransactionViewModel
{
    private ?int $id = null;
    private ?Account $origin = null;
    private ?Account $target = null;
    private string $reference = 'NOT PROVIDED';
    private string $authorization = '';
    private string $submitterId = '';
    private float $amount = 0.0;

    public static function fromTransactionOfAccount(Transaction $transaction, Account $account): self
    {
        $dto                = new self();
        $dto->id            = $transaction->getId();
        $dto->origin        = $transaction->getOrigin();
        $dto->target        = $transaction->getTarget();
        $dto->reference     = $transaction->getReference();
        $dto->authorization = $transaction->getAuthorization();
        $dto->submitterId   = $transaction->getSubmitterId();
        $dto->amount        = $transaction->getAmount() / 100;

        if ($dto->getOrigin() === $account) {
            $dto->amount *= -1;
        }

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Account|null
     */
    public function getOrigin(): ?Account
    {
        return $this->origin;
    }

    /**
     * @return Account|null
     */
    public function getTarget(): ?Account
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getAuthorization(): string
    {
        return $this->authorization;
    }

    /**
     * @return string
     */
    public function getSubmitterId(): string
    {
        return $this->submitterId;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
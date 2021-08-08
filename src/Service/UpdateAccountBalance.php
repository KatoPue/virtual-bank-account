<?php

namespace App\Service;

use App\Entity\Transaction;
use App\Repository\AccountRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UpdateAccountBalance
{
    private AccountRepository $accountRepository;

    public function __construct(
        AccountRepository $accountRepository
    )
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updateAccountsLinkedToTransaction(Transaction $transaction): void
    {
        $targetAccount = $transaction->getTarget();
        if ($targetAccount) {
            $targetAccount->setBalance($targetAccount->getBalance() + $transaction->getAmount());
            $this->accountRepository->save($targetAccount);
        }

        $originAccount = $transaction->getOrigin();
        if ($originAccount) {
            // TODO account balance is not allowed to be lover than 0
            $originAccount->setBalance($originAccount->getBalance() - $transaction->getAmount());
            $this->accountRepository->save($originAccount);
        }
    }
}
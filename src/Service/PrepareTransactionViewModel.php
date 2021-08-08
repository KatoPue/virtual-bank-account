<?php

namespace App\Service;

use App\DTO\TransactionViewModel;
use App\Entity\Account;
use App\Entity\Transaction;

class PrepareTransactionViewModel
{
    /**
     * @param array<Transaction> $transactions
     * @return array<TransactionViewModel>
     */
    public function prepareFromTransactionsRelatedToAccount(array $transactions, Account $account): array
    {
        // TODO: might need refactoring, because [EA] is crying: New value type (\App\DTO\TransactionViewModel) is not matching the resolved parameter type and might introduce types-related false-positives.
        array_walk($transactions, static function(Transaction &$transaction) use ($account) {
            $transaction = TransactionViewModel::fromTransactionOfAccount($transaction, $account);
        });

        return $transactions;
    }
}
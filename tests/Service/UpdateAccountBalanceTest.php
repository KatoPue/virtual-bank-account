<?php

namespace App\Tests\Service;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Repository\AccountRepository;
use App\Service\UpdateAccountBalance;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UpdateAccountBalanceTest extends KernelTestCase
{
    public function testUpdateAccountsLinkedToTransaction_Deposit(): void
    {
        $kernel = self::bootKernel();

        $realAccount   = self::$container->get(AccountRepository::class)->find(1);
        $expectedBalance = $realAccount->getBalance() + 1234; // see the transaction amount

        $accountRepositoryMock = $this->createMock(AccountRepository::class);
        $accountRepositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Account $account) use ($expectedBalance) {
                        return $account->getBalance() === $expectedBalance;
                    }
                )
            );
        $updateAccountBalance = new UpdateAccountBalance($accountRepositoryMock);

        $transaction = new Transaction();
        $transaction->setTarget($realAccount);
        $transaction->setAmount(1234);

        $updateAccountBalance->updateAccountsLinkedToTransaction($transaction);
    }

    public function testUpdateAccountsLinkedToTransaction_Withdraw(): void
    {
        $kernel = self::bootKernel();

        $realAccount   = self::$container->get(AccountRepository::class)->find(1);
        $expectedBalance = $realAccount->getBalance() - 1234;

        $accountRepositoryMock = $this->createMock(AccountRepository::class);
        $accountRepositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Account $account) use ($expectedBalance) {
                        return $account->getBalance() === $expectedBalance;
                    }
                )
            );
        $updateAccountBalance = new UpdateAccountBalance($accountRepositoryMock);

        $transaction = new Transaction();
        $transaction->setOrigin($realAccount);
        $transaction->setAmount(1234);

        $updateAccountBalance->updateAccountsLinkedToTransaction($transaction);
    }

    public function testUpdateAccountsLinkedToTransaction_Transfer(): void
    {
        $kernel = self::bootKernel();

        $realAccount    = self::$container->get(AccountRepository::class)->find(1);
        $realAccount2   = self::$container->get(AccountRepository::class)->find(2);
        $expectedBalance  = $realAccount->getBalance() - 1234;
        $expectedBalance2 = $realAccount2->getBalance() + 1234;

        $accountRepositoryMock = $this->createMock(AccountRepository::class);
        $accountRepositoryMock->expects($this->exactly(2))
            ->method('save')
            ->with(
                // TODO: how to distinguish between the two calls, so i can compare the account balances more precise?
                $this->callback(
                    function (Account $account) use ($expectedBalance, $expectedBalance2) {
                        return $account->getBalance() === $expectedBalance || $account->getBalance() === $expectedBalance2;
                    }
                )
            );
        $updateAccountBalance = new UpdateAccountBalance($accountRepositoryMock);

        $transaction = new Transaction();
        $transaction->setOrigin($realAccount);
        $transaction->setTarget($realAccount2);
        $transaction->setAmount(1234);

        $updateAccountBalance->updateAccountsLinkedToTransaction($transaction);
    }
}

<?php

namespace App\Tests\DTO;

use App\DTO\TransactionViewModel;
use App\Entity\Account;
use App\Entity\Transaction;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionViewModelTest extends KernelTestCase
{
    /**
     * @dataProvider fromTransactionOfAccount_provider
     */
    public function testFromTransactionOfAccount($origin, $target, $expectedAmount, $accountForMethodCall): void
    {
        $transaction = new Transaction();
        $transaction->setAmount(1);

        $transaction->setOrigin($origin);
        $transaction->setTarget($target);

        $dto = TransactionViewModel::fromTransactionOfAccount(
            $transaction,
             $accountForMethodCall
        );

        self::assertSame($expectedAmount, $dto->getAmount());

    }

    public function fromTransactionOfAccount_provider()
    {
        $kernel = self::bootKernel();
        /** @var Account $realAccount */
        $realAccount  = self::$container->get(AccountRepository::class)->find(1);
        $realAccount2 = self::$container->get(AccountRepository::class)->find(2);

        return [
            'withdraw'       => [$realAccount, null, -0.01, $realAccount],
            'deposit'        => [null, $realAccount, 0.01, $realAccount],
            'transferToMe'   => [$realAccount2, $realAccount, 0.01, $realAccount],
            'transferFromMe' => [$realAccount, $realAccount2, -0.01, $realAccount],
        ];
    }
}

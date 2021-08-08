<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\AccountHolder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $accountHolder = new AccountHolder();
        $accountHolder->setName('Max Mustermann');

        $manager->persist($accountHolder);

        $account = new Account();
        $account->setAccountHolder($accountHolder);
        $account->setIban('DE58500105172225554153');
        $account->setBalance('0');

        $manager->persist($account);

        $accountHolder2 = new AccountHolder();
        $accountHolder2->setName('Max Mustermann');

        $manager->persist($accountHolder2);

        $account2 = new Account();
        $account2->setAccountHolder($accountHolder2);
        $account2->setIban('DE26500105177733472361');
        $account2->setBalance('500000');

        $manager->persist($account2);

        $manager->flush();
    }
}

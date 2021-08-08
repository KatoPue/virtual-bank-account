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
        $accountHolder2->setName('Jane Doe');

        $manager->persist($accountHolder2);

        $account2 = new Account();
        $account2->setAccountHolder($accountHolder2);
        $account2->setIban('DE26500105177733472361');
        $account2->setBalance('500000');

        $accountHolder3 = new AccountHolder();
        $accountHolder3->setName('John Doe');

        $manager->persist($accountHolder3);

        $account3 = new Account();
        $account3->setAccountHolder($accountHolder3);
        $account3->setIban('DE8690345190340ß795723');
        $account3->setBalance('500000');

        $manager->persist($account3);

        $manager->flush();
    }
}

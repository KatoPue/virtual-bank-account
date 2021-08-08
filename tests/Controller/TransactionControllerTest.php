<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionControllerTest extends WebTestCase
{
    public function testSuccessfulResponseOfIndexAction(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/transaction/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Transaction List');
    }

    public function testSuccessfulResponseOfDepositAction(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/transaction/1/deposit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Deposit');
    }

    public function testSuccessfulResponseOfWithdrawAction(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/transaction/1/withdraw');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Withdraw');
    }

    public function testSuccessfulResponseOfTransferAction(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/transaction/1/transfer');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Transfer');
    }
}

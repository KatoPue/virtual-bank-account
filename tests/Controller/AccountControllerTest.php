<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    public function testSuccessfulResponseOfIndexAction(): void
    {
        // TODO: i do not know why this is necessary...
        // TODO: Suddenly this tes kept failing with:
        // TODO: Booting the kernel before calling "Symfony\Bundle\FrameworkBundle\Test\WebTestCase::createClient()" is not supported, the kernel should only be booted once
        static::$booted = false;

        $client = static::createClient();
        $crawler = $client->request('GET', '/account/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Account index');
    }

   public function testSuccessfulResponseOfShowAction(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/account/1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Account');
    }
}

<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    public function testSuccessfulResponseOfIndexAction(): void
    {
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

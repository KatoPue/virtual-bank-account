<?php

namespace App\Tests\DTO;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionViewModelTest extends KernelTestCase
{
    public function testSomething(): void
    {
        self::markTestIncomplete();

        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }
}

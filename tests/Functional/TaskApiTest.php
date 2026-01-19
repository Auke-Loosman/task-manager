<?php

declare(strict_types=1);

namespace Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TaskApiTest extends WebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application(self::$kernel);
        $application->setAutoExit(false);

        $application->run(new \Symfony\Component\Console\Input\ArrayInput([
            'command' => 'doctrine:schema:drop',
            '--env' => 'test',
            '--force' => true,
        ]));

        $application->run(new \Symfony\Component\Console\Input\ArrayInput([
            'command' => 'doctrine:schema:create',
            '--env' => 'test',
        ]));

        self::ensureKernelShutdown();
    }

    public function testTaskCanBeCreated(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/tasks',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['title' => 'Write assignment'])
        );

        $this->assertResponseStatusCodeSame(201);
    }
}

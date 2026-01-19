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

    public function testTasksCanBeListed(): void
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

        $client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(1, $data);
        $this->assertSame('Write assignment', $data[0]['title']);
        $this->assertSame('todo', $data[0]['status']);
    }

    public function testTaskCanBeFetchedById(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/tasks',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['title' => 'Fetch me'])
        );

        $this->assertResponseStatusCodeSame(201);

        $client->request('GET', '/tasks');
        $data = json_decode($client->getResponse()->getContent(), true);

        $id = $data[0]['id'];

        $client->request('GET', '/tasks/' . $id);

        $this->assertResponseIsSuccessful();

        $task = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame($id, $task['id']);
        $this->assertSame('Fetch me', $task['title']);
        $this->assertSame('todo', $task['status']);
    }

    public function testTaskStatusCanBeUpdated(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/tasks',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['title' => 'Patch me'])
        );

        $this->assertResponseStatusCodeSame(201);

        $client->request('GET', '/tasks');
        $tasks = json_decode($client->getResponse()->getContent(), true);

        $id = $tasks[0]['id'];

        $client->request(
            'PATCH',
            '/tasks/' . $id . '/status',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['status' => 'in_progress'])
        );

        $this->assertResponseIsSuccessful();

        $client->request(
            'PATCH',
            '/tasks/' . $id . '/status',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['status' => 'done'])
        );

        $this->assertResponseIsSuccessful();

        $client->request('GET', '/tasks/' . $id);
        $task = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame('done', $task['status']);
    }
}

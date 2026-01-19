<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query;

use App\Application\Query\Task\GetAllTasksQuery;
use App\Application\Handler\Task\GetAllTasksHandler;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class GetAllTasksHandlerTest extends TestCase
{
    public function testGetAllTasksReturnsAllTasks(): void
    {
        $tasks = [
            new Task('Task one'),
            new Task('Task two'),
        ];

        $repository = $this->createMock(TaskRepositoryInterface::class);

        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($tasks);

        $handler = new GetAllTasksHandler($repository);

        $query = new GetAllTasksQuery();

        $result = $handler($query);

        $this->assertSame($tasks, $result);
    }
}

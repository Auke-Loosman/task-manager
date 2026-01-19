<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query;

use App\Application\Query\Task\GetTaskByIdQuery;
use App\Application\Handler\Task\GetTaskByIdHandler;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class GetTaskByIdHandlerTest extends TestCase
{
    public function testGetTaskByIdReturnsTask(): void
    {
        $task = new Task('Write assignment');

        $repository = $this->createMock(TaskRepositoryInterface::class);

        $repository
            ->expects($this->once())
            ->method('findById')
            ->with('123')
            ->willReturn($task);

        $handler = new GetTaskByIdHandler($repository);

        $query = new GetTaskByIdQuery('123');

        $result = $handler($query);

        $this->assertSame($task, $result);
    }
}

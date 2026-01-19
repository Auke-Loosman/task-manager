<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command;

use App\Application\Command\Task\CreateTaskCommand;
use App\Application\Handler\Task\CreateTaskHandler;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class CreateTaskHandlerTest extends TestCase
{
    public function testCreateTaskCommandCreatesAndSavesTask(): void
    {
        $repository = $this->createMock(TaskRepositoryInterface::class);

        $repository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Task::class));

        $handler = new CreateTaskHandler($repository);

        $command = new CreateTaskCommand('Write assignment');

        $handler($command);
    }
}

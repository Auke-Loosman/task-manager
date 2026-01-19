<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task;

use App\Domain\Task\Task;
use PHPUnit\Framework\TestCase;

final class TaskTest extends TestCase
{
    public function testTaskCanBeCreatedWithTitle(): void
    {
        $task = new Task('Write assignment');

        $this->assertSame('Write assignment', $task->title());
        $this->assertSame('todo', $task->status());
    }

    public function testTaskCanBeMarkedAsInProgress(): void
    {
        $task = new Task('Write assignment');

        $task->markAsInProgress();

        $this->assertSame('in_progress', $task->status());
    }

    public function testTaskCannotBeMarkedAsDoneWhenNotInProgress(): void
    {
        $this->expectException(\DomainException::class);

        $task = new Task('Write assignment');

        $task->markAsDone();
    }

    public function testDoneTaskCannotBeDeleted(): void
    {
        $this->expectException(\DomainException::class);

        $task = new Task('Write assignment');
        $task->markAsInProgress();
        $task->markAsDone();

        $task->delete();
    }
}

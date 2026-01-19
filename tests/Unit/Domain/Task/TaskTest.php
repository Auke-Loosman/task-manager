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
}

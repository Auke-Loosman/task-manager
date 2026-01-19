<?php

declare(strict_types=1);

namespace App\Domain\Task;

final class Task
{
    private TaskId $id;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;
    private string $title;
    private string $status;

    public function __construct(string $title)
    {
        $this->id = TaskId::generate();
        $this->title = $title;
        $this->status = 'todo';
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
    }

    public static function reconstitute(
        TaskId $id,
        string $title,
        string $status,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ): self {
        $task = new self($title);

        $task->id = $id;
        $task->status = $status;
        $task->createdAt = $createdAt;
        $task->updatedAt = $updatedAt;

        return $task;
    }

    public function markAsInProgress(): void
    {
        $this->status = 'in_progress';
    }

    public function title(): string
    {
        return $this->title;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function markAsDone(): void
    {
        if ($this->status !== 'in_progress') {
            throw new \DomainException('Task must be in progress before it can be marked as done.');
        }

        $this->status = 'done';
    }

    public function delete(): void
    {
        if ($this->status === 'done') {
            throw new \DomainException('Completed tasks cannot be deleted.');
        }
    }

    public function id(): TaskId
    {
        return $this->id;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}


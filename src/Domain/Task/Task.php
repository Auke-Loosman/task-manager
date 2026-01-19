<?php

declare(strict_types=1);

namespace App\Domain\Task;

final class Task
{
    private TaskId $id;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;
    private string $title;
    private TaskStatus $status;

    public function __construct(string $title)
    {
        $this->id = TaskId::generate();
        $this->title = $title;
        $this->status = TaskStatus::TODO;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
    }

    public static function reconstitute(
        TaskId $id,
        string $title,
        TaskStatus $status,
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
        $this->status = TaskStatus::IN_PROGRESS;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function title(): string
    {
        return $this->title;
    }

    public function status(): string
    {
        return $this->status->value;
    }

    public function markAsDone(): void
    {
        if ($this->status === TaskStatus::DONE) {
            return;
        }

        if ($this->status !== TaskStatus::IN_PROGRESS) {
            throw new \DomainException('Task must be in progress before it can be marked as done.');
        }

        $this->status = TaskStatus::DONE;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function delete(): void
    {
        if ($this->status === TaskStatus::DONE) {
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


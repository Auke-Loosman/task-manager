<?php

declare(strict_types=1);

namespace App\Domain\Task;

final class Task
{
    private string $title;
    private string $status;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->status = 'todo';
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
}


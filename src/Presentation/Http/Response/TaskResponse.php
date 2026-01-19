<?php

declare(strict_types=1);

namespace App\Presentation\Http\Response;

use App\Domain\Task\Task;

final class TaskResponse
{
    public string $id;
    public string $title;
    public string $status;

    public static function fromDomain(Task $task): self
    {
        $self = new self();
        $self->id = $task->id()->value();
        $self->title = $task->title();
        $self->status = $task->status();

        return $self;
    }
}

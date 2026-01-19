<?php

declare(strict_types=1);

namespace App\Application\Handler\Task;

use App\Application\Command\Task\UpdateTaskStatusCommand;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskStatus;

final class UpdateTaskStatusHandler
{
    public function __construct(
        private TaskRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateTaskStatusCommand $command): void
    {
        $task = $this->repository->findById($command->id);

        if ($task === null) {
            throw new \DomainException('Task not found.');
        }

        match (TaskStatus::from($command->status)) {
            TaskStatus::IN_PROGRESS => $task->markAsInProgress(),
            TaskStatus::DONE => $task->markAsDone(),
            default => throw new \DomainException('Invalid status transition.')
        };

        $this->repository->save($task);
    }
}

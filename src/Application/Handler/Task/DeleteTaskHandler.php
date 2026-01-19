<?php

declare(strict_types=1);

namespace App\Application\Handler\Task;

use App\Application\Command\Task\DeleteTaskCommand;
use App\Domain\Task\TaskRepositoryInterface;

final class DeleteTaskHandler
{
    public function __construct(
        private TaskRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteTaskCommand $command): void
    {
        $task = $this->repository->findById($command->id);

        if ($task === null) {
            throw new \DomainException('Task not found');
        }

        $task->delete();

        $this->repository->remove($task);
    }
}

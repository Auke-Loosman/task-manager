<?php

declare(strict_types=1);

namespace App\Application\Handler\Task;

use App\Application\Command\Task\CreateTaskCommand;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;

final class CreateTaskHandler
{
    public function __construct(
        private TaskRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        $task = new Task($command->title);

        $this->repository->save($task);
    }
}

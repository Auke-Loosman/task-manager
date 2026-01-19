<?php

declare(strict_types=1);

namespace App\Application\Handler\Task;

use App\Application\Query\Task\GetAllTasksQuery;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;

final class GetAllTasksHandler
{
    public function __construct(
        private TaskRepositoryInterface $repository
    ) {
    }

    /** @return Task[] */
    public function __invoke(GetAllTasksQuery $query): array
    {
        return $this->repository->findAll();
    }
}

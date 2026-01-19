<?php

declare(strict_types=1);

namespace App\Application\Handler\Task;

use App\Application\Query\Task\GetTaskByIdQuery;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;

final class GetTaskByIdHandler
{
    public function __construct(
        private TaskRepositoryInterface $repository
    ) {
    }

    public function __invoke(GetTaskByIdQuery $query): ?Task
    {
        return $this->repository->findById($query->id);
    }
}

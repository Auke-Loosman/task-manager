<?php

declare(strict_types=1);

namespace App\Domain\Task;

interface TaskRepositoryInterface
{
    public function save(Task $task): void;

    public function findById(string $id): ?Task;

    /** @return Task[] */
    public function findAll(): array;

    public function remove(Task $task): void;
}

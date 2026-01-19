<?php

declare(strict_types=1);

namespace App\Application\Command\Task;

final class UpdateTaskStatusCommand
{
    public function __construct(
        public readonly string $id,
        public readonly string $status
    ) {
    }
}

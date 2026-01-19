<?php

declare(strict_types=1);

namespace App\Application\Command\Task;

use App\Application\Command\CommandInterface;

final class UpdateTaskStatusCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $status
    ) {
    }
}

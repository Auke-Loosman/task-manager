<?php

declare(strict_types=1);

namespace App\Application\Command\Task;

final class CreateTaskCommand
{
    public function __construct(
        public readonly string $title
    ) {
    }
}

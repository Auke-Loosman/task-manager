<?php

declare(strict_types=1);

namespace App\Application\Query\Task;

final class GetTaskByIdQuery
{
    public function __construct(
        public readonly string $id
    ) {
    }
}

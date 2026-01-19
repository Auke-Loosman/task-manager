<?php

declare(strict_types=1);

namespace App\Application\Query\Task;

use App\Application\Query\QueryInterface;

final class GetTaskByIdQuery implements QueryInterface
{
    public function __construct(
        public readonly string $id
    ) {
    }
}

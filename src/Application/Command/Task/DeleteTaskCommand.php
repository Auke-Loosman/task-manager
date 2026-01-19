<?php

declare(strict_types=1);

namespace App\Application\Command\Task;

final class DeleteTaskCommand
{
    public function __construct(public string $id) {}
}

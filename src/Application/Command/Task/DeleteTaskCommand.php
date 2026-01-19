<?php

declare(strict_types=1);

namespace App\Application\Command\Task;

use App\Application\Command\CommandInterface;

final class DeleteTaskCommand implements CommandInterface
{
    public function __construct(public string $id) {}
}

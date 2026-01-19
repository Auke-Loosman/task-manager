<?php

declare(strict_types=1);

namespace App\Domain\Task;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
}

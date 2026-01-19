<?php

declare(strict_types=1);

namespace App\Presentation\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateTaskStatusRequest
{
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['todo', 'in_progress', 'done'])]
    public string $status;
}

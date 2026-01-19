<?php

declare(strict_types=1);

namespace App\Presentation\Http\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateTaskRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $title;
}

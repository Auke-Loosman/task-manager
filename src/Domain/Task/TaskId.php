<?php

declare(strict_types=1);

namespace App\Domain\Task;

use Ramsey\Uuid\Uuid;

final class TaskId
{
    private function __construct(
        private string $value
    ) {
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\TaskEntity;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Task $task): void
    {
        $entity = new TaskEntity(
            id: uniqid(),
            title: $task->title(),
            status: $task->status(),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable()
        );

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?Task
    {
        return null;
    }

    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(TaskEntity::class)->findAll();

        return array_map(
            fn (TaskEntity $entity) => new Task($entity->title()),
            $entities
        );
    }
}

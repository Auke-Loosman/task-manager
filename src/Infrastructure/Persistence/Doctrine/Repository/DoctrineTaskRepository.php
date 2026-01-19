<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\TaskEntity;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Task\TaskId;

final class DoctrineTaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Task $task): void
    {
        $entity = new TaskEntity(
            id: $task->id()->value(),
            title: $task->title(),
            status: $task->status(),
            createdAt: $task->createdAt(),
            updatedAt: $task->updatedAt()
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
            fn (TaskEntity $entity) => Task::reconstitute(
                TaskId::fromString($entity->id()),
                $entity->title(),
                $entity->status(),
                $entity->createdAt(),
                $entity->updatedAt()
            ),
            $entities
        );
    }
}

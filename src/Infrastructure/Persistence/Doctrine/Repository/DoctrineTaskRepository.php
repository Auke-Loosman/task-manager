<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Entity\TaskEntity;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskStatus;

final class DoctrineTaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function save(Task $task): void
    {
        $entity = $this->entityManager
            ->getRepository(TaskEntity::class)
            ->find($task->id()->value());

        if ($entity === null) {
            $entity = TaskEntity::create(
                $task->id()->value(),
                $task->title(),
                $task->status(),
                $task->createdAt(),
                $task->updatedAt()
            );

            $this->entityManager->persist($entity);
        } else {
            $entity->setTitle($task->title());
            $entity->setStatus($task->status());
            $entity->setUpdatedAt($task->updatedAt());
        }

        $this->entityManager->flush();
    }


    public function findById(string $id): ?Task
    {
        $entity = $this->entityManager
            ->getRepository(TaskEntity::class)
            ->find($id);

        if ($entity === null) {
            return null;
        }

        return Task::reconstitute(
            TaskId::fromString($entity->id()),
            $entity->title(),
            TaskStatus::from($entity->status()),
            $entity->createdAt(),
            $entity->updatedAt()
        );
    }

    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(TaskEntity::class)->findAll();

        return array_map(
            fn (TaskEntity $entity) => Task::reconstitute(
                TaskId::fromString($entity->id()),
                $entity->title(),
                TaskStatus::from($entity->status()),
                $entity->createdAt(),
                $entity->updatedAt()
            ),
            $entities
        );
    }

    public function remove(Task $task): void
    {
        $entity = $this->entityManager
            ->getRepository(TaskEntity::class)
            ->find($task->id()->value());

        if ($entity !== null) {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        }
    }
}

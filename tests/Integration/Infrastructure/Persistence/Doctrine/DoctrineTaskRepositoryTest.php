<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Doctrine;

use App\Domain\Task\Task;
use App\Domain\Task\TaskRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\DoctrineTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineTaskRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private TaskRepositoryInterface $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $this->repository = new DoctrineTaskRepository($this->entityManager);

        $this->entityManager->createQuery('DELETE FROM App\Infrastructure\Persistence\Doctrine\Entity\TaskEntity')->execute();
    }

    public function testTaskCanBeSavedAndRetrieved(): void
    {
        $task = new Task('Write assignment');

        $this->repository->save($task);

        $this->entityManager->clear();

        $storedTask = $this->repository->findAll();

        $this->assertCount(1, $storedTask);
        $this->assertSame('Write assignment', $storedTask[0]->title());
    }
}

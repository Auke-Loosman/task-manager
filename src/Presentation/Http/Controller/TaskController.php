<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controller;

use App\Application\Command\Task\CreateTaskCommand;
use App\Presentation\Http\Request\CreateTaskRequest;
use App\Application\Query\Task\GetAllTasksQuery;
use App\Application\Query\Task\GetTaskByIdQuery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Presentation\Http\Response\TaskResponse;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'create_task', methods: ['POST'])]
    public function create(
        CreateTaskRequest $requestDto,
        ValidatorInterface $validator,
        MessageBusInterface $commandBus
    ): JsonResponse {
        $errors = $validator->validate($requestDto);

        if (count($errors) > 0) {
            return $this->json(
                ['errors' => (string) $errors],
                Response::HTTP_BAD_REQUEST
            );
        }

        $commandBus->dispatch(
            new CreateTaskCommand($requestDto->title)
        );

        return $this->json(null, Response::HTTP_CREATED);
    }

    #[Route('/tasks', name: 'get_tasks', methods: ['GET'], priority: 1)]
    public function list(MessageBusInterface $queryBus): JsonResponse
    {
        $envelope = $queryBus->dispatch(new GetAllTasksQuery());

        $tasks = $envelope
            ->last(HandledStamp::class)
            ->getResult();

        return $this->json(
            array_map(
                fn ($task) => TaskResponse::fromDomain($task),
                $tasks
            )
        );
    }

    #[Route('/tasks/{id}', name: 'get_task', methods: ['GET'])]
    public function get(string $id, MessageBusInterface $queryBus): JsonResponse
    {
        $envelope = $queryBus->dispatch(new GetTaskByIdQuery($id));

        $task = $envelope
            ->last(HandledStamp::class)
            ?->getResult();

        if ($task === null) {
            throw new NotFoundHttpException('Task not found');
        }

        return $this->json(
            TaskResponse::fromDomain($task)
        );
    }
}

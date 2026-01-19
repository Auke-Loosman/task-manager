<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controller;

use App\Application\Command\Task\CreateTaskCommand;
use App\Presentation\Http\Request\CreateTaskRequest;
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
}

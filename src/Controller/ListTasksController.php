<?php

namespace App\Controller;

use App\Dto\TaskInput;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'task_list', methods: ['GET'])]
class ListTasksController extends AbstractController
{
    public function __invoke(TaskRepository $taskRepository): Response
    {
        $form = $this->createForm(TaskType::class, new TaskInput(), [
            'action' => $this->generateUrl(CreateTaskController::ROUTE_NAME),
        ]);

        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAllNewestFirst(),
            'form' => $form,
        ]);
    }
}

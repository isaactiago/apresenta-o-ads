<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\CompleteTaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarefas/{id}/concluir', name: 'task_complete', requirements: ['id' => '\d+'], methods: ['POST'])]
class CompleteTaskController extends AbstractController
{
    public function __invoke(Task $task, CompleteTaskService $completeTaskService): Response
    {
        $completeTaskService->execute($task);
        $this->addFlash('success', 'Tarefa concluida!');

        return $this->redirectToRoute(ListTasksController::ROUTE_NAME, status: Response::HTTP_SEE_OTHER);
    }
}

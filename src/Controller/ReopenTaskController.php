<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\ReopenTaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarefas/{id}/reabrir', name: 'task_reopen', requirements: ['id' => '\d+'], methods: ['POST'])]
class ReopenTaskController extends AbstractController
{
    public function __invoke(Task $task, ReopenTaskService $reopenTaskService): Response
    {
        $reopenTaskService->execute($task);
        $this->addFlash('success', 'Tarefa reaberta.');

        return $this->redirectToRoute('task_list', status: Response::HTTP_SEE_OTHER);
    }
}

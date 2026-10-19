<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

#[Route('/tarefas/{id}/reabrir', name: 'task_reopen', requirements: ['id' => '\d+'], methods: ['POST'])]
class ReopenTaskController extends AbstractController
{
    #[IsCsrfTokenValid(new Expression('"task_reopen_" ~ args["task"].getId()'))]
    public function __invoke(Task $task, TaskManager $taskManager): Response
    {
        $taskManager->reopen($task);
        $this->addFlash('success', 'Tarefa reaberta.');

        return $this->redirectToRoute('task_list', status: Response::HTTP_SEE_OTHER);
    }
}

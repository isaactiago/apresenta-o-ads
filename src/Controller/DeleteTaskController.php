<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

#[Route('/tarefas/{id}/excluir', name: 'task_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
class DeleteTaskController extends AbstractController
{
    #[IsCsrfTokenValid(new Expression('"task_delete_" ~ args["task"].getId()'))]
    public function __invoke(Task $task, TaskManager $taskManager): Response
    {
        $taskManager->delete($task);
        $this->addFlash('success', 'Tarefa excluída.');

        return $this->redirectToRoute('task_list', status: Response::HTTP_SEE_OTHER);
    }
}

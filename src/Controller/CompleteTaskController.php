<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\CompleteTaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

#[Route('/tarefas/{id}/concluir', name: 'task_complete', requirements: ['id' => '\d+'], methods: ['POST'])]
class CompleteTaskController extends AbstractController
{
    #[IsCsrfTokenValid(new Expression('"task_complete_" ~ args["task"].getId()'))]
    public function __invoke(Task $task, CompleteTaskService $completeTaskService): Response
    {
        $completeTaskService->execute($task);
        $this->addFlash('success', 'Tarefa concluida!');

        return $this->redirectToRoute('task_list', status: Response::HTTP_SEE_OTHER);
    }
}

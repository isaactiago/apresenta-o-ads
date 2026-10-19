<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\DeleteTaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarefas/{id}/excluir', name: 'task_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
class DeleteTaskController extends AbstractController
{
    public function __invoke(Task $task, DeleteTaskService $deleteTaskService): Response
    {
        $deleteTaskService->execute($task);
        $this->addFlash('success', 'Tarefa excluida.');

        return $this->redirectToRoute('task_list', status: Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Dto\TaskInput;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Service\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarefas', name: 'task_create', methods: ['POST'])]
class CreateTaskController extends AbstractController
{
    public function __invoke(Request $request, TaskManager $taskManager, TaskRepository $taskRepository): Response
    {
        $input = new TaskInput();
        $form = $this->createForm(TaskType::class, $input, [
            'action' => $this->generateUrl('task_create'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskManager->create($input);
            $this->addFlash('success', 'Tarefa cadastrada com sucesso!');

            return $this->redirectToRoute('task_list', status: Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('error', 'Não foi possível cadastrar a tarefa. Verifique os campos.');

        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAllNewestFirst(),
            'form' => $form,
        ]);
    }
}

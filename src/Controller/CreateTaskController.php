<?php

namespace App\Controller;

use App\Dto\TaskInput;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Service\CreateTaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarefas', name: self::ROUTE_NAME, methods: ['POST'])]
class CreateTaskController extends AbstractController
{
    public const string ROUTE_NAME = 'task_create';

    public function __invoke(
        Request $request,
        CreateTaskService $createTaskService,
        TaskRepository $taskRepository,
    ): Response {
        $input = new TaskInput();
        $form = $this->createForm(TaskType::class, $input, [
            'action' => $this->generateUrl(self::ROUTE_NAME),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createTaskService->execute($input);
            $this->addFlash('success', 'Tarefa cadastrada com sucesso!');

            return $this->redirectToRoute('task_list', status: Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('error', 'Nao foi possivel cadastrar a tarefa. Verifique os campos.');

        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAllNewestFirst(),
            'form' => $form,
        ]);
    }
}

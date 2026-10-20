<?php

namespace App\Controller;

use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: self::ROUTE_NAME, methods: ['GET'])]
class ListTasksController extends AbstractController
{
    public const string ROUTE_NAME = 'task_list';

    public function __invoke(TaskRepository $taskRepository): Response
    {
        try {
            $form = $this->createForm(type: TaskType::class, options: [
                'action' => $this->generateUrl(CreateTaskController::ROUTE_NAME),
            ]);
        } catch (\Throwable) {
             $this->addFlash(type: 'error', message: 'Erro ao listar, favor entrar em contato com carlos');
        }

        return $this->render(view: 'task/index.html.twig', parameters: [
            'tasks' => $taskRepository->findAllNewestFirst(),
            'form' => $form ?? null,
        ]);
    }
}

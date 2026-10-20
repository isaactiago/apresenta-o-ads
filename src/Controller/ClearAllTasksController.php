<?php

namespace App\Controller;

use App\Service\ClearAllTasksService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tarefas/limpar-todas', name: self::ROUTE_NAME, methods: ['POST'])]
class ClearAllTasksController extends AbstractController
{
    public const string ROUTE_NAME = 'task_clear_all';

    public function __invoke(Request $request, ClearAllTasksService $clearAllTasksService): Response
    {
        $token = $request->request->getString('_token');
        if ($this->isCsrfTokenValid('task_clear_all', $token)) {
            $clearAllTasksService->execute();
            $this->addFlash('success', 'Todas as tarefas foram excluídas com sucesso.');
        } else {
            $this->addFlash('error', 'Token de segurança inválido. Não foi possível limpar as tarefas.');
        }
        
        return $this->redirectToRoute(
            route: ListTasksController::ROUTE_NAME,
            status: Response::HTTP_SEE_OTHER
        );
    }
}

<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClearAllTasksControllerTest extends WebTestCase
{
    public function testRouteRejectsGetMethod(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tarefas/limpar-todas');

        $this->assertResponseStatusCodeSame(405);
    }

    public function testClearAllWithInvalidCsrfRedirectsWithError(): void
    {
        $client = static::createClient();
        $client->request('POST', '/tarefas/limpar-todas', [
            '_token' => 'invalid_token',
        ]);

        $this->assertResponseRedirects('/');
        $client->followRedirect();
        $this->assertSelectorTextContains('.alert-error', 'Token de segurança inválido');
    }

    public function testClearAllSuccessfullyClearsAllTasks(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        // Prepara dados de teste
        $task1 = new Task('Tarefa 1', 'Descricao 1');
        $task2 = new Task('Tarefa 2', 'Descricao 2');
        $em->persist($task1);
        $em->persist($task2);
        $em->flush();

        // Acessa a página principal
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.list-title', 'Tarefas');
        $this->assertSelectorTextContains('.counter', '2');

        // Submete o formulário "Limpar todas"
        $form = $crawler->selectButton('Limpar todas')->form();
        $client->submit($form);

        $this->assertResponseRedirects('/');
        $crawlerAfter = $client->followRedirect();

        // Confirma mensagem de sucesso e lista vazia
        $this->assertSelectorTextContains('.alert-success', 'Todas as tarefas foram excluídas com sucesso.');
        $this->assertSelectorTextContains('.empty-state', 'Nenhuma tarefa por aqui ainda.');

        // Verifica que no banco o total de tarefas é 0
        $tasksInDb = $em->getRepository(Task::class)->findAll();
        $this->assertCount(0, $tasksInDb);
    }
}

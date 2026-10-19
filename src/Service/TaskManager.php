<?php

namespace App\Service;

use App\Dto\TaskInput;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param TaskInput $input dados já validados pelo formulário
     *
     * @return Task a tarefa persistida no banco
     */
    public function create(TaskInput $input): Task
    {
        $description = trim($input->description ?? '');

        $task = new Task(trim($input->title), '' === $description ? null : $description);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    public function complete(Task $task): void
    {
        $task->complete();
        $this->entityManager->flush();
    }

    public function reopen(Task $task): void
    {
        $task->reopen();
        $this->entityManager->flush();
    }

    public function delete(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}

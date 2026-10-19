<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;

class CompleteTaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function execute(Task $task): Task
    {
        $task->complete();

        return $this->taskRepository->save($task);
    }
}

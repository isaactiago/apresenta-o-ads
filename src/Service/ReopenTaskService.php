<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;

class ReopenTaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function execute(Task $task): Task
    {
        $task->reopen();

        return $this->taskRepository->save($task);
    }
}

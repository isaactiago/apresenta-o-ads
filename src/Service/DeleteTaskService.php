<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;

class DeleteTaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function execute(Task $task): void
    {
        $this->taskRepository->remove($task);
    }
}

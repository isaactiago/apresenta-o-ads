<?php

namespace App\Service;

use App\Repository\TaskRepository;

class ClearAllTasksService
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function execute(): int
    {
        return $this->taskRepository->removeAll();
    }
}

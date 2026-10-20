<?php

namespace App\Service;

use App\DTO\TaskInputDTO;
use App\Entity\Task;
use App\Repository\TaskRepository;

class CreateTaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function execute(TaskInputDTO $input): Task
    {
        $description = trim($input->description ?? '');

        $task = new Task(
            trim($input->title),
            '' === $description ? null : $description,
        );

        return $this->taskRepository->save($task);
    }
}

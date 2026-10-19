<?php

namespace App\Service;

use App\Dto\TaskInput;
use App\Entity\Task;
use App\Repository\TaskRepository;

class CreateTaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function execute(TaskInput $input): Task
    {
        $description = trim($input->description ?? '');

        $task = new Task(
            trim($input->title),
            '' === $description ? null : $description,
        );

        return $this->taskRepository->save($task);
    }
}

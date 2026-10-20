<?php

namespace App\Tests\Service;

use App\Repository\TaskRepository;
use App\Service\ClearAllTasksService;
use PHPUnit\Framework\TestCase;

class ClearAllTasksServiceTest extends TestCase
{
    public function testExecuteCallsRepositoryRemoveAll(): void
    {
        $repository = $this->createMock(TaskRepository::class);
        $repository->expects($this->once())
            ->method('removeAll')
            ->willReturn(5);

        $service = new ClearAllTasksService($repository);
        $deletedCount = $service->execute();

        $this->assertSame(5, $deletedCount);
    }
}

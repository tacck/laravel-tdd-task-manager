<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testGetTaskDetailNotExists()
    {
        $tasks = Task::find(0);
        $this->assertNull($tasks);
    }

    public function testUpdateTask()
    {
        $task = Task::create([
            'title' => 'test',
            'executed' => false,
        ]);

        $this->assertEquals('test', $task->title);
        $this->assertFalse($task->executed);

        $task->fill(['title' => 'テスト']);
        $task->save();

        $task2 = Task::find($task->id);
        $this->assertEquals('テスト', $task2->title);
    }
}
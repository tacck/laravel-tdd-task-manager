<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * Get Seeder Tasks Test
     *
     * @return void
     */
    public function testGetSeederTasks()
    {
        // 全件取得
        $tasks = Task::all();
        // 3件取得できるはず
        $this->assertEquals(3, count($tasks));

        // 実行完了していないものを取得
        $taskNotFinished = Task::where('executed', false)->get();
        // 2件取得できるはず
        $this->assertEquals(2, count($taskNotFinished));

        // 実行完了しているものを取得
        $taskFinished = Task::where('executed', true)->get();
        // 1件取得できるはず
        $this->assertEquals(1, count($taskFinished));

        // 「テストタスク」というタイトルのレコードを取得
        $task1 = Task::where('title', "テストタスク")->first();
        // 実行完了していないはず
        $this->assertFalse(boolval($task1->executed));

        // 「終了タスク」というタイトルのレコードを取得
        $task1 = Task::where('title', "終了タスク")->first();
        // 実行完了しているはず
        $this->assertTrue(boolval($task1->executed));
    }

    public function testGetTaskDetail() {
        $tasks = Task::find(2);
        $this->assertEquals('テストタスク', $tasks->title);
    }

    public function testGetTaskDetailNotExists() {
        $tasks = Task::find(0);
        $this->assertNull($tasks);
    }
}

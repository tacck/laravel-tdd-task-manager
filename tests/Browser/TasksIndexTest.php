<?php

namespace Tests\Browser;

use App\Task;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksIndexTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $task;

    protected function setUp()
    {
        parent::setUp();
        $this->task = Task::create([
            'title' => 'テストタスク',
            'executed' => false,
        ]);
    }

    /**
     * Tasks Index Test.
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                ->assertSee('テストタスク')
                ->screenshot("tasks_index");
        });
    }

    /**
     * Index To Detail Test.
     *
     * @throws \Throwable
     */
    public function testIndexToDetail() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                ->assertSeeLink('テストタスク')
                ->clickLink('テストタスク')
                ->waitForLocation('/tasks/' . $this->task->id, 1)
                ->assertPathIs('/tasks/' . $this->task->id)
                ->assertInputValue('#title', 'テストタスク');
        });
    }

    /**
     * Index To New Test.
     *
     * @throws \Throwable
     */
    public function testIndexToNew() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks')
                ->assertSeeLink('新規追加')
                ->clickLink('新規追加')
                ->waitForLocation('/tasks/new')
                ->assertPathIs('/tasks/new');
        });
    }
}

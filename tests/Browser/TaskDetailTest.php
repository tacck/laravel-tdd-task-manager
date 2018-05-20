<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskDetailTest extends DuskTestCase
{
    /**
     * Task Detail Test.
     *
     * @throws \Throwable
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/2')
                ->assertSee('テストタスク')
                ->screenshot("task_detail");
        });
    }
}

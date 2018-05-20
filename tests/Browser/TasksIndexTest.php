<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksIndexTest extends DuskTestCase
{
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
                ->waitForLocation('/tasks/2', 1)
                ->assertPathIs('/tasks/2')
                ->assertSee('テストタスク');
        });
    }
}

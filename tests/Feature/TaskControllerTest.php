<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

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
     * Get All Tasks Path Test
     *
     * @return void
     */
    public function testGetAllTasksPath()
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    /**
     * Get Task Detail Path Test
     *
     * @return void
     */
    public function testGetTaskPath()
    {
        $response = $this->get('/tasks/' . $this->task->id);

        $response->assertStatus(200);
    }

    /**
     * Get Task Detail Path Not Exists Test
     *
     * @return void
     */
    public function testGetTaskPathNotExists()
    {
        $response = $this->get('/tasks/0');

        $response->assertStatus(404);
    }

    /**
     * Put Task Detail Path Test
     *
     * @return void
     */
    public function testPutTaskPath()
    {
        $data = [
            'title' => 'test title',
        ];
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->put('/tasks/' . $this->task->id, $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/' . $this->task->id);

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Put Task Detail Path Test 2
     *
     * @return void
     */
    public function testPutTaskPath2()
    {
        $data = [
            'title' => 'テストタスク2',
            'executed' => true,
        ];
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->put('/tasks/' . $this->task->id, $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/' . $this->task->id);

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Get New Task Path Test
     *
     * @return void
     */
    public function testGetNewTaskPath()
    {
        $response = $this->get('/tasks/new');

        $response->assertStatus(200);
    }

    /**
     * Post Task Path Test
     *
     * @return void
     */
    public function testPostTaskPath()
    {
        $data = [
            'title' => 'test title',
        ];
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->post('/tasks/', $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/');

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Post Task Path Test (Without Title)
     *
     * @return void
     */
    public function testPostTaskPathWithoutTitle_failed()
    {
        $data = [];
        $response = $this->from('/tasks/new')
            ->post('/tasks/', $data);

        $response->assertSessionHasErrors(['title' => 'The title field is required.']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/new');
    }

    /**
     * Post Task Path Test (Empty Title)
     *
     * @return void
     */
    public function testPostTaskPathEmptyTitle_failed()
    {
        $data = [
            'title' => ''
        ];
        $response = $this->from('/tasks/new')
            ->post('/tasks/', $data);

        $response->assertSessionHasErrors(['title' => 'The title field is required.']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/new');
    }

    /**
     * Post Task Path Test (Max Length)
     *
     * @return void
     */
    public function testPostTaskPathTitleMaxLength()
    {
        $data = [
            'title' => str_random(512)
        ];

        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->post('/tasks/', $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/');

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Post Task Path Test (Max Length + 1)
     *
     * @return void
     */
    public function testPostTaskPathTitleMaxLengthPlus1_failed()
    {
        $data = [
            'title' => str_random(513)
        ];

        $response = $this->from('/tasks/new')
            ->post('/tasks/', $data);

        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 512 characters.']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/new');
    }
}

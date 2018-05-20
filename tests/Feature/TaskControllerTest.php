<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
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
        $response = $this->get('/tasks/1');

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
}

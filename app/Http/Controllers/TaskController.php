<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function detail(int $id)
    {
        $task = Task::find($id);
        if ($task === null) {
            abort(404);
        }

        return view('tasks.detail', ['task' => $task]);
    }

    public function update(int $id)
    {
        return redirect('/tasks/' . $id);
    }
}

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

    public function update(int $id, Request $request)
    {
        $task = Task::find($id);
        if ($task === null) {
            abort(404);
        }

        $fillData = [];
        if (isset($request->title)) {
            $fillData['title'] = $request->title;
        }
        if (isset($request->executed)) {
            $fillData['executed'] = $request->executed;
        }

        if (count($fillData) > 0) {
            $task->fill($fillData);
            $task->save();
        }

        return redirect('/tasks/' . $id);
    }
}

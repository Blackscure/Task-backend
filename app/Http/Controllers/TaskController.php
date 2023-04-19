<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks=Task::paginate(10);
        //
        return response()
            ->json($tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'status_id'=>'required',
            'due_date'=>'required'
        ]);
        if ($validate->fails()) {
            return response()
                ->json($validate->errors(), 400);
        }
        $task=Task::create($request->all());
        return response()
            ->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task=Task::find($id);
        if (is_null($task)) {
            return response()
                ->json(['message'=>'Task not found'], 404);
        }
        return response()
            ->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task=Task::find($id);
        if (is_null($task)) {
            return response()
                ->json(['message'=>'Task not found'], 404);
        }
        $task->update($request->all());
        return response()
            ->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task=Task::find($id);
        if (is_null($task)) {
            return response()
                ->json(['message'=>'Task not found'], 404);
        }
        $task->delete();
        return response()
            ->json(null, 204);
    }
}

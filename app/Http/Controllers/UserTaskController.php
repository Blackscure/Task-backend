<?php

namespace App\Http\Controllers;

use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user_tasks=UserTask::paginate(10);
        return response()
            ->json($user_tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated=Validator::make($request->all(),[
            'user_id'=>'required|exists:users,id',
            'task_id'=>'required|exists:tasks,id',
            'status_id'=>'required|exists:statuses,id',
        ]);
        if ($validated->fails()) {
            return response()
                ->json($validated->errors(), 400);
        }
        $user_task=UserTask::create($request->all());
        return response()
            ->json($user_task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user_task=UserTask::find($id);
        if (is_null($user_task)) {
            return response()
                ->json(['message'=>'UserTask not found'], 404);
        }
        return response()
            ->json($user_task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user_task=UserTask::find($id);
        if (is_null($user_task)) {
            return response()
                ->json(['message'=>'UserTask not found'], 404);
        }
        $validated=Validator::make($request->all(),[
            'user_id'=>'required|exists:users,id',
            'task_id'=>'required|exists:tasks,id',
            'status_id'=>'required|exists:statuses,id',
        ]);
        if ($validated->fails()) {
            return response()
                ->json($validated->errors(), 400);
        }
        $user_task->update($request->all());
        return response()
            ->json($user_task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user_task=UserTask::find($id);
        if (is_null($user_task)) {
            return response()
                ->json(['message'=>'UserTask not found'], 404);
        }
        $user_task->delete();
        return response()
            ->json(null, 204);
    }
}

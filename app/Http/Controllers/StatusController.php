<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
        $validated=Validator::make($request->all(),[
            'name'=>'required',
        ]);
        if ($validated->fails()) {
            return response()
                ->json($validated->errors(), 400);
        }
        $status=Status::create($request->all());
        return response()
            ->json($status, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $status=Status::find($id);
        if (is_null($status)) {
            return response()
                ->json(['message'=>'Status not found'], 404);
        }
        return response()
            ->json($status, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $status=Status::find($id);
        if (is_null($status)) {
            return response()
                ->json(['message'=>'Status not found'], 404);
        }
        $status->update($request->all());
        return response()
            ->json($status, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $status=Status::find($id);
        if (is_null($status)) {
            return response()
                ->json(['message'=>'Status not found'], 404);
        }
        $status->delete();
        return response()
            ->json(null, 204);
    }
}

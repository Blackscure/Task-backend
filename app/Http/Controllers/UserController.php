<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::paginate(10);
        //
        return response()
            ->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'email_address'=>'required|email|unique:users',
            'password'=>'required|min:8'
        ]);
        if ($validate->fails()) {
            return response()
                ->json($validate->errors(), 400);
        }
        $user=User::create($request->all());
        return response()
            ->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::find($id);
        if (is_null($user)) {
            return response()
                ->json(['message'=>'User not found'], 404);
        }
        return response()
            ->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user=User::find($id);
        if (is_null($user)) {
            return response()
                ->json(['message'=>'User not found'], 404);
        }
        $validate=Validator::make($request->all(),[
            'email_address'=>'required|email|unique:users',
            'password'=>'required|min:8'
        ]);
        if ($validate->fails()) {
            return response()
                ->json($validate->errors(), 400);
        }
        $user->update($request->all());
        return response()
            ->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::find($id);
        if (is_null($user)) {
            return response()
                ->json(['message'=>'User not found'], 404);
        }
        $user->delete();
        return response()
            ->json(null, 204);
    }
}

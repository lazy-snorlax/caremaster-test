<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::get();
        return UserResource::collection($users->load('role'));
    }

    public function show(string $user) {
        return new UserResource(User::find($user)->load('role'));
    }

    public function store(Request $request) {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);
        $user->assign('user'); // New users default to User role
        return new UserResource($user->load('role'));
    }

    public function update(Request $request, User $user) {
        $user->fill($request->only(['name', 'email', 'status']));
        $user->save();

        $user->retract('admin');
        $user->assign(strtolower($request->input('role')));
        return new UserResource($user->load('role'));
    }

    public function destroy(User $user) {
        $user->delete();
        return response()->noContent();
    }
}
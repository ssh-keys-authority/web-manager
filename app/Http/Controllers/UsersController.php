<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserStoreRequest $request)
    {
        $values = $request->validated();

        $user = User::create(
            [
                'name' => $values['name'],
                'last_name' => $values['last_name'],
                'email' => $values['email'],
                'password' => Hash::make($values['password']),
            ]
        );

        $user->markEmailAsVerified();

        return redirect(route('user.show', $user));
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function destroy(User $user)
    {
        //
    }
}

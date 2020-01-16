<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeyStoreRequest;
use App\Key;
use App\User;

class KeysController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store(KeyStoreRequest $request, User $user)
    {
        $values = $request->validated();

        $user->keys()
            ->create(
                [
                    'name' => $values['name'],
                    'key' => $values['key']
                ]
            );

        return redirect(route('user.show', $user));
    }

    public function destroy(User $user, Key $key)
    {
        $key->delete();

        return redirect(route('user.show', $user))
            ->with('key.destroyed', $key->name);
    }
}

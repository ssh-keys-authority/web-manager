<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeyStoreRequest;
use App\Key;

class KeysController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store(KeyStoreRequest $request)
    {
        $values = $request->validated();
    }

    public function destroy(Key $key)
    {
        //
    }
}

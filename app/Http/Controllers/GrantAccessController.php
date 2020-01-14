<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrantAccessSyncRequest;
use App\Server;

class GrantAccessController extends Controller
{
    public function sync(GrantAccessSyncRequest $request, Server $server)
    {
        $values = $request->validated();

        foreach ($server->accounts as $account) {
            $users = !empty($values['access'][$account->id]) ? $values['access'][$account->id] : [];

            $account->users()->sync($users);
        }

        return back();
    }
}

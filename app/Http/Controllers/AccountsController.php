<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\AccountStoreRequest;
use App\Server;

class AccountsController extends Controller
{
    public function store(AccountStoreRequest $request, Server $server)
    {
        $values = $request->validated();

        $server->accounts()
            ->create(
                [
                    'name' => $values['name']
                ]
            );

        return redirect(route('server.show', $server));
    }

    public function destroy(Server $server, Account $account)
    {
        $account->delete();

        return redirect(route('server.show', $server))
            ->with('account.destroyed', $account->name);
    }
}

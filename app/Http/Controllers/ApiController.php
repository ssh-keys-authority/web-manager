<?php

namespace App\Http\Controllers;

use App\Account;
use App\Server;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function setup(Server $server)
    {
        $users = [];
        foreach ($server->accounts as $account) {
            $users[] = '/usr/local/bin/ssh-authority-manager add --username='.$account->name.' --apikey='.$account->uuid;
        }

        return str_replace(
            [
                '{{baseDomain}}',
                '{{serverKey}}',
                '{{users}}',
            ],
            [
                trim(config('app.url'), '/'),
                $server->uuid,
                implode(PHP_EOL, $users)
            ],
            file_get_contents(base_path('resources/stubs/Install.stub'))
        );
    }

    public function keys(Server $server, Account $account)
    {
        $response = [
            '# START SSH Keys Authority Managed Keys File'
        ];

        foreach ($account->users as $role) {
            foreach ($role->keys as $key) {
                $response[] = $key->key;
            }
        }

        $response[] = '# END SSH Keys Authority Managed Keys File';

        $account->update(['last_sync' => Carbon::now()]);
        $server->update(['last_sync' => Carbon::now()]);

        return implode(PHP_EOL, $response);
    }
}

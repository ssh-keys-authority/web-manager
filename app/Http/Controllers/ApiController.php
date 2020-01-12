<?php

namespace App\Http\Controllers;

use App\Server;

class ApiController extends Controller
{
    public function setup(Server $server)
    {
        $users = [];
        foreach ($server->users as $user) {
            $users[] = '/usr/local/bin/server-client add --username='.$user->name.' --apikey='.$user->uuid;
        }

        return str_replace(
            [
                '{{baseDomain}}',
                '{{serverKey}}',
                '{{users}}',
            ],
            [
                config('app.url'),
                $server->uuid,
                implode(PHP_EOL, $users)
            ],
            file_get_contents(base_path('resources/stubs/Install.stub'))
        );
    }
}

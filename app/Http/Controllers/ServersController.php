<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\ServerStoreRequest;
use App\OperatingSystem;
use App\Server;
use App\User;

class ServersController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        $servers = Server::all();

        return view('server.index', compact('servers'));
    }

    public function create()
    {
        $systemOs = OperatingSystem::all();

        return view('server.create', compact('systemOs'));
    }

    public function store(ServerStoreRequest $request)
    {
        $values = $request->validated();

        $server = Server::create(
            [
                'name' => $values['name'],
                'operatingsystem_id' => $values['system_os']
            ]
        );

        $users = [];
        foreach ($values['users'] as $user) {
            $users[] = new Account(['name' => $user]);
        }

        $server->accounts()->saveMany($users);

        return redirect(route('server.show', $server));
    }

    public function show(Server $server)
    {
        $users = User::all();

        return view('server.show', compact('server', 'users'));
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return redirect(route('server.index'))
            ->with('server.destroyed', 'success');
    }
}

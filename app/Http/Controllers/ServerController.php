<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServerStoreRequest;
use App\OperatingSystem;
use App\Server;
use App\ServerUser;
use Illuminate\Http\Request;

class ServerController extends Controller
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
            $users[] = new ServerUser(['name' => $user]);
        }

        $server->users()->saveMany($users);

        return redirect(route('server.show', $server));
    }

    public function show(Server $server)
    {
        return view('server.show', compact('server'));
    }

    public function edit(Server $server)
    {
        return view('server.edit');
    }

    public function update(Request $request, Server $server)
    {
        //
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return redirect(route('server.index'))
            ->with('server.destroyed', 'success');
    }
}

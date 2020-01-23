@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Server') }} {{ $server->name }}</h1>
        <a href="{{ route('server.index') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> {{ __('Back to list') }}</a>
    </div>

    @if ($user = session('account.destroyed'))
        <div class="alert alert-success">
            <h4 class="alert-heading">{{ __('Account deleted') }}</h4>

            <p>{{ __('To complete, you need to run the following command on the server:') }}</p>

            <pre>sudo ssh-authority-manager remove --username={{ $user }}</pre>
        </div>
    @endif

    @foreach($server->accounts()->whereNull('last_sync')->get() as $account)
        <div class="alert alert-success">
            <p>{{ __('It looks like you have not finished setting up some server accounts. Please run the following command to complete the installation') }}</p>

            <pre>sudo ssh-authority-manager add --username={{ $account->name }} --apikey={{ $account->uuid }} && sudo ssh-authority-manager sync</pre>
        </div>
    @endforeach

    @component('components.card')
        @slot('title')
            {{ __('Server management') }}
        @endslot
        @slot('actions')
            <a href="#" data-toggle="modal" data-target="#destroyServer" class="btn btn-sm btn-danger shadow-sm">
                <i class="fas fa-trash fa-sm mr-1 text-white-50"></i> {{ __('Delete') }}</a>
        @endslot

        @if($server->isActivated())
            <table class="table">
                <tr>
                    <td>{{ __('Server') }}</td>
                    <td>{{ $server->name }}</td>
                </tr>
                <tr>
                    <td>{{ __('Status') }}</td>
                    <td>
                        {{ __('Last Update') }} {{ $server->last_sync->diffForHumans() }}
                    </td>
                </tr>
                <tr>
                    <td>{{ __('Operating System') }}</td>
                    <td>{{ $server->system->name }}</td>
                </tr>
            </table>
        @else
            <p>{{ __('To complete the configuration, you need to install a client on the server that will periodically update your SSH keys') }}</p>
            <p>{{ __('The client does not give access to the server and does not interfere with its operation') }}</p>

            <h2>{{ __('Installation on', ['system' => $server->system->name]) }}</h2>

            <p>{{ __('To install the client and configure the server to work with the system accounts that you have already specified, log in as the root user and run the following command:') }}</p>

            <pre>sudo bash -c "$(curl -L {{ trim(config('app.url'), '/') }}/api/v1/setup/{{ $server->uuid }}/install.sh)"</pre>

            <h3>{{ __('What\'s next?') }}</h3>
            <p>{{ __('After executing the command, it will inform you that the installation has completed. After that, you can refresh this page to manage the server') }}</p>
            <p>{{ __('If your installation was not completed (or completed, but you still see this screen), please check for errors in the installer') }}</p>
        @endif
    @endcomponent

    @if($server->isActivated())
        @component('components.card')
            @slot('title')
                {{ __('Accounts management') }}
            @endslot
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Account') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th></th>
                </tr>
                </thead>
                @foreach($server->accounts as $account)
                    <tr>
                        <td>{{ $account->name }}</td>
                        <td>
                            @if($account->isActivated())
                                <span class="badge badge-pill badge-success py-2 px-3">
                                    <i class="fas fa-check-circle text-white-50 mr-1"></i>
                                    {{ $account->last_sync->diffForHumans() }}
                                </span>
                            @else
                                <span class="badge badge-pill badge-danger py-2 px-3">
                                    <i class="fas fa-times-circle text-white-50 mr-1"></i>
                                    {{ __('Account not configured') }}
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="#" data-toggle="modal" data-target="#destroyAccount-{{ $account->id }}"
                               class="btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-trash fa-sm mr-1 text-white-50"></i> {{ __('Delete') }}</a>
                        </td>
                    </tr>
                @endforeach
            </table>

            <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#storeAccount" role="button"
                   aria-expanded="false" aria-controls="storeAccount">
                    {{ __('New Account') }}
                </a>
            </p>
            <div class="collapse @if($errors->any()) show @endif" id="storeAccount">
                <div class="card card-body">
                    <form method="POST" action="{{ route('account.store', $server) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">{{ __('Account name') }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="name"
                                       class="form-control @error('last_name') is-invalid @enderror"
                                       id="name" value="{{ old('name') }}" required>
                                <small class="form-text text-muted">
                                    {{ __('The account on the server for which you want to configure access control') }}
                                </small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Add Account') }}</button>
                    </form>
                </div>
            </div>
        @endcomponent

        @component('components.card')
            @slot('title')
                {{ __('Team management') }}
            @endslot
            <form action="{{ route('grant-access.sync', $server) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('User') }}</th>
                                @foreach($server->accounts as $account)
                                    <th>{{ $account->name }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->full_name }}</td>
                                    @foreach($server->accounts as $account)
                                        <td>
                                            <input type="checkbox" name="access[{{$account->id}}][]"
                                                   value="{{ $user->id }}"
                                                   @if(!$account->isActivated()) disabled @endif
                                                   @if($account->users->contains($user->id)) checked @endif
                                            />
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Update Permissions') }}</button>
            </form>
        @endcomponent
    @endif

    <div class="modal fade" id="destroyServer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('server.destroy', $server) }}">
                @method('delete')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Вы уверены?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Закрыть">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">{{ __('After uninstallation, the :what cannot be restored',
                        ['what' => __('Server')]) }}</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                                data-dismiss="modal">{{ __('I changed my mind') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach($server->accounts as $account)
        <div class="modal fade" id="destroyAccount-{{ $account->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" action="{{ route('account.destroy', [$server, $account]) }}">
                    @method('delete')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Вы уверены?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Закрыть">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">После удаления, аккаунт невозможно будет воостановить.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Я передумал</button>
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection

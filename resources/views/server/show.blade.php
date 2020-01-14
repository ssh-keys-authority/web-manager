@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Сервер {{ $server->name }}</h1>
        <a href="{{ route('server.index') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-list fa-sm text-white-50"></i> Вернуться к списку</a>
    </div>

    @if ($user = session('account.destroyed'))
        <div class="alert alert-success">
            <h4 class="alert-heading">Аккаунт удален</h4>

            <p>Для завершения вам необходимо выполнить на сервере следующую команду:</p>

            <pre>sudo ssh-authority-manager remove --username={{ $user }}</pre>
        </div>
    @endif

    @foreach($server->accounts()->whereNull('last_sync')->get() as $account)
        <div class="alert alert-success">
            <p>Похоже, вы не закончили настройку некоторых учетных записей сервера. Пожалуйста, выполните следующую
                команду, чтобы завершить установку.</p>

            <pre>sudo ssh-authority-manager add --username={{ $account->name }} --apikey={{ $account->uuid }} && sudo ssh-authority-manager sync</pre>
        </div>
    @endforeach

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Управление сервером</h6>
            <a href="#" data-toggle="modal" data-target="#destroyModal" class="btn btn-sm btn-danger shadow-sm">
                <i class="fas fa-trash fa-sm mr-1 text-white-50"></i> Удалить</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    @if($server->last_sync !== null)
                        <table class="table">
                            <tr>
                                <td>Сервер</td>
                                <td colspan="2">{{ $server->name }}</td>
                            </tr>
                            <tr>
                                <td>Статус</td>
                                <td>
                                    @if($server->last_sync !== null)
                                        <span class="badge badge-pill badge-success py-2 px-3">
                                            <i class="fas fa-check-circle text-white-50 mr-1"></i>
                                            Активен
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-danger py-2 px-3">
                                            <i class="fas fa-times-circle text-white-50 mr-1"></i>
                                            Сервер не настроен
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($server->last_sync !== null)
                                        Обновлен {{ $server->last_sync->diffForHumans() }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Операционная система</td>
                                <td colspan="2">{{ $server->system->name }}</td>
                            </tr>
                        </table>
                    @else
                        <p>Чтобы завершить настройку, вам необходимо установить на сервер клиент, который будет
                            периодически обновлять ваши SSH-ключи.</p>
                        <p>Клиент не дает доступ к серверу и не мешает его работе.</p>

                        <h2>Установка на {{ $server->system->name }}</h2>

                        <p>Чтобы установить клиент и настроить сервер для работы с системными учетными записями, которые
                            вы уже указали, войдите в систему как пользователь root и выполните следующую команду:</p>

                        <pre>sudo bash -c "$(curl -L {{ trim(config('app.url'), '/') }}/api/v1/setup/{{ $server->uuid }}/install.sh)"</pre>

                        <h3>Что дальше?</h3>
                        <p>После выполнения команды, она сообщит вам, что установка завершилась. После этого вы можете
                            обновить эту страницу для управления сервером.</p>
                        <p>Если ваша установка не была завершена (или завершилась, но вы все еще видите этот экран),
                            пожалуйста, проверьте наличие ошибок в программе установки.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($server->last_sync !== null)
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Управление аккаунтами</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Аккаунт</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                            </thead>
                            @foreach($server->accounts as $account)
                                <tr>
                                    <td>{{ $account->name }}</td>
                                    <td>
                                        @if($account->last_sync !== null)
                                            <span class="badge badge-pill badge-success py-2 px-3">
                                            <i class="fas fa-check-circle text-white-50 mr-1"></i>
                                            {{ $account->last_sync->diffForHumans() }}
                                        </span>
                                        @else
                                            <span class="badge badge-pill badge-danger py-2 px-3">
                                            <i class="fas fa-times-circle text-white-50 mr-1"></i>
                                            Аккаунт не настроен
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#destroyAccount-{{ $account->id }}"
                                           class="btn btn-sm btn-danger shadow-sm">
                                            <i class="fas fa-trash fa-sm mr-1 text-white-50"></i> Удалить</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <p>
                            <a class="btn btn-primary" data-toggle="collapse" href="#storeAccount" role="button"
                               aria-expanded="false" aria-controls="storeAccount">
                                Новый аккаунт
                            </a>
                        </p>
                        <div class="collapse" id="storeAccount">
                            <div class="card card-body">
                                <form method="POST" action="{{ route('account.store', $server) }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Имя аккаунта</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name"
                                                   class="form-control @error('last_name') is-invalid @enderror"
                                                   id="name" value="{{ old('name') }}" required>
                                            <small class="form-text text-muted">
                                                Аккаунт на сервере для которого необходимо настроить управление доступом
                                            </small>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Добавить аккаунт</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Управление командой</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('grant-access.sync', $server) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Пользователь</th>
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
                                                       @if($account->users->contains($user->id)) checked @endif
                                                />
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Обновить права доступа</button>
                </form>
            </div>
        </div>
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
                    <div class="modal-body">После удаления, сервер невозможно будет воостановить.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Я передумал</button>
                        <button type="submit" class="btn btn-danger">Удалить</button>
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

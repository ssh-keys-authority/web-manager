<?php

Auth::routes(['verify' => true]);

Route::get(
    '/',
    function () {
        return redirect(route('server.index'));
    }
);

Route::get('servers', 'ServersController@index')->name('server.index');
Route::get('server', 'ServersController@create')->name('server.create');
Route::post('server', 'ServersController@store')->name('server.store');
Route::get('server/{server}', 'ServersController@show')->name('server.show');
Route::delete('server/{server}', 'ServersController@destroy')->name('server.destroy');

Route::post('server/{server}/account', 'AccountsController@store')->name('account.store');
Route::delete('server/{server}/account/{account}', 'AccountsController@destroy')->name('account.destroy');
Route::post('server/{server}/grant-access', 'GrantAccessController@sync')->name('grant-access.sync');

Route::get('team', 'UsersController@index')->name('user.index');
Route::get('team/user', 'UsersController@create')->name('user.create');
Route::post('team/user', 'UsersController@store')->name('user.store');
Route::get('team/user/{user}', 'UsersController@show')->name('user.show');
Route::delete('team/user/{user}', 'UsersController@destroy')->name('user.destroy');

Route::post('team/user/{user}/key', 'KeysController@store')->name('key.store');
Route::delete('team/user/{user}/key/{key}', 'KeysController@destroy')->name('key.destroy');

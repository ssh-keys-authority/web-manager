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

Route::resource('user', 'UsersController');

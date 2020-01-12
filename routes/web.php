<?php

Auth::routes(['verify' => true]);

Route::get(
    '/',
    function () {
        return redirect('/server');
    }
)->name('home');

Route::resource('server', 'ServerController');

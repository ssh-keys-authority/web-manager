<?php

Route::get('v1/setup/{server}/install.sh', 'ApiController@setup');
Route::any('v1/keys/{server}/{account}', 'ApiController@keys');

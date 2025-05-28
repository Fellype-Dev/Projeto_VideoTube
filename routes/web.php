<?php
use App\Http\Controllers\VideoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('videos', VideoController::class);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::group(['prefix' => 'posts'], function(){
    Route::post('/',[PostController::class,'__invoke']);
});

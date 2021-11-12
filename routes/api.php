<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserSubscriptionController;

Route::group(['prefix' => 'posts'], function(){
    Route::post('/',[PostController::class,'__invoke']);
});
Route::group(['prefix' => 'subscriptions'],function (){
    Route::post('/',[UserSubscriptionController::class,'__invoke']);
});

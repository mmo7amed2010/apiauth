<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mmo7amed2010\Apiauth\Apiauth;

Route::group(['prefix' => 'api', 'middleware' => 'api'], function() {
    Route::post('/login/token', Apiauth::loginByToken());
    Route::middleware('auth:api')->post('/logout', Apiauth::logout());
    Route::post('/refresh', Apiauth::refresh());
    Route::post('/register', Apiauth::register());
    Route::middleware('auth:api')->get('/user', Apiauth::user());

});

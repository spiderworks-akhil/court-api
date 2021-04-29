<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController as Login;
use App\Http\Controllers\TokenController as Token;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('login/google', [Login::class , 'loginGoogle']);
Route::get('google-callback', [Login::class , 'googleCallback']);



Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::group(['middleware' => ['isAdmin']], function () {



    });
});
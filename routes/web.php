<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController as Login;
use App\Http\Controllers\TokenController as Token;
use App\Http\Controllers\Admin\DocController as Doc;
use App\Http\Controllers\Admin\CourtController as Court;


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
})->name('login');


Route::get('login/google', [Login::class , 'loginGoogle']);
Route::get('google-callback', [Login::class , 'googleCallback']);
Route::get('logout', [Login::class , 'logout'])->name('logout');

Route::get('documentation',[Doc::class, 'docs']);

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::group(['middleware' => ['Admin']], function () {

        //Courts
        Route::get('courts', [Court::class,'index'])->name('admin.court.index');
        Route::get('courts/create', [Court::class,'create'])->name('admin.court.create');
        Route::get('courts/edit/{id}/{tab?}', [Court::class,'edit'])->name('admin.court.edit');
        Route::get('courts/destroy/{id}', [Court::class,'destroy'])->name('admin.court.destroy');
        Route::get('courts/change-status/{id}', [Court::class,'changeStatus'])->name('admin.court.change-status');
        Route::post('courts/store', [Court::class,'store'])->name('admin.court.store');
        Route::post('courts/update', [Court::class,'update'])->name('admin.court.update');


    });
});
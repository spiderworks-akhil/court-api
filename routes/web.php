<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController as Login;
use App\Http\Controllers\TokenController as Token;
use App\Http\Controllers\Admin\DocController as Doc;
use App\Http\Controllers\Admin\CourtController as Court;
use App\Http\Controllers\Admin\HolidayController as Holiday;
use App\Http\Controllers\Admin\DayController as Day;
use App\Http\Controllers\Admin\SlotController as Slot;


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


        //Holiday Master
        Route::get('holiday', [Holiday::class,'index'])->name('admin.holiday.index');
        Route::get('holiday/create', [Holiday::class,'create'])->name('admin.holiday.create');
        Route::get('holiday/edit/{id}/{tab?}', [Holiday::class,'edit'])->name('admin.holiday.edit');
        Route::get('holiday/destroy/{id}', [Holiday::class,'destroy'])->name('admin.holiday.destroy');
        Route::get('holiday/change-status/{id}', [Holiday::class,'changeStatus'])->name('admin.holiday.change-status');
        Route::post('holiday/store', [Holiday::class,'store'])->name('admin.holiday.store');
        Route::post('holiday/update', [Holiday::class,'update'])->name('admin.holiday.update');

        //Day Master
        Route::get('day', [Day::class,'index'])->name('admin.day.index');
        Route::get('day/create', [Day::class,'create'])->name('admin.day.create');
        Route::get('day/edit/{id}/{tab?}', [Day::class,'edit'])->name('admin.day.edit');
        Route::get('day/destroy/{id}', [Day::class,'destroy'])->name('admin.day.destroy');
        Route::get('day/change-status/{id}', [Day::class,'changeStatus'])->name('admin.day.change-status');
        Route::post('day/store', [Day::class,'store'])->name('admin.day.store');
        Route::post('day/update', [Day::class,'update'])->name('admin.day.update');

        //Slots
        Route::get('slot', [Slot::class,'index'])->name('admin.slot.index');
        Route::post('slot/change/price', [Slot::class,'change_price'])->name('change-slot-amount');
        Route::get('slot/{court_id}', [Slot::class,'court'])->name('admin.slot.court');


    });
});
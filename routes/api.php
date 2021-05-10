<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController as Login;
use App\Http\Controllers\Api\UserController as User;
use App\Http\Controllers\Api\CourtController as Court;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[Login::class,'login']);
Route::get('user',[User::class,'user']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('court-list',[Court::class,'get_court_list']);
    Route::get('court-slots',[Court::class,'get_court_slots']);
    Route::get('get-estimate',[Court::class,'get_estimate']);
    Route::get('booking-details',[Court::class,'booking_details']);

    Route::get('my-booking',[Court::class,'get_my_booking']);
    Route::get('all-booking',[Court::class,'get_all_booking']);


    Route::post('book-court',[Court::class,'book_court']);
    Route::post('add-payment',[Court::class,'add_payment']);
    Route::post('change-booking-status',[Court::class,'change_booking_status']);
    Route::post('add-firebase-token',[Court::class,'firebase_token_store']);


});
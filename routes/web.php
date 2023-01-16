<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FuelStationController;
use App\Http\Controllers\AdminController;
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

Route::get('/',[PageController::class, 'homePage']);
Route::get('/login',[PageController::class, 'loginPage']);
Route::get('/register',[PageController::class, 'registerPage']);
Route::get('/otp',[PageController::class, 'otpPage']);

Route::get('/fuel-station',[PageController::class, 'fuelStation']);
Route::get('/station-login',[PageController::class, 'fuelStationLogin']);
Route::get('/fuel-issue',[PageController::class, 'fuelIssue']);
Route::get('/fuel-order',[PageController::class, 'fuelOrder']);

Route::get('/request-token',[ReservationController::class, 'requestTokenView']);
Route::get('/make-payment',[ReservationController::class, 'makePaymentView']);
Route::post('/make-payment',[ReservationController::class, 'makepayment']);

Route::post('/register-vehicle',[UserController::class,'registerVehicle']);
Route::post('/verify-otp',[UserController::class,'verifyOtp']);
Route::post('/login',[UserController::class,'login']);

Route::post('/get-suberb',[ReservationController::class, 'getSuberbByDistrict']);
Route::post('/get-station',[ReservationController::class, 'getStationBySuberb']);

Route::post('/make-reservation',[ReservationController::class, 'makeReservation']);

Route::post('/verify-secret',[UserController::class,'verifySecret']);

Route::post('/verify-token',[FuelStationController::class, 'verifyUserToken']);
Route::get('/verified',[FuelStationController::class, 'fuelVerified']);

Route::get('/logout-station',[UserController::class,'logoutStation']);
Route::post('/fuel-released',[ReservationController::class,'releasedFuel']);
Route::post('/order',[FuelStationController::class, 'orderNow']);


Route::get('/admin-login',[PageController::class, 'adminLoginPage']);
Route::get('/admin-console',[PageController::class, 'adminHomePage']);

Route::post('/admin-login',[UserController::class,'adminLogin']);

Route::get('/admin-manage-fuel',[AdminController::class,'manageFuelPage']);
Route::post('/update-weekly-quota',[AdminController::class,'updateQuota']);
Route::get('/admin-filling-station',[AdminController::class,'manageFillingStationPage']);

Route::post('/update-order-request',[AdminController::class,'updateOrder']);
Route::get('/admin-fuel-distribution',[AdminController::class,'fuelDistribution']);

Route::get('/admin-vehicle-registration',[AdminController::class,'vehicleRegistratndata']);
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\PickingController;

Route::get('/search_ticket', [PickingController::class, 'search_ticket'])->middleware('guest')->name('search_ticket');
Route::get('/search_pgh', [PickingController::class, 'search_pgh'])->middleware('guest')->name('search_pgh');
Route::get('/search_putaway', [PickingController::class, 'search_putaway'])->middleware('guest')->name('search_putaway');
Route::get('/search_serial', [PickingController::class, 'search_serial'])->middleware('guest')->name('search_serial');
Route::get('/search_receiving', [PickingController::class, 'search_receiving'])->middleware('guest')->name('search_receiving');
Route::get('/chk_wh_locn', [PickingController::class, 'chk_wh_locn'])->middleware('guest')->name('chk_wh_locn');
Route::get('/save_picking', [PickingController::class, 'store'])->middleware('guest')->name('save_picking');
Route::get('/save_pgh', [PickingController::class, 'save_pgh'])->middleware('guest')->name('save_pgh');
Route::get('/save_putaway', [PickingController::class, 'save_putaway'])->middleware('guest')->name('save_putaway');
Route::get('/save_receiving', [PickingController::class, 'save_receiving'])->middleware('guest')->name('save_receiving');
Route::get('/temp_receiving', [PickingController::class, 'temp_receiving'])->middleware('guest')->name('temp_receiving');

Route::post('/home', [PickingController::class, 'index'])->middleware('guest')->name('hhd_home');
Route::post('/picking', [PickingController::class, 'picking'])->middleware('guest')->name('picking');
Route::post('/pigeonhole', [PickingController::class, 'pigeonhole'])->middleware('guest')->name('pigeonhole');
Route::post('/putaway', [PickingController::class, 'putaway'])->middleware('guest')->name('putaway');
Route::post('/receiving', [PickingController::class, 'receiving'])->middleware('guest')->name('receiving');

Route::get('/home', function(){	return redirect()->route('hhd_login');} );
Route::get('/picking', function(){ return redirect()->route('hhd_login');} );
Route::get('/pigeonhole', function(){ return redirect()->route('hhd_login');} );
Route::get('/putaway', function(){ return redirect()->route('hhd_login');} );
Route::get('/receiving', function(){ return redirect()->route('hhd_login');} );

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	//Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/', [PickingController::class, 'login'])->middleware('guest')->name('hhd_login');

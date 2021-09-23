<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Auth::routes();

// only admin check auth 
Route::middleware(['adminRoleCheck'])->group(function () {

	// home page redirect login page
	Route::get('/home', [HomeController::class, 'index'])->name('home');
	// default page redirect login page
	Route::get('/', [HomeController::class, 'index'])->name('home');
});
// user check and admin check
Route::group(['middleware' => ['auth']], function() {
	// get approve Functionalities
    Route::get('getApproveUser','App\Http\Controllers\UserController@getApproveUser');
    // user index from admin
    Route::get('userIndexFromAdmin','App\Http\Controllers\UserController@userIndexFromAdmin');
    Route::get('approve','App\Http\Controllers\UserController@approve');
    Route::get('reject','App\Http\Controllers\UserController@reject');
	// User Functionalities 
	Route::get('userIndex','App\Http\Controllers\UserController@index');
    Route::get('userCreate','App\Http\Controllers\UserController@create');
    Route::resource('users', UserController::class);
});


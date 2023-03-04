<?php

use App\Http\Controllers\User\Web\V1\UserController;
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
    return view('v1.auth.login');
});
Route::get('/register', function () {
    return view('v1.auth.register');
});
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('register', [UserController::class, 'register'])->name('register');

Route::group(['prefix' => 'admin'],function(){
    Route::group(['prefix' => 'v1'],function(){
        Route::get('/dashboard', function () {
            return view('v1.organizer.organizer_index');
        })->name('admin.v1.dashboard');
    });
});

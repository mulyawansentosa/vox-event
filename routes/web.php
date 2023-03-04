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
Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => function () {
    if (!session()->has('token')) {
        return redirect(url('/'))->with('error', 'Unauthorized');
    }
}],function(){
    Route::group(['prefix' => 'v1'],function(){
        Route::group(['prefix' => 'user'],function(){
            Route::get('index', [UserController::class, 'index'])->name('admin.v1.user.index');
        });
        Route::get('/dashboard', function () {
            return view('v1.organizer.organizer_index');
        })->name('admin.v1.dashboard');
    });
});

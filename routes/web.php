<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Web\V1\UserController;
use App\Http\Controllers\Organizer\Web\V1\OrganizerController;

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

Route::group(['prefix' => 'admin', 'middleware' => 'token.session'],function(){
    Route::group(['prefix' => 'v1'],function(){
        Route::get('dashboard', function () {return view('v1.dashboard');})->name('admin.v1.dashboard');
        Route::group(['prefix' => 'user'],function(){
            Route::get('', [UserController::class, 'index'])->name('admin.v1.user.index');
            Route::put('update', [UserController::class, 'update'])->name('admin.v1.user.update');
            Route::get('delete', [UserController::class, 'delete'])->name('admin.v1.user.delete');
            Route::put('change_password', [UserController::class, 'changePassword'])->name('admin.v1.user.change_password');
        });
        Route::group(['prefix' => 'organizer'],function(){
            Route::get('', [OrganizerController::class, 'index'])->name('admin.v1.organizer.index');
            Route::get('{id}/show', [OrganizerController::class, 'show'])->name('admin.v1.organizer.show');
            Route::get('create', [OrganizerController::class, 'create'])->name('admin.v1.organizer.create');
            Route::post('store', [OrganizerController::class, 'store'])->name('admin.v1.organizer.store');
            Route::get('{id}/edit', [OrganizerController::class, 'edit'])->name('admin.v1.organizer.edit');
            Route::put('{id}/update', [OrganizerController::class, 'update'])->name('admin.v1.organizer.update');
            Route::get('{id}/delete', [OrganizerController::class, 'delete'])->name('admin.v1.organizer.delete');
        });
    });
});

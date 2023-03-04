<?php

use App\Http\Controllers\User\Web\V1\UserController;
use Illuminate\Support\Facades\Route;
use Faker\Factory as Faker;

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

Route::get('/test', function () {
    $faker = Faker::create();
    $user = [
        'firstName' => $faker->firstName(),
        'lastName' => $faker->lastName(),
        'email' => $faker->email(),
        'password' => $faker->regexify('[A-Z]{2}[a-z]{2}[0-9]{2}[#$%^&*()+=-\;,./{}|\:<>?~]{2}')
    ];

    return $user;
});

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => 'token.session'],function(){
    Route::group(['prefix' => 'v1'],function(){
        Route::group(['prefix' => 'user'],function(){
            Route::get('', [UserController::class, 'index'])->name('admin.v1.user.index');
            Route::put('update', [UserController::class, 'update'])->name('admin.v1.user.update');
            Route::get('delete', [UserController::class, 'delete'])->name('admin.v1.user.delete');
            Route::put('change_password', [UserController::class, 'changePassword'])->name('admin.v1.user.change_password');
        });
        Route::get('/dashboard', function () {
            return view('v1.organizer.organizer_index');
        })->name('admin.v1.dashboard');
    });
});

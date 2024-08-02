<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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
});

//Route::get('/hello', [ProductController::class, 'testpro']);
//Route::resource('products', ProductController::class);

// Route::controller(LoginController::class)->group(function(){

//     Route::get('login', 'index')->name('login');

//     Route::get('registration', 'registration')->name('registration');

//     Route::get('logout', 'logout')->name('logout');

//     Route::post('validate_registration', 'validate_registration')->name('sample.validate_registration');

//     Route::post('validate_login', 'validate_login')->name('sample.validate_login');

//     Route::get('dashboard', 'dashboard')->name('dashboard');

// });
Route::get('login',[LoginController::class, 'index'])->name('login');
Route::get('registration', [LoginController::class,'registration'])->name('registration');
Route::post('validate_registration', [LoginController::class, 'validate_registration'])->name('sample.validate_registration');
Route::post('validate_login', [LoginController::class,'validate_login'])->name('sample.validate_login');
Route::middleware(['auth'])->group(function(){
    Route::get('logout', [LoginController::class,'logout'])->name('logout');

    Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

    Route::get('profile', [LoginController::class,'profile'])->name('profile');

    Route::put('/update-profile', [LoginController::class, 'updateProfile'])->name('update_profile');

    Route::put('/update-password', [LoginController::class, 'updatePassword'])->name('update_password');

    Route::put('/userList', [LoginController::class, 'userList'])->name('userList');
});
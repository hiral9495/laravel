<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[LoginController::class, 'index'])->name('login');
Route::get('login',[LoginController::class, 'index'])->name('login');

Route::get('registration', [LoginController::class,'registration'])->name('registration');

Route::post('validate_registration', [LoginController::class, 'validate_registration'])->name('sample.validate_registration');

Route::post('validate_login', [LoginController::class,'validate_login'])->name('sample.validate_login');

Route::middleware(['auth'])->group(function(){

    Route::get('logout', [LoginController::class,'logout'])->name('logout');

    Route::middleware(['checkRole:Super Admin'])->group(function() {
        Route::get('super-admin/dashboard', [LoginController::class, 'superAdminDashboard'])->name('super-admin.dashboard');

        Route::get('/userList', [LoginController::class, 'userList'])->name('userList');
    });
    
    Route::middleware(['checkRole:Member'])->group(function() {
        Route::get('member/dashboard', [LoginController::class, 'memberDashboard'])->name('member.dashboard');
    });
    
    Route::middleware(['checkRole:Admin'])->group(function() {
        Route::get('admin/dashboard', [LoginController::class, 'adminDashboard'])->name('admin.dashboard');
    });
    
    Route::middleware(['checkRole:Editor'])->group(function() {
        Route::get('editor/dashboard', [LoginController::class, 'editorDashboard'])->name('editor.dashboard');
    });

    Route::get('profile', [LoginController::class,'profile'])->name('profile');

    Route::put('/update-profile', [LoginController::class, 'updateProfile'])->name('update_profile');

    Route::put('/update-password', [LoginController::class, 'updatePassword'])->name('update_password');

   
    Route::post('/login-as', [LoginController::class, 'loginAs'])->name('login-as')->middleware('checkSuperAdmin');

});

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
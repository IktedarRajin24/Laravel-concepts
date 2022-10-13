<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/login', [UserController::class, 'loginSubmitted'])->name('users.login');
Route::get('/register', [UserController::class, 'register'])->name('users.register');
Route::post('/register', [UserController::class, 'registerSubmitted'])->name('users.register');


Route::get('/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard')->middleware('verifyUser');
Route::get('/profile', [UserController::class, 'view'])->name('users.view')->middleware('verifyUser');
Route::get('/logout', [UserController::class, 'logout'])->name('users.logout')->middleware('verifyUser');
Route::get('/viewCertificate', [UserController::class, 'viewCertificate'])->name('users.viewCertificate')->middleware('verifyUser');

Route::get('/adminHome', [AdminController::class, 'adminHome'])->name('admin.home')->middleware('IsAdmin');
Route::get('/allUsers', [AdminController::class, 'viewAllUsers'])->name('admin.allUsers')->middleware('IsAdmin');
Route::get('/downloadCertificate/{id}/{name}', [AdminController::class, 'downloadCertificate'])->name('admin.downloadCertificate')->middleware('IsAdmin');
Route::get('/sendCertificate/{id}/{name}', [AdminController::class, 'sendCertificate'])->name('admin.sendCertificate')->middleware('IsAdmin');
Route::get('/viewPDF/{id}/{name}', [AdminController::class, 'viewPDF'])->name('admin.viewPDF')->middleware('IsAdmin');

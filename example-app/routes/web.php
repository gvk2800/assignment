<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('customer', AdminController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware('isAdmin')->group(function () {
    Route::get('/all_customer',[App\Http\Controllers\AdminController::class, 'all_customer'])->name('c.index');
});
Route::middleware('islogin')->group(function () {
    Route::get('/new_dash',[App\Http\Controllers\AdminController::class, 'dash'])->name('c.dash');
});


Route::post('/cedit',[App\Http\Controllers\AdminController::class, 'cedit']);
Route::post('/cupdate',[App\Http\Controllers\AdminController::class, 'cupdate'])->name('c.update');

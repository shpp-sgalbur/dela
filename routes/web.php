<?php

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
    return view('home',['active'=>'Главная']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/*--------*/
Route::resource('category', \App\Http\Controllers\CategoryController::class)->middleware('auth');
Route::resource('deal', \App\Http\Controllers\DealController::class);
//Route::post('user/{id}/create/store',[\App\Http\Controllers\CategoryController::class,'store'])->name('createCategory');

require __DIR__.'/auth.php';

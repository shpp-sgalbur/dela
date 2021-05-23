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
    return view('home',['active'=>'Главная','mode'=>'Home']);
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/*--------*/
Route::resource('category', \App\Http\Controllers\CategoryController::class)->middleware('auth');
Route::resource('deal', \App\Http\Controllers\DealController::class);
//Route::get('/home/{category}',[\App\Http\Controllers\CategoryController::class,'index'])->name('main')->middleware('auth');
Route::get('deal/create/categories/{category}',[\App\Http\Controllers\DealController::class,'create'])->name('createDeal')->middleware('auth');
Route::post('deal/store/categories/{category}',[\App\Http\Controllers\DealController::class,'store'])->name('storeDeal')->middleware('auth');
Route::delete('deal/{id}/categories/{category}/delete',[\App\Http\Controllers\DealController::class,'destroy'])->name('dealDestroy')->middleware('auth');
//Route::post('user/{id}/create/store',[\App\Http\Controllers\CategoryController::class,'store'])->name('createCategory');
Route::get('/vote/form/category/{category}',[\App\Http\Controllers\CategoryController::class,'voteCreate'])->name('voteCreate')->middleware('auth');
Route::post('/vote/store/category/{category}',[\App\Http\Controllers\CategoryController::class,'voteStore'])->name('voteStore')->middleware('auth');
require __DIR__.'/auth.php';

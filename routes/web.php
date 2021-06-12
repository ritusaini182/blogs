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
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/list', [App\Http\Controllers\BlogController::class, 'blogList'])->name('blogs');
Route::get('/add', [App\Http\Controllers\BlogController::class, 'blogAdd'])->name('blogs-add');
Route::post('/save', [App\Http\Controllers\BlogController::class, 'blogSave'])->name('blog-save');
Route::get('/edit/{id}', [App\Http\Controllers\BlogController::class, 'blogEdit'])->name('blog-edit');
Route::post('/update', [App\Http\Controllers\BlogController::class, 'blogUpdate'])->name('blog-update');
Route::get('/delete', [App\Http\Controllers\BlogController::class, 'blogDelete'])->name('delete-blog');
});

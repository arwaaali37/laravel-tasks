<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('posts', PostController::class);


Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
});

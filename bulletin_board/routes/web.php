<?php

use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Auth;
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
  return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
  Route::get('/posts', [PostController::class, 'index'])->name('posts.search');
  Route::get('/post/create', [PostController::class, 'create'])->name('posts.create');
  Route::post('/post/create', [PostController::class, 'store'])->name('posts.create');
  Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
  Route::post('/post/edit/{id}', [PostController::class, 'update'])->name('posts.update');
  Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
  Route::get('/post/upload', [PostController::class, 'upload'])->name('posts.upload');
  Route::post('/post/upload', [PostController::class, 'importExcel'])->name('posts.fileupload');
  Route::get('/posts/download', [PostController::class, 'export'])->name('posts.export');
});


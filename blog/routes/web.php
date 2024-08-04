<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::patch('/home', [HomeController::class, 'updatePassword']);
Route::resource('/admin/posts', AdminController::class)->except('show')->names('admin')->middleware('admin');

Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('/{post}/comment', [PostController::class, 'comment'])->name('posts.comment')->middleware('auth');
Route::get('/categories/{categorie}', [PostController::class, 'postsByCategorie'])->name('posts.byCategorie');
Route::get('/tags/{tag}', [PostController::class, 'postsByTag'])->name('posts.byTag');

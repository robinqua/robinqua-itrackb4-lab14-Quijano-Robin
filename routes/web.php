<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/register', [RegisterController::class, 'create'])->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'create'])->name('login');

Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/teachers/featured', [TeacherController::class, 'featured'])
    ->name('teachers.featured');

Route::resource('teachers', TeacherController::class)
    ->only(['index', 'show']);

Route::get('/books/featured',        [BooksController::class, 'featured'])
    ->name('books.featured');

Route::get('/books/filter/{pages?}', function ($pages = null) {
    return redirect()->route('books.index', $pages === null ? [] : ['pages' => $pages]);
})->name('books.filter');

Route::resource('books', BooksController::class)
    ->middlewareFor(['create', 'store', 'edit', 'update', 'destroy'], 'auth');
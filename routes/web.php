<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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
Route::middleware('isGuest')->group(function() {
    Route::get('/', [TodoController::class, 'index']);
    Route::get('/register', [TodoController::class, 'register'])->name('register-page');
    Route::post('/register', [TodoController::class, 'registerAccount'])->name('register.post');
    Route::post('/login/auth', [TodoController::class, 'auth'])->name('login.auth');
});

Route::get('/logout', [TodoController::class, 'logout'])->name('logout');

// todo
Route::middleware('isLogin')->prefix('/todo')->name('todo.')->group(function () {
    Route::get('/', [TodoController::class, 'home'])->name('index');
    Route::get('/complated', [TodoController::class, 'complated'])->name('complated');
    Route::get('/create', [TodoController::class, 'create'])->name('create');
    Route::post('/store', [TodoController::class, 'store'])->name('store');
    // route path yang menggunakan { } berarti dia berperan sebagai parameter route
    // parameter ini bentuknya data dinamis (data yang dikirim ke route untuk diambil di parameter function controller terkait)
    Route::get('/edit/{id}', [TodoController::class, 'edit'])->name('edit');
    // method route untuk ubah data di db itu patch/put
    Route::patch('/update/{id}', [TodoController::class, 'update'])->name('update');
    // method route untuk hapus data di db itu delete
    Route::delete('/delete/{id}', [TodoController::class, 'destroy'])->name('delete');
    Route::patch('/complated/{id}', [TodoController::class, 'updateComplated'])->name('update-complated');
});

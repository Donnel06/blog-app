<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FrontController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(UsersController::class)->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->middleware(['auth', 'admin'])->name('users.index');
    Route::get('/show/profile/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/edit/{user}', [UsersController::class, 'edit'])->middleware(['auth'])->name('users.edit');
    Route::put('/update/{user}', [UsersController::class, 'update'])->middleware(['auth'])->name('users.update');
    Route::delete('/delete/{user}', [UsersController::class, 'destroy'])->middleware(['auth', 'admin'])->name('users.destroy');
});

Route::resource('posts', PostsController::class);

Route::resource('comments', CommentsController::class);

Route::get('comments/{comment}/report', [CommentsController::class, 'report'])->name('comments.report');

Route::get('/', [PostsController::class, 'index'])
->name('posts.index');



require __DIR__.'/auth.php';

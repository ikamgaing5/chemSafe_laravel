<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () { return view('index');});
Route::get('/', [UserController::class, 'home']);
Route::post('/', [UserController::class, 'login'])->name('logins');
Route::get('/dashboards', [UserController::class, 'dashboard'])->name('dashboards');



Route::get('/workshop/all-workshop/{idusine}', [AtelierController::class, 'all']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

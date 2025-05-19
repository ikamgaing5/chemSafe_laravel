<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsineController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () { return view('index');});
Route::get('/', [UserController::class, 'home']);
Route::post('/', [UserController::class, 'login'])->name('logins');

Route::middleware(['auth'])->group(function () {
Route::get('/dashboards', [UserController::class, 'dashboard'])->name('dashboards');



Route::get('/workshop/all-workshop/{idusine}', [AtelierController::class, 'all'])->name('oneworkshop');
Route::get('/workshop/all-workshop/', [AtelierController::class, 'alls'])->name('superadminWorkshop');
Route::patch('/workshop/delete/{id}', [AtelierController::class, 'delete'])->name('workshop.delete');
Route::post('/workshop/add', [AtelierController::class, 'add'])->name('workshop.add');
Route::patch('/workshop/edit/{id}', [AtelierController::class, 'update'])->name('workshop.update');


Route::get('/factory/all-factory', [UsineController::class, 'all'])->name('all-factorie');
Route::patch('factory/delete/{id}', [UsineController::class, 'delete'])->name('factory.delete');
Route::patch('/factory/edit/{id}', [UsineController::class, 'update'])->name('factory.update');
Route::post('/factory/new/', [UsineController::class, 'add'])->name('factory.add');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\InfofdsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DangerController;

// Route::get('/', function () { return view('index');});
Route::get('/', [UserController::class, 'home'])->name('start');
Route::post('/', [UserController::class, 'login'])->name('logins');

Route::middleware(['auth.middle'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/user/new-user/', [UserController::class, 'add'])->name('user.add');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/workshop/all-products/{idatelier}', [ProduitController::class, 'allByWorkshop'])->name('product.forworkshop');
    Route::get('/product/new-product', [ProduitController::class, 'add'])->name('product.add');
    Route::post('/product/new-product', [ProduitController::class, 'addPost'])->name('product.addPost');
    Route::get('/product/more-detail/{idatelier}/{idprodit}', [ProduitController::class, 'one'])->name('product.one');
    Route::patch('/product/add{idatelier}', [ProduitController::class, 'addWorkshop'])->name('product.addWorkshop');
    Route::get('/product/edit/{idproduit}', [ProduitController::class, 'edit'])->name('product.edit');
    Route::patch('/product/edit-product/{idproduit}', [ProduitController::class, 'editPost'])->name('product.editPost');

    Route::get('/getDangerData', [ProduitController::class, 'getDangerDatas']);




    Route::get('/workshop/all-workshop/{idusine}', [AtelierController::class, 'all'])->name('oneworkshop');
    Route::get('/workshop/all-workshop/', [AtelierController::class, 'alls'])->name('superadminWorkshop');
    Route::patch('/workshop/delete/{id}', [AtelierController::class, 'delete'])->name('workshop.delete');
    Route::post('/workshop/add', [AtelierController::class, 'add'])->name('workshop.add');
    Route::patch('/workshop/edit/{id}', [AtelierController::class, 'update'])->name('workshop.update');


    Route::get('/factory/all-factory', [UsineController::class, 'all'])->name('all-factorie');
    Route::patch('factory/delete/{id}', [UsineController::class, 'delete'])->name('factory.delete');
    Route::patch('/factory/edit/{id}', [UsineController::class, 'update'])->name('factory.update');
    Route::post('/factory/new/', [UsineController::class, 'add'])->name('factory.add');


    Route::get('/info-fds/new-info-fds/{idproduit}', [InfofdsController::class, 'add'])->name('infofds.add');
    Route::post('/info-fds/new-info/{idproduit}', [InfofdsController::class, 'addPost'])->name('infofds.addPost');
    Route::get('/info-fds/edit/{idproduit}/{idatelier}', [InfofdsController::class, 'edit'])->name('infofds.edit');
    Route::patch('/info-fds/edits/{id}', [InfofdsController::class, 'editPost'])->name('infofds.editPost');



    route::patch('/product/updateFDS/{idproduit}', [ProduitController::class, 'addFDS'])->name('product.addFDS');
    route::delete('/product/produit/{idproduit}/atelier/{idatelier}', [ProduitController::class, 'deleteFromWorkshop'])->name('product.deleteWorkshop');




});

Route::get('/product/dangers/all', [DangerController::class, 'getDangerStatsAllAteliers']);
Route::get('/product/dangers/{idatelier}', [DangerController::class, 'getDangerStatsByAtelier']);
Route::get('/product/dangers/usine/{idusine}', [DangerController::class, 'getDangerStatsByUsine']);

Route::get('/showGraphAtelier', [AtelierController::class, 'getAteliersWithDetailsAll']);
Route::get('/GraphAtelier/{idusine}', [AtelierController::class, 'getAteliers']);
Route::get('/dashboards', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboards');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
// require __DIR__ . '/web.php';

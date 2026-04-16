<?php

use App\Http\Controllers\Admin\BienController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\OptionController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::prefix('admin/')->name('admin.')->group(function () {

    // BIEN ROUTE:
    Route::get('bien', [BienController::class, 'index'])->name('bien.home');
    Route::get('bien/create', [BienController::class, 'formCreate'])->name('bien.form_create');
    Route::post('bien/create', [BienController::class, 'store'])->name('bien.store');

    // CATEGORIE ROUTE:
    Route::get('categorie', [CategorieController::class, 'index'])->name('categorie.home');
    Route::post('categorie', [CategorieController::class, 'store'])->name('categorie.store');
    Route::get('categorie/{id}', [CategorieController::class, 'show'])->name('categorie.show');
    Route::put('categorie/{id}', [CategorieController::class, 'update'])->name('categorie.update');
    Route::delete('categorie/delete/{id}', [CategorieController::class, 'destroy'])->name('categorie.destroy');

    // OPTIONS ROUTE:
    Route::get('option', [OptionController::class, 'index'])->name('option.home');
    Route::post('option', [OptionController::class, 'store'])->name('option.store');
    Route::get('option/{id}', [OptionController::class, 'show'])->name('option.show');
    Route::put('option/{id}', [OptionController::class, 'update'])->name('option.update');
    Route::delete('option/{id}', [OptionController::class, 'destroy'])->name('option.destroy');


});
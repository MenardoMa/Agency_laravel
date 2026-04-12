<?php

use App\Http\Controllers\Admin\CategorieController;
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

    // CATEGORIE ROUTE:
    Route::get('categorie', [CategorieController::class, 'index'])->name('categorie.home');
    Route::post('categorie', [CategorieController::class, 'store'])->name('categorie.store');
    Route::delete('categorie/delete/{id}', [CategorieController::class, 'destroy'])->name('categorie.destroy');

});
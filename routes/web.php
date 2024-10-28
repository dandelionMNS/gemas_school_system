<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//User Related Route
{
    Route::view('/students', 'pages.stud_list')->name('students'); // goto create product page

    Route::get('/product', [StudentController::class, 'index'])->name('products.index'); //goto index
    Route::get('/product/details/{id}', [StudentController::class, 'show'])->name('products.details'); //get specific product

    Route::post('/product/store', [StudentController::class, 'store'])->name('products.store'); // store product

    Route::delete('/product/delete/{id}', [StudentController::class, 'delete'])->name('products.delete'); // Delete from index
    Route::delete('/product/details/{id}/delete', [StudentController::class, 'deleteFromDetails'])->name('products.delete.details'); // Delete from details
    Route::get('/product/details/{id}/edit', [StudentController::class, 'edit'])->name('products.edit'); //nav to edit prod page
    Route::post('/product/details/{id}', [StudentController::class, 'update'])->name('products.update'); // save product //nav to edit prod page
}

require __DIR__ . '/auth.php';

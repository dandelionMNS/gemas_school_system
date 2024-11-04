<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\UserController;
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


// User controller
{
    Route::get('/admin/user', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('user.index');
    Route::put('admin/user/{id}/update', [UserController::class, 'updateType'])->middleware(['auth', 'verified'])->name('user.updateType');



    Route::get('/admin/users/add', [UserController::class, 'addPage'])->middleware(['auth', 'verified'])->name('user.addPage');
    Route::post('/admin/users/added', [UserController::class, 'add'])->middleware(['auth', 'verified'])->name('user.add');
    Route::get('/admin/user/{id}', [UserController::class, 'userDetails'])->middleware(['auth', 'verified'])->name('user.details');
    Route::put('/user/{id}/update', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('user.update');
    Route::delete('/admin/user/{id}/delete', [UserController::class, 'userDelete'])->middleware(['auth', 'verified'])->name('user.delete');
}

// Class controller
{
    Route::get('/admin/class', [ClassController::class, 'index'])->middleware(['auth', 'verified'])->name('class.index');
    Route::post('/admin/class/create', [ClassController::class, 'create'])->middleware(['auth', 'verified'])->name('class.create');
    Route::put('/admin/class/{id}/update', [ClassController::class, 'update'])->middleware(['auth', 'verified'])->name('class.update');
    Route::delete('/admin/class/{id}/delete', [ClassController::class, 'delete'])->middleware(['auth', 'verified'])->name('class.delete');
}


//Student Related Route
{
    Route::view('/student', 'pages.stud_list')->middleware(['auth', 'verified'])->name('student');
    
    Route::get('/student/add', [StudentController::class, 'addPage'])->middleware(['auth', 'verified'])->name('student.add');
    Route::post('/student/create', [StudentController::class, 'create'])->middleware(['auth', 'verified'])->name('student.create');
    Route::get('/student/details/{id}', [StudentController::class, 'details'])->middleware(['auth', 'verified'])->name('student.details');
    Route::put('/student/details/{id}/updated', [StudentController::class, 'update'])->middleware(['auth', 'verified'])->name('student.update');
    Route::delete('/student/delete/{id}', [StudentController::class, 'destroy'])->middleware(['auth', 'verified'])->name('student.delete');
    
}

require __DIR__ . '/auth.php';

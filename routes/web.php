<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MailController;
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


// User Related Route
{
    Route::get('/admin/user', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('user.index');
    Route::put('admin/user/{id}/update', [UserController::class, 'updateType'])->middleware(['auth', 'verified'])->name('user.updateType');

    Route::get('/admin/users/add', [UserController::class, 'addPage'])->middleware(['auth', 'verified'])->name('user.addPage');
    Route::post('/admin/users/added', [UserController::class, 'add'])->middleware(['auth', 'verified'])->name('user.add');
    Route::get('/admin/user/{id}', [UserController::class, 'userDetails'])->middleware(['auth', 'verified'])->name('user.details');
    Route::put('/user/{id}/update', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('user.update');
    Route::delete('/admin/user/{id}/delete', [UserController::class, 'userDelete'])->middleware(['auth', 'verified'])->name('user.delete');
}

// Classes Related Route
{
    Route::get('/admin/class', [ClassController::class, 'index'])->middleware(['auth', 'verified'])->name('class.index');
    Route::post('/admin/class/create', [ClassController::class, 'create'])->middleware(['auth', 'verified'])->name('class.create');
    Route::put('/admin/class/{id}/update', [ClassController::class, 'update'])->middleware(['auth', 'verified'])->name('class.update');
    Route::delete('/admin/class/{id}/delete', [ClassController::class, 'delete'])->middleware(['auth', 'verified'])->name('class.delete');
}

// Feetype Related Route
{
    Route::get('/admin/feetype', [FeeTypeController::class, 'index'])->middleware(['auth', 'verified'])->name('feetype.index');
    Route::post('/admin/feetype/create', [FeeTypeController::class, 'create'])->middleware(['auth', 'verified'])->name('feetype.create');
    Route::put('/admin/feetype/{id}/update', [FeeTypeController::class, 'update'])->middleware(['auth', 'verified'])->name('feetype.update');
    Route::delete('/admin/feetype/{id}/delete', [FeeTypeController::class, 'delete'])->middleware(['auth', 'verified'])->name('feetype.delete');
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

//Transaction Related Route
{
    Route::get('/student/details/{stud_id}/transaction/{feetype_id}', [TransactionController::class, 'addPage'])->middleware(['auth', 'verified'])->name('transaction');

    Route::post('/student/details/{stud_id}/transaction/{feetype_id}/create', [TransactionController::class, 'create'])->middleware(['auth', 'verified'])->name('transaction.create');
    Route::get('/transaction/download/{encodedPath}', [TransactionController::class, 'download'])->middleware(['auth', 'verified'])->name('transaction.download');

    Route::get('/student/details/{stud_id}/transaction/{feetype_id}/details/{transaction_id}', [TransactionController::class, 'details'])->middleware(['auth', 'verified'])->name('transaction.details');
    Route::delete('/transaction/{transaction_id}/delete', [TransactionController::class, 'destroy'])->middleware(['auth', 'verified'])->name('transaction.delete');
    
    Route::put('/transaction/{transaction_id}/approve', [TransactionController::class, 'approve'])->middleware(['auth', 'verified'])->name('transaction.approve');
    Route::put('/transaction/{transaction_id}/reject', [TransactionController::class, 'reject'])->middleware(['auth', 'verified'])->name('transaction.reject');

}

// Mail Related Route
{
    Route::post('/mail/send', [MailController::class, 'send'])->middleware(['auth', 'verified'])->name('sendingmail');
}

require __DIR__ . '/auth.php';

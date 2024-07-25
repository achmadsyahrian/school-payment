<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
  
    Route::get('/', function () {
        if (Auth::user()->role_id == 1) {
          return app(\App\Http\Controllers\Administrator\DashboardController::class)->index();
        }
        else if (Auth::user()->role_id == 2) {
          return app(\App\Http\Controllers\Employee\DashboardController::class)->index();
        }
        else if (Auth::user()->role_id == 3) {
          return app(\App\Http\Controllers\Teacher\DashboardController::class)->index();
        }
        else if (Auth::user()->role_id == 4) {
          return app(\App\Http\Controllers\Student\DashboardController::class)->index();
        }
    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::prefix('administrator')->middleware(['role:1'])->name('administrator.')->group(function () {
      Route::resource('/users', \App\Http\Controllers\Administrator\UserController::class)->names('users');
      Route::resource('/teachers', \App\Http\Controllers\Administrator\TeacherController::class)->names('teachers');
      Route::resource('/students', \App\Http\Controllers\Administrator\StudentController::class)->names('students');

      Route::resource('/academic-years', \App\Http\Controllers\Administrator\AcademicYearController::class)->names('academicyears');
      Route::resource('/classrooms', \App\Http\Controllers\Administrator\ClassroomController::class)->names('classrooms');
      // Route::resource('/payments', \App\Http\Controllers\Administrator\PaymentController::class)->names('payments');
    }); 

    Route::prefix('employee')->middleware(['role:2'])->name('employee.')->group(function () {
        // Route::resource('/users', \App\Http\Controllers\Employee\UserController::class)->names('users');
        Route::resource('/teachers', \App\Http\Controllers\Employee\TeacherController::class)->names('teachers');
        Route::resource('/students', \App\Http\Controllers\Employee\StudentController::class)->names('students');

        // Route::resource('/academic-years', \App\Http\Controllers\Employee\AcademicYearController::class)->names('academicyears');
        Route::resource('/classrooms', \App\Http\Controllers\Employee\ClassroomController::class)->names('classrooms');
        Route::resource('/payments', \App\Http\Controllers\Employee\PaymentController::class)->names('payments');
        Route::get('/payments/student/{nisn}', [\App\Http\Controllers\Employee\PaymentController::class, 'show'])->name('payments.studentDetail');
        Route::get('/payments/student/{nisn}/{academicYear}', [\App\Http\Controllers\Employee\PaymentController::class, 'showDetailPayment'])->name('payments.studentDetailPayment');
        Route::post('/payments/student/{student}/{academicYear}/{month}', [\App\Http\Controllers\Employee\PaymentController::class, 'storePayment'])->name('payments.storePayment');
    }); 

    Route::prefix('teacher')->middleware(['role:3'])->name('teacher.')->group(function () {
        //
    }); 

    Route::prefix('student')->middleware(['role:4'])->name('student.')->group(function () {
        //
    }); 
    
});
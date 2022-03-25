<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teacher',[App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/all',[App\Http\Controllers\TeacherController::class, 'allData'])->name('teacher.allData');
Route::post('/teacher/store',[App\Http\Controllers\TeacherController::class, 'store'])->name('teacher.store');
Route::get('/teacher/edit/{id}',[App\Http\Controllers\TeacherController::class, 'edit'])->name('teacher.edit');
Route::post('/teacher/update/{id}',[App\Http\Controllers\TeacherController::class, 'update'])->name('teacher.update');
Route::get('/teacher/delete/{id}',[App\Http\Controllers\TeacherController::class, 'destroy'])->name('teacher.destroy');






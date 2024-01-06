<?php

use App\Http\Controllers\TaskController;
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


Route::get('/',[TaskController::class,'index'])->name('task-list');
Route::get('/add-task',[TaskController::class,'addTask'])->name('add-task');
Route::post('/save-task',[TaskController::class,'store'])->name('save-task');
Route::get('/edit-task',[TaskController::class,'editTask'])->name('edit-task');
Route::post('/update-task',[TaskController::class,'updateTask'])->name('update-task');
Route::post('/delete-task',[TaskController::class,'deleteTask'])->name('delete-task');
Route::post('/update-task-priority',[TaskController::class,'updateTaskPriority'])->name('update-task-priority');


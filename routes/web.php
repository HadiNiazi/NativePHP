<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('homepage');
});

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

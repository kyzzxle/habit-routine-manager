<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitController;

Route::get('/', [HabitController::class, 'index']);
Route::resource('habits', HabitController::class);

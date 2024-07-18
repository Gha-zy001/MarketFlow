<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;



Route::group([
  'middleware' => ['auth'],
  'as' => 'dashboard.',
  'prefix' => 'dashboard'
], function () {
  Route::resource('/categories', CategoriesController::class);

  Route::get('/', [DashboardController::class, 'index']);
});


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

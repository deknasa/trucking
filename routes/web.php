<?php

use App\Http\Controllers\ParameterController;
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

// Route::get('parameter', [ParameterController::class, 'index'])->name('parameter.index');
Route::get('parameter/{id}/delete', [ParameterController::class, 'delete']);
Route::resource('parameter', ParameterController::class);
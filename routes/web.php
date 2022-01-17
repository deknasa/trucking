<?php

use App\Http\Controllers\AbsensiSupirHeaderController;
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

Route::get('dashboard', function() {
    echo 'dashboard';
})->name('dashboard.index');

Route::get('parameter/field_length', [ParameterController::class, 'fieldLength'])->name('parameter.field_length');
Route::get('parameter/{id}/delete', [ParameterController::class, 'delete'])->name('parameter.delete');
Route::resource('parameter', ParameterController::class);

Route::get('absensi/{id}/delete', [AbsensiController::class, 'delete'])->name('absensi.delete');
Route::resource('absensi', AbsensiSupirHeaderController::class);
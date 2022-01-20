<?php

use App\Http\Controllers\AbsensiSupirDetailController;
use App\Http\Controllers\AbsensiSupirHeaderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ParameterController;
use Illuminate\Support\Facades\Auth;
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
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function() {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware('loggedin')->group(function () {
    Route::get('dashboard', function () {
        echo 'dashboard';
    })->name('dashboard.index');

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('parameter/field_length', [ParameterController::class, 'fieldLength'])->name('parameter.field_length');
    Route::get('parameter/{id}/delete', [ParameterController::class, 'delete'])->name('parameter.delete');
    Route::resource('parameter', ParameterController::class);

    Route::get('cabang/field_length', [CabangController::class, 'fieldLength'])->name('cabang.field_length');
    Route::get('cabang/{id}/delete', [CabangController::class, 'delete'])->name('cabang.delete');
    Route::resource('cabang', CabangController::class);


    Route::get('absensi/{id}/delete', [AbsensiSupirHeaderController::class, 'delete'])->name('absensi.delete');
    Route::resource('absensi', AbsensiSupirHeaderController::class);

    Route::resource('absensi_detail', AbsensiSupirDetailController::class);
});

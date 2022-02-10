<?php

use App\Http\Controllers\AbsensiSupirDetailController;
use App\Http\Controllers\AbsensiSupirHeaderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AclController;
use App\Http\Controllers\UserAclController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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

Route::middleware('guest')->group(function () {
    Route::get('login/index', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('/');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('parameter/field_length', [ParameterController::class, 'fieldLength'])->name('parameter.field_length');
    Route::get('parameter/{id}/delete', [ParameterController::class, 'delete'])->name('parameter.delete');
    Route::get('parameter/index', [ParameterController::class, 'index']);
    Route::get('parameter/report', [ParameterController::class, 'report'])->name('parameter.report');
    Route::get('parameter/export', [ParameterController::class, 'export'])->name('parameter.export');
    Route::get('parameter/get', [ParameterController::class, 'get'])->name('parameter.get');
    Route::resource('parameter', ParameterController::class);
    
    Route::get('cabang/field_length', [CabangController::class, 'fieldLength'])->name('cabang.field_length');
    Route::get('cabang/{id}/delete', [CabangController::class, 'delete'])->name('cabang.delete');
    Route::get('Cabang/index', [CabangController::class, 'index']);
    Route::resource('cabang', CabangController::class);

    Route::get('role/field_length', [RoleController::class, 'fieldLength'])->name('role.field_length');
    Route::get('role/{id}/delete', [RoleController::class, 'delete'])->name('role.delete');
    Route::get('role/getroleid', [RoleController::class, 'getroleid']);
    Route::get('role/index', [RoleController::class, 'index']);
    Route::resource('role', RoleController::class);

    Route::get('user/field_length', [UserController::class, 'fieldLength'])->name('user.field_length');
    Route::get('user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::get('user/getuserid', [UserController::class, 'getuserid']);
    Route::get('user/index', [UserController::class, 'index']);
    Route::resource('user', UserController::class);

    Route::get('menu/field_length', [MenuController::class, 'fieldLength'])->name('menu.field_length');
    Route::get('menu/getdata', [MenuController::class, 'getdata'])->name('menu.getdata');
    Route::get('menu/{id}/delete', [MenuController::class, 'delete'])->name('menu.delete');
    Route::get('menu/listFolderFiles', [MenuController::class, 'listFolderFiles'])->name('menu.listFolderFiles');
    Route::get('menu/listclassall', [MenuController::class, 'listclassall'])->name('menu.listclassall');
    Route::resource('menu', MenuController::class);    

    Route::get('absensi/{id}/delete', [AbsensiSupirHeaderController::class, 'delete'])->name('absensi.delete');
    Route::get('absensi/index', [AbsensiSupirHeaderController::class, 'index']);
    Route::get('absensi/get', [AbsensiSupirHeaderController::class, 'get'])->name('absensi.get');
    Route::get('absensi/export', [AbsensiSupirHeaderController::class, 'export'])->name('absensi.export');
    Route::get('absensi/report', [AbsensiSupirHeaderController::class, 'report'])->name('absensi.report');
    Route::resource('absensi', AbsensiSupirHeaderController::class);

    Route::resource('absensi_detail', AbsensiSupirDetailController::class);

    Route::get('userrole/{id}/delete', [UserRoleController::class, 'delete'])->name('userrole.delete');
    Route::get('userrole/field_length', [UserRoleController::class, 'fieldLength'])->name('userrole.field_length');
    Route::get('userrole/detail', [UserRoleController::class, 'detail'])->name('userrole.detail');
    Route::resource('userrole', UserRoleController::class);

    Route::get('acl/{id}/delete', [AclController::class, 'delete'])->name('acl.delete');
    Route::get('acl/field_length', [AclController::class, 'fieldLength'])->name('acl.field_length');
    Route::get('acl/detail', [AclController::class, 'detail'])->name('acl.detail');
    Route::resource('acl', AclController::class);    

    Route::get('useracl/{id}/delete', [UserAclController::class, 'delete'])->name('useracl.delete');
    Route::get('useracl/field_length', [UserAclController::class, 'fieldLength'])->name('useracl.field_length');
    Route::get('useracl/detail', [UserAclController::class, 'detail'])->name('useracl.detail');
    Route::get('useracl/report', [UserAclController::class, 'report'])->name('useracl.report');
    Route::get('useracl/export', [UserAclController::class, 'export'])->name('useracl.export');
    Route::get('useracl/get', [UserAclController::class, 'get'])->name('useracl.get');

    Route::resource('useracl', UserAclController::class);    

});

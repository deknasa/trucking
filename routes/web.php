<?php

use App\Http\Controllers\AbsensiSupirDetailController;
use App\Http\Controllers\AbsensiSupirHeaderController;
use App\Http\Controllers\AbsenTradoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AclController;
use App\Http\Controllers\AgenController;
use App\Http\Controllers\AkunPusatController;
use App\Http\Controllers\UserAclController;
use App\Http\Controllers\ErrorController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogTrailController;
use App\Http\Controllers\TradoController;
use App\Http\Controllers\ContainerController;

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
    Route::get('login', [AuthController::class, 'index'])->name('login');
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

    Route::get('error/field_length', [ErrorController::class, 'fieldLength'])->name('error.field_length');
    Route::get('error/{id}/delete', [ErrorController::class, 'delete'])->name('error.delete');
    Route::get('error/index', [ErrorController::class, 'index']);
    Route::get('error/get', [ErrorController::class, 'get'])->name('error.get');
    Route::resource('error', ErrorController::class);

    Route::get('cabang/field_length', [CabangController::class, 'fieldLength'])->name('cabang.field_length');
    Route::get('cabang/{id}/delete', [CabangController::class, 'delete'])->name('cabang.delete');
    Route::get('cabang/index', [CabangController::class, 'index']);
    Route::get('cabang/get', [CabangController::class, 'get'])->name('cabang.get');
    Route::resource('cabang', CabangController::class);

    Route::get('role/field_length', [RoleController::class, 'fieldLength'])->name('role.field_length');
    Route::get('role/{id}/delete', [RoleController::class, 'delete'])->name('role.delete');
    Route::get('role/getroleid', [RoleController::class, 'getroleid']);
    Route::get('role/index', [RoleController::class, 'index']);
    Route::get('role/get', [RoleController::class, 'get'])->name('role.get');
    Route::get('role/export', [RoleController::class, 'export'])->name('role.export');
    Route::get('role/report', [RoleController::class, 'report'])->name('role.report');
    Route::resource('role', RoleController::class);

    Route::get('user/field_length', [UserController::class, 'fieldLength'])->name('user.field_length');
    Route::get('user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::get('user/getuserid', [UserController::class, 'getuserid']);
    Route::get('user/index', [UserController::class, 'index']);
    Route::get('user/get', [UserController::class, 'get'])->name('user.get');
    Route::get('user/export', [UserController::class, 'export'])->name('user.export');
    Route::get('user/report', [UserController::class, 'report'])->name('user.report');
    Route::resource('user', UserController::class);

    Route::get('menu/field_length', [MenuController::class, 'fieldLength'])->name('menu.field_length');
    Route::get('menu/getdata', [MenuController::class, 'getdata'])->name('menu.getdata');
    Route::get('menu/{id}/delete', [MenuController::class, 'delete'])->name('menu.delete');
    Route::get('menu/listFolderFiles', [MenuController::class, 'listFolderFiles'])->name('menu.listFolderFiles');
    Route::get('menu/listclassall', [MenuController::class, 'listclassall'])->name('menu.listclassall');
    Route::get('menu/index', [MenuController::class, 'index']);
    Route::get('menu/get', [MenuController::class, 'get'])->name('menu.get');
    Route::get('menu/resequence', [MenuController::class, 'resequence'])->name('menu.resequence');
    Route::post('menu/resequence', [MenuController::class, 'storeResequence'])->name('menu.resequence.store');
    Route::resource('menu', MenuController::class);

    Route::get('absensisupir/{id}/delete', [AbsensiSupirHeaderController::class, 'delete'])->name('absensisupir.delete');
    Route::get('absensisupir/index', [AbsensiSupirHeaderController::class, 'index']);
    Route::get('absensisupir/get', [AbsensiSupirHeaderController::class, 'get'])->name('absensisupir.get');
    Route::get('absensisupir/export', [AbsensiSupirHeaderController::class, 'export'])->name('absensisupir.export');
    Route::get('absensisupir/report', [AbsensiSupirHeaderController::class, 'report'])->name('absensisupir.report');
    Route::resource('absensisupir', AbsensiSupirHeaderController::class);

    Route::resource('absensisupir_detail', AbsensiSupirDetailController::class);

    Route::get('userrole/{id}/delete', [UserRoleController::class, 'delete'])->name('userrole.delete');
    Route::get('userrole/field_length', [UserRoleController::class, 'fieldLength'])->name('userrole.field_length');
    Route::get('userrole/detail', [UserRoleController::class, 'detail'])->name('userrole.detail');
    Route::get('userrole/index', [UserRoleController::class, 'index']);
    Route::get('userrole/get', [UserRoleController::class, 'get'])->name('userrole.get');
    Route::get('userrole/export', [UserRoleController::class, 'export'])->name('userrole.export');
    Route::get('userrole/report', [UserRoleController::class, 'report'])->name('userrole.report');
    Route::resource('userrole', UserRoleController::class);

    Route::get('acl/{id}/delete', [AclController::class, 'delete'])->name('acl.delete');
    Route::get('acl/field_length', [AclController::class, 'fieldLength'])->name('acl.field_length');
    Route::get('acl/detail', [AclController::class, 'detail'])->name('acl.detail');
    Route::get('acl/index', [AclController::class, 'index']);
    Route::resource('acl', AclController::class);

    Route::get('useracl/{id}/delete', [UserAclController::class, 'delete'])->name('useracl.delete');
    Route::get('useracl/field_length', [UserAclController::class, 'fieldLength'])->name('useracl.field_length');
    Route::get('useracl/detail', [UserAclController::class, 'detail'])->name('useracl.detail');
    Route::get('useracl/report', [UserAclController::class, 'report'])->name('useracl.report');
    Route::get('useracl/export', [UserAclController::class, 'export'])->name('useracl.export');
    Route::get('useracl/index', [UserAclController::class, 'index']);
    Route::get('useracl/get', [UserAclController::class, 'get'])->name('useracl.get');

    Route::resource('useracl', UserAclController::class);

    Route::get('trado/field_length', [TradoController::class, 'fieldLength'])->name('trado.field_length');
    Route::get('trado/{id}/delete', [TradoController::class, 'delete'])->name('trado.delete');
    Route::resource('trado', TradoController::class);

    Route::get('logtrail/index', [LogTrailController::class, 'index'])->name('logtrail.index');
    Route::get('logtrail/get', [LogTrailController::class, 'get'])->name('logtrail.get');
    Route::get('logtrail/report', [LogTrailController::class, 'report'])->name('logtrail.report');
    Route::get('logtrail/export', [LogTrailController::class, 'export'])->name('logtrail.export');
    Route::get('logtrail/header', [LogTrailController::class, 'header'])->name('logtrail.header');
    Route::get('logtrail/detail', [LogTrailController::class, 'detail'])->name('logtrail.detail');
    Route::resource('logtrail', LogTrailController::class);

    Route::get('container/field_length', [ContainerController::class, 'fieldLength'])->name('container.field_length');
    Route::get('container/{id}/delete', [ContainerController::class, 'delete'])->name('container.delete');
    Route::get('container/index', [ContainerController::class, 'index']);
    Route::get('container/get', [ContainerController::class, 'get'])->name('container.get');
    Route::resource('container', ContainerController::class);

    Route::get('absentrado/field_length', [AbsenTradoController::class, 'fieldLength'])->name('absentrado.field_length');
    Route::get('absentrado/{id}/delete', [AbsenTradoController::class, 'delete'])->name('absentrado.delete');
    Route::get('absentrado/index', [AbsenTradoController::class, 'index']);
    Route::get('absentrado/report', [AbsenTradoController::class, 'report'])->name('absentrado.report');
    Route::get('absentrado/export', [AbsenTradoController::class, 'export'])->name('absentrado.export');
    Route::get('absentrado/get', [AbsenTradoController::class, 'get'])->name('absentrado.get');
    Route::resource('absentrado', AbsenTradoController::class);

    Route::get('agen/field_length', [AgenController::class, 'fieldLength'])->name('agen.field_length');
    Route::get('agen/{id}/delete', [AgenController::class, 'delete'])->name('agen.delete');
    Route::get('agen/index', [AgenController::class, 'index']);
    Route::get('agen/report', [AgenController::class, 'report'])->name('agen.report');
    Route::get('agen/export', [AgenController::class, 'export'])->name('agen.export');
    Route::get('agen/get', [AgenController::class, 'get'])->name('agen.get');
    Route::resource('agen', AgenController::class);

    Route::get('akunpusat/field_length', [AkunPusatController::class, 'fieldLength'])->name('akunpusat.field_length');
    Route::get('akunpusat/{id}/delete', [AkunPusatController::class, 'delete'])->name('akunpusat.delete');
    Route::get('akunpusat/index', [AkunPusatController::class, 'index']);
    Route::get('akunpusat/report', [AkunPusatController::class, 'report'])->name('akunpusat.report');
    Route::get('akunpusat/export', [AkunPusatController::class, 'export'])->name('akunpusat.export');
    Route::get('akunpusat/get', [AkunPusatController::class, 'get'])->name('akunpusat.get');
    Route::resource('akunpusat', AkunPusatController::class);
});

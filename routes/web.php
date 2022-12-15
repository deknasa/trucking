<?php

use App\Http\Controllers\AbsensiSupirDetailController;
use App\Http\Controllers\AbsensiSupirHeaderController;

use App\Http\Controllers\AbsensiSupirApprovalDetailController;
use App\Http\Controllers\AbsensiSupirApprovalHeaderController;
use App\Http\Controllers\ApprovalTransaksiHeaderController;
use App\Http\Controllers\ApprovalInvoiceHeaderController;

use App\Http\Controllers\AbsenTradoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\GandenganController;
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
use App\Http\Controllers\SupirController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\AlatBayarController;
use App\Http\Controllers\ApprovalHutangBayarController;
use App\Http\Controllers\ApprovalNotaHeaderController;
use App\Http\Controllers\ApprovalPendapatanSupirController;
use App\Http\Controllers\BankPelangganController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\JenisEmklController;
use App\Http\Controllers\JenisOrderController;
use App\Http\Controllers\JenisTradoController;
use App\Http\Controllers\KasGantungDetailController;
use App\Http\Controllers\KasGantungHeaderController;

use App\Http\Controllers\PengembalianKasGantungDetailController;
use App\Http\Controllers\PengembalianKasGantungHeaderController;
use App\Http\Controllers\PengembalianKasBankDetailController;
use App\Http\Controllers\PengembalianKasBankHeaderController;
use App\Http\Controllers\NotaKreditHeaderController;
use App\Http\Controllers\NotaDebetHeaderController;

use App\Http\Controllers\ApprovalBukaCetakController;

use App\Http\Controllers\GudangController;
use App\Http\Controllers\SubKelompokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StatusContainerController;

use App\Http\Controllers\KotaController;
use App\Http\Controllers\MandorController;
use App\Http\Controllers\MerkController;

use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\TarifController;

use App\Http\Controllers\PengeluaranTruckingController;
use App\Http\Controllers\penerimaanTruckingController;

use App\Http\Controllers\OrderanTruckingController;
use App\Http\Controllers\ProsesAbsensiSupirController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\SuratPengantarController;
use App\Http\Controllers\UpahSupirController;
use App\Http\Controllers\UpahSupirRincianController;
use App\Http\Controllers\UpahRitasiController;
use App\Http\Controllers\UpahRitasiRincianController;
use App\Http\Controllers\RitasiController;
use App\Http\Controllers\ServiceInHeaderController;
use App\Http\Controllers\ServiceInDetailController;
use App\Http\Controllers\ServiceOutHeaderController;
use App\Http\Controllers\ServiceOutDetailController;
use App\Http\Controllers\PenerimaanHeaderController;
use App\Http\Controllers\PenerimaanDetailController;
use App\Http\Controllers\PengeluaranHeaderController;
use App\Http\Controllers\PengeluaranDetailController;

use App\Http\Controllers\RekapPengeluaranHeaderController;
use App\Http\Controllers\RekapPengeluaranDetailController;
use App\Http\Controllers\RekapPenerimaanHeaderController;
use App\Http\Controllers\RekapPenerimaanDetailController;

use App\Http\Controllers\PenerimaanTruckingHeaderController;
use App\Http\Controllers\PenerimaanTruckingDetailController;

use App\Http\Controllers\PenerimaanStokController;
use App\Http\Controllers\PenerimaanStokHeaderController;
use App\Http\Controllers\PenerimaanStokDetailController;

use App\Http\Controllers\PengeluaranStokController;
use App\Http\Controllers\PengeluaranStokHeaderController;
use App\Http\Controllers\PengeluaranStokDetailController;

use App\Http\Controllers\GajiSupirHeaderController;
use App\Http\Controllers\GajiSupirDetailController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\PengeluaranTruckingHeaderController;
use App\Http\Controllers\PengeluaranTruckingDetailController;
use App\Http\Controllers\JurnalUmumHeaderController;
use App\Http\Controllers\JurnalUmumDetailController;
use App\Http\Controllers\HutangHeaderController;
use App\Http\Controllers\HutangDetailController;
use App\Http\Controllers\PelunasanPiutangDetailController;
use App\Http\Controllers\PelunasanPiutangHeaderController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PiutangDetailController;
use App\Http\Controllers\PiutangHeaderController;
use App\Http\Controllers\HutangBayarDetailController;
use App\Http\Controllers\HutangBayarHeaderController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoiceHeaderController;

use App\Http\Controllers\InvoiceExtraHeaderController;
use App\Http\Controllers\JurnalUmumPusatDetailController;
use App\Http\Controllers\JurnalUmumPusatHeaderController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\PencairanGiroPengeluaranDetailController;
use App\Http\Controllers\PencairanGiroPengeluaranHeaderController;
use App\Http\Controllers\PendapatanSupirDetailController;
use App\Http\Controllers\PendapatanSupirHeaderController;
use App\Http\Controllers\PenerimaanGiroDetailController;
use App\Http\Controllers\PenerimaanGiroHeaderController;
use App\Http\Controllers\ProsesGajiSupirHeaderController;
use App\Http\Controllers\ProsesGajiSupirDetailController;
use App\Http\Controllers\ReportAllController;
use App\Http\Controllers\ReportNeracaController;

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
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::middleware('guest')->group(function () {
//     Route::get('login/index', [AuthController::class, 'index'])->name('login');
//     Route::get('login', [AuthController::class, 'index'])->name('login');
//     Route::post('login', [AuthController::class, 'login'])->name('login.process');
// });

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::get('login/index', [AuthController::class, 'index']);
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
    Route::get('parameter/detail', [ParameterController::class, 'detail'])->name('parameter.detail');
    Route::get('parameter/get', [ParameterController::class, 'get'])->name('parameter.get');
    Route::resource('parameter', ParameterController::class);

    Route::get('error/field_length', [ErrorController::class, 'fieldLength'])->name('error.field_length');
    Route::get('error/{id}/delete', [ErrorController::class, 'delete'])->name('error.delete');
    Route::get('error/index', [ErrorController::class, 'index']);
    Route::get('error/get', [ErrorController::class, 'get'])->name('error.get');
    Route::get('error/export', [ErrorController::class, 'export'])->name('error.export');
    Route::get('error/report', [ErrorController::class, 'report'])->name('error.report');
    Route::resource('error', ErrorController::class);

    Route::get('cabang/field_length', [CabangController::class, 'fieldLength'])->name('cabang.field_length');
    Route::get('cabang/{id}/delete', [CabangController::class, 'delete'])->name('cabang.delete');
    Route::get('cabang/index', [CabangController::class, 'index']);
    Route::get('cabang/get', [CabangController::class, 'get'])->name('cabang.get');
    Route::get('cabang/export', [CabangController::class, 'export'])->name('cabang.export');
    Route::get('cabang/report', [CabangController::class, 'report'])->name('cabang.report');
    Route::resource('cabang', CabangController::class);


    Route::get('gandengan/field_length', [GandenganController::class, 'fieldLength'])->name('gandengan.field_length');
    Route::get('gandengan/{id}/delete', [GandenganController::class, 'delete'])->name('gandengan.delete');
    Route::get('gandengan/index', [GandenganController::class, 'index']);
    Route::get('gandengan/get', [GandenganController::class, 'get'])->name('gandengan.get');
    Route::get('gandengan/export', [GandenganController::class, 'export'])->name('gandengan.export');
    Route::get('gandengan/report', [GandenganController::class, 'report'])->name('gandengan.report');
    Route::resource('gandengan', GandenganController::class);

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
    Route::get('menu/export', [MenuController::class, 'export'])->name('menu.export');
    Route::get('menu/report', [MenuController::class, 'report'])->name('menu.report');
    Route::resource('menu', MenuController::class);

    Route::get('absensisupirheader/{id}/delete', [AbsensiSupirHeaderController::class, 'delete'])->name('absensisupirheader.delete');
    Route::get('absensisupirheader/index', [AbsensiSupirHeaderController::class, 'index']);
    Route::get('absensisupirheader/get', [AbsensiSupirHeaderController::class, 'get'])->name('absensisupirheader.get');
    Route::get('absensisupirheader/export', [AbsensiSupirHeaderController::class, 'export'])->name('absensisupirheader.export');
    Route::get('absensisupirheader/report', [AbsensiSupirHeaderController::class, 'report'])->name('absensisupirheader.report');
    Route::resource('absensisupirheader', AbsensiSupirHeaderController::class);

    Route::resource('absensisupir_detail', AbsensiSupirDetailController::class);
    
    Route::get('absensisupirapprovalheader/{id}/delete', [AbsensiSupirApprovalHeaderController::class, 'delete'])->name('absensisupirapprovalheader.delete');
    Route::get('absensisupirapprovalheader/index', [AbsensiSupirApprovalHeaderController::class, 'index']);
    Route::get('absensisupirapprovalheader/get', [AbsensiSupirApprovalHeaderController::class, 'get'])->name('absensisupirapprovalheader.get');
    Route::get('absensisupirapprovalheader/export', [AbsensiSupirApprovalHeaderController::class, 'export'])->name('absensisupirapprovalheader.export');
    Route::get('absensisupirapprovalheader/report/{id}', [AbsensiSupirApprovalHeaderController::class, 'report'])->name('absensisupirapprovalheader.report');
    Route::resource('absensisupirapprovalheader', AbsensiSupirApprovalHeaderController::class);

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
    Route::get('acl/export', [AclController::class, 'export'])->name('acl.export');
    Route::get('acl/report', [AclController::class, 'report'])->name('acl.report');
    Route::get('acl/get', [AclController::class, 'get'])->name('acl.get');
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
    Route::get('trado/get', [TradoController::class, 'get'])->name('trado.get');
    Route::get('trado/index', [TradoController::class, 'index']);
    Route::resource('trado', TradoController::class);

    Route::get('logtrail/index', [LogTrailController::class, 'index']);
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



    Route::get('supir/field_length', [SupirController::class, 'fieldLength'])->name('supir.field_length');
    Route::get('supir/{id}/delete', [SupirController::class, 'delete'])->name('supir.delete');
    Route::get('supir/get', [SupirController::class, 'get'])->name('supir.get');
    Route::get('supir/index', [SupirController::class, 'index']);
    Route::resource('supir', SupirController::class);

    Route::get('bank/field_length', [BankController::class, 'fieldLength'])->name('bank.field_length');
    Route::get('bank/index', [BankController::class, 'index']);
    Route::get('bank/{id}/delete', [BankController::class, 'delete'])->name('bank.delete');
    Route::get('bank/get', [BankController::class, 'get'])->name('bank.get');
    Route::get('bank/index', [BankController::class, 'index']);
    Route::resource('bank', BankController::class);

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

    Route::get('alatbayar/field_length', [AlatBayarController::class, 'fieldLength'])->name('alatbayar.field_length');
    Route::get('alatbayar/{id}/delete', [AlatBayarController::class, 'delete'])->name('alatbayar.delete');
    Route::get('alatbayar/get', [AlatBayarController::class, 'get'])->name('alatbayar.get');
    Route::get('alatbayar/index', [AlatBayarController::class, 'index']);
    Route::resource('alatbayar', AlatBayarController::class);

    Route::get('bankpelanggan/field_length', [BankPelangganController::class, 'fieldLength'])->name('bankpelanggan.field_length');
    Route::get('bankpelanggan/{id}/delete', [BankPelangganController::class, 'delete'])->name('bankpelanggan.delete');
    Route::get('bankpelanggan/get', [BankPelangganController::class, 'get'])->name('bankpelanggan.get');
    Route::get('bankpelanggan/index', [BankPelangganController::class, 'index']);
    Route::resource('bankpelanggan', BankPelangganController::class);

    Route::get('jenisemkl/field_length', [JenisEmklController::class, 'fieldLength'])->name('jenisemkl.field_length');
    Route::get('jenisemkl/{id}/delete', [JenisEmklController::class, 'delete'])->name('jenisemkl.delete');
    Route::get('jenisemkl/get', [JenisEmklController::class, 'get'])->name('jenisemkl.get');
    Route::get('jenisemkl/index', [JenisEmklController::class, 'index']);
    Route::resource('jenisemkl', JenisEmklController::class);

    Route::get('jenisorder/field_length', [JenisOrderController::class, 'fieldLength'])->name('jenisorder.field_length');
    Route::get('jenisorder/{id}/delete', [JenisOrderController::class, 'delete'])->name('jenisorder.delete');
    Route::get('jenisorder/get', [JenisOrderController::class, 'get'])->name('jenisorder.get');
    Route::get('jenisorder/index', [JenisOrderController::class, 'index']);
    Route::resource('jenisorder', JenisOrderController::class);

    Route::get('jenistrado/field_length', [JenisTradoController::class, 'fieldLength'])->name('jenistrado.field_length');
    Route::get('jenistrado/{id}/delete', [JenisTradoController::class, 'delete'])->name('jenistrado.delete');
    Route::get('jenistrado/get', [JenisTradoController::class, 'get'])->name('jenistrado.get');
    Route::get('jenistrado/index', [JenisTradoController::class, 'index']);
    Route::resource('jenistrado', JenisTradoController::class);

    Route::get('kasgantungheader/{id}/delete', [KasGantungHeaderController::class, 'delete'])->name('kasgantungheader.delete');
    Route::get('kasgantungheader/index', [KasGantungHeaderController::class, 'index']);
    Route::get('kasgantungheader/get', [KasGantungHeaderController::class, 'get'])->name('kasgantungheader.get');
    Route::get('kasgantungheader/export', [KasGantungHeaderController::class, 'export'])->name('kasgantungheader.export');
    Route::get('kasgantungheader/report', [KasGantungHeaderController::class, 'report'])->name('kasgantungheader.report');
    Route::resource('kasgantungheader', KasGantungHeaderController::class);

    Route::resource('kasgantungdetail', KasGantungDetailController::class);

    Route::get('pengembaliankasgantungheader/get', [PengembalianKasGantungHeaderController::class, 'get'])->name('pengembaliankasgantungheader.get');
    Route::get('pengembaliankasgantungheader/export', [PengembalianKasGantungHeaderController::class, 'export'])->name('pengembaliankasgantungheader.export');
    Route::get('pengembaliankasgantungheader/report', [PengembalianKasGantungHeaderController::class, 'report'])->name('pengembaliankasgantungheader.report');
    Route::get('pengembaliankasgantungheader/index', [PengembalianKasGantungHeaderController::class, 'index']);
    Route::resource('pengembaliankasgantungheader', PengembalianKasGantungHeaderController::class);
    
    Route::get('pengembaliankasbankheader/get', [PengembalianKasbankHeaderController::class, 'get'])->name('pengembaliankasbankheader.get');
    Route::get('pengembaliankasbankheader/export', [PengembalianKasbankHeaderController::class, 'export'])->name('pengembaliankasbankheader.export');
    Route::get('pengembaliankasbankheader/report', [PengembalianKasbankHeaderController::class, 'report'])->name('pengembaliankasbankheader.report');
    Route::get('pengembaliankasbankheader/index', [PengembalianKasbankHeaderController::class, 'index']);
    Route::resource('pengembaliankasbankheader', PengembalianKasbankHeaderController::class);
    
    Route::get('notakreditheader/get', [NotaKreditHeaderController::class, 'get'])->name('notakreditheader.get');
    Route::get('notakreditheader/export', [NotaKreditHeaderController::class, 'export'])->name('notakreditheader.export');
    Route::get('notakreditheader/report/{id}', [NotaKreditHeaderController::class, 'report'])->name('notakreditheader.report');
    Route::get('notakreditheader/index', [NotaKreditHeaderController::class, 'index']);
    Route::resource('notakreditheader', NotaKreditHeaderController::class);
    
    Route::get('notadebetheader/get', [NotaDebetHeaderController::class, 'get'])->name('notadebetheader.get');
    Route::get('notadebetheader/export', [NotaDebetHeaderController::class, 'export'])->name('notadebetheader.export');
    Route::get('notadebetheader/report/{id}', [NotaDebetHeaderController::class, 'report'])->name('notadebetheader.report');
    Route::get('notadebetheader/index', [NotaDebetHeaderController::class, 'index']);
    Route::resource('notadebetheader', NotaDebetHeaderController::class);

    Route::get('gudang/field_length', [GudangController::class, 'fieldLength'])->name('gudang.field_length');
    Route::get('gudang/{id}/delete', [GudangController::class, 'delete'])->name('gudang.delete');
    Route::get('gudang/get', [GudangController::class, 'get'])->name('gudang.get');
    Route::get('gudang/index', [GudangController::class, 'index']);
    Route::resource('gudang', GudangController::class);

    Route::get('subkelompok/report', [SubKelompokController::class, 'report'])->name('subkelompok.report');
    Route::get('subkelompok/{id}/delete', [SubKelompokController::class, 'delete'])->name('subkelompok.delete');
    Route::get('subkelompok/get', [SubKelompokController::class, 'get'])->name('subkelompok.get');
    Route::get('subkelompok/index', [SubKelompokController::class, 'index']);
    Route::resource('subkelompok', SubKelompokController::class);

    Route::get('supplier/report', [SupplierController::class, 'report'])->name('supplier.report');
    Route::get('supplier/{id}/delete', [SupplierController::class, 'delete'])->name('supplier.delete');
    Route::get('supplier/get', [SupplierController::class, 'get'])->name('supplier.get');
    Route::get('supplier/index', [SupplierController::class, 'index']);
    Route::resource('supplier', SupplierController::class);

    Route::get('kategori/field_length', [KategoriController::class, 'fieldLength'])->name('kategori.field_length');
    Route::get('kategori/{id}/delete', [KategoriController::class, 'delete'])->name('kategori.delete');
    Route::get('kategori/get', [KategoriController::class, 'get'])->name('kategori.get');
    Route::get('kategori/index', [KategoriController::class, 'index']);
    Route::resource('kategori', KategoriController::class);

    Route::get('kelompok/field_length', [KelompokController::class, 'fieldLength'])->name('kelompok.field_length');
    Route::get('kelompok/{id}/delete', [KelompokController::class, 'delete'])->name('kelompok.delete');
    Route::get('kelompok/get', [KelompokController::class, 'get'])->name('kelompok.get');
    Route::get('kelompok/index', [KelompokController::class, 'index']);
    Route::resource('kelompok', KelompokController::class);

    Route::get('kerusakan/field_length', [KerusakanController::class, 'fieldLength'])->name('kerusakan.field_length');
    Route::get('kerusakan/{id}/delete', [KerusakanController::class, 'delete'])->name('kerusakan.delete');
    Route::get('kerusakan/get', [KerusakanController::class, 'get'])->name('kerusakan.get');
    Route::get('kerusakan/index', [KerusakanController::class, 'index']);
    Route::resource('kerusakan', KerusakanController::class);

    Route::get('penerima/report', [PenerimaController::class, 'report'])->name('penerima.report');
    Route::get('penerima/{id}/delete', [PenerimaController::class, 'delete'])->name('penerima.delete');
    Route::get('penerima/get', [PenerimaController::class, 'get'])->name('penerima.get');
    Route::get('penerima/index', [PenerimaController::class, 'index']);
    Route::resource('penerima', PenerimaController::class);

    Route::get('pelanggan/report', [PelangganController::class, 'report'])->name('pelanggan.report');
    Route::get('pelanggan/{id}/delete', [PelangganController::class, 'delete'])->name('pelanggan.delete');
    Route::get('pelanggan/get', [PelangganController::class, 'get'])->name('pelanggan.get');
    Route::get('pelanggan/index', [PelangganController::class, 'index']);
    Route::resource('pelanggan', PelangganController::class);

    Route::get('statuscontainer/report', [StatusContainerController::class, 'report'])->name('statuscontainer.report');
    Route::get('statuscontainer/{id}/delete', [StatusContainerController::class, 'delete'])->name('statuscontainer.delete');
    Route::get('statuscontainer/get', [StatusContainerController::class, 'get'])->name('statuscontainer.get');
    Route::get('statuscontainer/index', [StatusContainerController::class, 'index']);
    Route::resource('statuscontainer', StatusContainerController::class)->parameters(['statuscontainer' => 'statusContainer']);

    Route::get('kota/field_length', [KotaController::class, 'fieldLength'])->name('kota.field_length');
    Route::get('kota/{id}/delete', [KotaController::class, 'delete'])->name('kota.delete');
    Route::get('kota/get', [KotaController::class, 'get'])->name('kota.get');
    Route::get('kota/index', [KotaController::class, 'index']);
    Route::resource('kota', KotaController::class);

    Route::get('mandor/field_length', [MandorController::class, 'fieldLength'])->name('mandor.field_length');
    Route::get('mandor/{id}/delete', [MandorController::class, 'delete'])->name('mandor.delete');
    Route::get('mandor/get', [MandorController::class, 'get'])->name('mandor.get');
    Route::get('mandor/index', [MandorController::class, 'index']);
    Route::resource('mandor', MandorController::class);

    Route::get('merk/field_length', [MerkController::class, 'fieldLength'])->name('merk.field_length');
    Route::get('merk/{id}/delete', [MerkController::class, 'delete'])->name('merk.delete');
    Route::get('merk/get', [MerkController::class, 'get'])->name('merk.get');
    Route::get('merk/index', [MerkController::class, 'index']);
    Route::resource('merk', MerkController::class);

    Route::get('penerimaantrucking/report', [PenerimaanTruckingController::class, 'report'])->name('penerimaantrucking.report');
    Route::get('penerimaantrucking/{id}/delete', [PenerimaanTruckingController::class, 'delete'])->name('penerimaantrucking.delete');
    Route::get('penerimaantrucking/get', [PenerimaanTruckingController::class, 'get'])->name('penerimaantrucking.get');
    Route::get('penerimaantrucking/index', [PenerimaanTruckingController::class, 'index']);
    Route::resource('penerimaantrucking', PenerimaanTruckingController::class);

    Route::get('penerimaanstok/report', [PenerimaanStokController::class, 'report'])->name('penerimaanstok.report');
    Route::get('penerimaanstok/{id}/delete', [PenerimaanStokController::class, 'delete'])->name('penerimaanstok.delete');
    Route::get('penerimaanstok/get', [PenerimaanStokController::class, 'get'])->name('penerimaanstok.get');
    Route::get('penerimaanstok/index', [PenerimaanStokController::class, 'index']);
    Route::resource('penerimaanstok', PenerimaanStokController::class);
    
    Route::get('pengeluaranstok/report', [PengeluaranStokController::class, 'report'])->name('pengeluaranstok.report');
    Route::get('pengeluaranstok/{id}/delete', [PengeluaranStokController::class, 'delete'])->name('pengeluaranstok.delete');
    Route::get('pengeluaranstok/get', [PengeluaranStokController::class, 'get'])->name('pengeluaranstok.get');
    Route::get('pengeluaranstok/index', [PengeluaranStokController::class, 'index']);
    Route::resource('pengeluaranstok', PengeluaranStokController::class);

    Route::get('pengeluarantrucking/report', [PengeluaranTruckingController::class, 'report'])->name('pengeluarantrucking.report');
    Route::get('pengeluarantrucking/{id}/delete', [PengeluaranTruckingController::class, 'delete'])->name('pengeluarantrucking.delete');
    Route::get('pengeluarantrucking/get', [PengeluaranTruckingController::class, 'get'])->name('pengeluarantrucking.get');
    Route::get('pengeluarantrucking/index', [PengeluaranTruckingController::class, 'index']);
    Route::resource('pengeluarantrucking', PengeluaranTruckingController::class);

    Route::get('satuan/field_length', [SatuanController::class, 'fieldLength'])->name('satuan.field_length');
    Route::get('satuan/{id}/delete', [SatuanController::class, 'delete'])->name('satuan.delete');
    Route::get('satuan/get', [SatuanController::class, 'get'])->name('satuan.get');
    Route::get('satuan/index', [SatuanController::class, 'index']);
    Route::resource('satuan', SatuanController::class);

    Route::get('zona/field_length', [ZonaController::class, 'fieldLength'])->name('zona.field_length');
    Route::get('zona/{id}/delete', [ZonaController::class, 'delete'])->name('zona.delete');
    Route::get('zona/get', [ZonaController::class, 'get'])->name('zona.get');
    Route::get('zona/index', [ZonaController::class, 'index']);
    Route::resource('zona', ZonaController::class);

    Route::get('tarif/field_length', [TarifController::class, 'fieldLength'])->name('tarif.field_length');
    Route::get('tarif/{id}/delete', [TarifController::class, 'delete'])->name('tarif.delete');
    Route::get('tarif/get', [TarifController::class, 'get'])->name('tarif.get');
    Route::get('tarif/index', [TarifController::class, 'index']);
    Route::resource('tarif', TarifController::class);

    Route::get('orderantrucking/field_length', [OrderanTruckingController::class, 'fieldLength'])->name('orderantrucking.field_length');
    Route::get('orderantrucking/{id}/delete', [OrderanTruckingController::class, 'delete'])->name('orderantrucking.delete');
    Route::get('orderantrucking/get', [OrderanTruckingController::class, 'get'])->name('orderantrucking.get');
    Route::get('orderantrucking/index', [OrderanTruckingController::class, 'index']);
    Route::resource('orderantrucking', OrderanTruckingController::class);

    Route::get('prosesabsensisupir/field_length', [ProsesAbsensiSupirController::class, 'fieldLength'])->name('prosesabsensisupir.field_length');
    Route::get('prosesabsensisupir/{id}/delete', [ProsesAbsensiSupirController::class, 'delete'])->name('prosesabsensisupir.delete');
    Route::get('prosesabsensisupir/get', [ProsesAbsensiSupirController::class, 'get'])->name('prosesabsensisupir.get');
    Route::get('prosesabsensisupir/index', [ProsesAbsensiSupirController::class, 'index']);
    Route::resource('prosesabsensisupir', ProsesAbsensiSupirController::class);

    Route::get('mekanik/field_length', [MekanikController::class, 'fieldLength'])->name('mekanik.field_length');
    Route::get('mekanik/{id}/delete', [MekanikController::class, 'delete'])->name('mekanik.delete');
    Route::get('mekanik/index', [MekanikController::class, 'index']);
    Route::get('mekanik/get', [MekanikController::class, 'get'])->name('mekanik.get');
    Route::resource('mekanik', MekanikController::class);


    Route::get('suratpengantar/field_length', [SuratPengantarController::class, 'fieldLength'])->name('suratpengantar.field_length');
    Route::get('suratpengantar/get_gaji', [SuratPengantarController::class, 'getGaji'])->name('suratpengantar.get_gaji');
    Route::get('suratpengantar/{id}/delete', [SuratPengantarController::class, 'delete'])->name('suratpengantar.delete');
    Route::get('suratpengantar/get', [SuratPengantarController::class, 'get'])->name('suratpengantar.get');
    Route::get('suratpengantar/index', [SuratPengantarController::class, 'index']);
    Route::resource('suratpengantar', SuratPengantarController::class);


    Route::get('upahsupir/{id}/delete', [UpahSupirController::class, 'delete'])->name('upahsupir.delete');
    Route::get('upahsupir/index', [UpahSupirController::class, 'index']);
    Route::get('upahsupir/get', [UpahSupirController::class, 'get'])->name('upahsupir.get');
    Route::get('upahsupir/export', [UpahSupirController::class, 'export'])->name('upahsupir.export');
    Route::get('upahsupir/report', [UpahSupirController::class, 'report'])->name('upahsupir.report');
    Route::resource('upahsupir', UpahSupirController::class);

    Route::resource('upahsupirrincian', UpahSupirRincianController::class);

    Route::get('upahritasi/{id}/delete', [UpahRitasiController::class, 'delete'])->name('upahritasi.delete');
    Route::get('upahritasi/index', [UpahRitasiController::class, 'index']);
    Route::get('upahritasi/get', [UpahRitasiController::class, 'get'])->name('upahritasi.get');
    Route::get('upahritasi/export', [UpahRitasiController::class, 'export'])->name('upahritasi.export');
    Route::get('upahritasi/report', [UpahRitasiController::class, 'report'])->name('upahritasi.report');
    Route::resource('upahritasi', UpahRitasiController::class);

    Route::resource('upahritasirincian', UpahRitasiRincianController::class);

    Route::get('ritasi/field_length', [RitasiController::class, 'fieldLength'])->name('ritasi.field_length');
    Route::get('ritasi/{id}/delete', [RitasiController::class, 'delete'])->name('ritasi.delete');
    Route::get('ritasi/get', [RitasiController::class, 'get'])->name('ritasi.get');
    Route::get('ritasi/index', [RitasiController::class, 'index']);

    Route::resource('ritasi', RitasiController::class);

    Route::get('serviceinheader/{id}/delete', [ServiceInHeaderController::class, 'delete'])->name('serviceinheader.delete');
    Route::get('serviceinheader/index', [ServiceInHeaderController::class, 'index']);
    Route::get('serviceinheader/get', [ServiceInHeaderController::class, 'get'])->name('serviceinheader.get');
    Route::get('serviceinheader/export', [ServiceInHeaderController::class, 'export'])->name('serviceinheader.export');
    Route::get('serviceinheader/report', [ServiceInHeaderController::class, 'report'])->name('serviceinheader.report');
    Route::resource('serviceinheader', ServiceInHeaderController::class);

    Route::resource('serviceindetail', ServiceInDetailController::class);

    Route::get('serviceoutheader/{id}/delete', [ServiceOutHeaderController::class, 'delete'])->name('serviceoutheader.delete');
    Route::get('serviceoutheader/index', [ServiceOutHeaderController::class, 'index']);
    Route::get('serviceoutheader/get', [ServiceOutHeaderController::class, 'get'])->name('serviceoutheader.get');
    Route::get('serviceoutheader/export', [ServiceOutHeaderController::class, 'export'])->name('serviceoutheader.export');
    Route::get('serviceoutheader/report', [ServiceOutHeaderController::class, 'report'])->name('serviceoutheader.report');
    Route::resource('serviceoutheader', ServiceOutHeaderController::class);

    Route::resource('serviceoutdetail', ServiceOutDetailController::class);

    Route::get('penerimaanheader/{id}/delete', [PenerimaanHeaderController::class, 'delete'])->name('penerimaanheader.delete');
    Route::get('penerimaanheader/index', [PenerimaanHeaderController::class, 'index']);
    Route::get('penerimaanheader/get', [PenerimaanHeaderController::class, 'get'])->name('penerimaanheader.get');
    Route::get('penerimaanheader/export', [PenerimaanHeaderController::class, 'export'])->name('penerimaanheader.export');
    Route::get('penerimaanheader/report', [PenerimaanHeaderController::class, 'report'])->name('penerimaanheader.report');
    Route::resource('penerimaanheader', PenerimaanHeaderController::class);

    Route::resource('penerimaandetail', PenerimaanDetailController::class);

    //pengeluaran
    Route::get('pengeluaranheader/{id}/delete', [PengeluaranHeaderController::class, 'delete'])->name('pengeluaranheader.delete');
    Route::get('pengeluaranheader/index', [PengeluaranHeaderController::class, 'index']);
    Route::get('pengeluaranheader/get', [PengeluaranHeaderController::class, 'get'])->name('pengeluaranheader.get');
    Route::get('pengeluaranheader/export', [PengeluaranHeaderController::class, 'export'])->name('pengeluaranheader.export');
    Route::get('pengeluaranheader/report', [PengeluaranHeaderController::class, 'report'])->name('pengeluaranheader.report');
    Route::resource('pengeluaranheader', PengeluaranHeaderController::class);

    Route::resource('pengeluarandetail', PengeluaranDetailController::class);
    
    Route::get('rekappengeluaranheader/{id}/delete', [RekapPengeluaranHeaderController::class, 'delete'])->name('rekappengeluaranheader.delete');
    Route::get('rekappengeluaranheader/index', [RekapPengeluaranHeaderController::class, 'index']);
    Route::get('rekappengeluaranheader/get', [RekapPengeluaranHeaderController::class, 'get'])->name('rekappengeluaranheader.get');
    Route::get('rekappengeluaranheader/export', [RekapPengeluaranHeaderController::class, 'export'])->name('rekappengeluaranheader.export');
    Route::get('rekappengeluaranheader/report/{id}', [RekapPengeluaranHeaderController::class, 'report'])->name('rekappengeluaranheader.report');
    Route::resource('rekappengeluaranheader', RekapPengeluaranHeaderController::class);

    Route::resource('rekappengeluarandetail', RekapPengeluaranDetailController::class);
    
    Route::get('rekappenerimaanheader/{id}/delete', [RekapPenerimaanHeaderController::class, 'delete'])->name('rekappenerimaanheader.delete');
    Route::get('rekappenerimaanheader/index', [RekapPenerimaanHeaderController::class, 'index']);
    Route::get('rekappenerimaanheader/get', [RekapPenerimaanHeaderController::class, 'get'])->name('rekappenerimaanheader.get');
    Route::get('rekappenerimaanheader/export', [RekapPenerimaanHeaderController::class, 'export'])->name('rekappenerimaanheader.export');
    Route::get('rekappenerimaanheader/report/{id}', [RekapPenerimaanHeaderController::class, 'report'])->name('rekappenerimaanheader.report');
    Route::resource('rekappenerimaanheader', RekapPenerimaanHeaderController::class);

    Route::resource('rekappenerimaandetail', RekapPenerimaanDetailController::class);

    //penerimaan trucking
    Route::get('penerimaantruckingheader/{id}/delete', [PenerimaanTruckingHeaderController::class, 'delete'])->name('penerimaantruckingheader.delete');
    Route::get('penerimaantruckingheader/index', [PenerimaanTruckingHeaderController::class, 'index']);
    Route::get('penerimaantruckingheader/get', [PenerimaanTruckingHeaderController::class, 'get'])->name('penerimaantruckingheader.get');
    Route::get('penerimaantruckingheader/export', [PenerimaanTruckingHeaderController::class, 'export'])->name('penerimaantruckingheader.export');
    Route::get('penerimaantruckingheader/report', [PenerimaanTruckingHeaderController::class, 'report'])->name('penerimaantruckingheader.report');
    Route::resource('penerimaantruckingheader', PenerimaanTruckingHeaderController::class);

    Route::resource('penerimaantruckingdetail', PenerimaanTruckingDetailController::class);

    Route::get('penerimaanstokheader/get', [PenerimaanStokHeaderController::class, 'get'])->name('penerimaanstokheader.get');
    Route::get('penerimaanstokheader/export', [PenerimaanStokHeaderController::class, 'export'])->name('penerimaanstokheader.export');
    Route::get('penerimaanstokheader/report', [PenerimaanStokHeaderController::class, 'report'])->name('penerimaanstokheader.report');
    Route::get('penerimaanstokheader/index', [PenerimaanStokHeaderController::class, 'index']);
    Route::resource('penerimaanstokheader', PenerimaanStokHeaderController::class);
    
    Route::resource('penerimaanstokdetail', PenerimaanStokDetailController::class);
    
    Route::get('pengeluaranstokheader/get', [PengeluaranStokHeaderController::class, 'get'])->name('pengeluaranstokheader.get');
    Route::get('pengeluaranstokheader/export', [PengeluaranStokHeaderController::class, 'export'])->name('pengeluaranstokheader.export');
    Route::get('pengeluaranstokheader/report', [PengeluaranStokHeaderController::class, 'report'])->name('pengeluaranstokheader.report');
    Route::get('pengeluaranstokheader/index', [PengeluaranStokHeaderController::class, 'index']);

    Route::resource('pengeluaranstokheader', PengeluaranStokHeaderController::class);
    
    Route::resource('pengeluaranstokdetail', PengeluaranStokDetailController::class);

    Route::get('jurnalumumheader/index', [JurnalUmumHeaderController::class, 'index']);
    Route::get('jurnalumumheader/{id}/delete', [JurnalUmumHeaderController::class, 'delete'])->name('jurnalumumheader.delete');
    Route::get('jurnalumumheader/get', [JurnalUmumHeaderController::class, 'get'])->name('jurnalumumheader.get');
    Route::get('jurnalumumheader/export', [JurnalUmumHeaderController::class, 'export'])->name('jurnalumumheader.export');
    Route::get('jurnalumumheader/report', [JurnalUmumHeaderController::class, 'report'])->name('jurnalumumheader.report');
    Route::resource('jurnalumumheader', JurnalUmumHeaderController::class);

    Route::resource('jurnalumumdetail', JurnalUmumDetailController::class);

    Route::get('pengeluarantruckingheader/index', [PengeluaranTruckingHeaderController::class, 'index']);
    Route::get('pengeluarantruckingheader/{id}/delete', [PengeluaranTruckingHeaderController::class, 'delete'])->name('pengeluarantruckingheader.delete');
    Route::get('pengeluarantruckingheader/get', [PengeluaranTruckingHeaderController::class, 'get'])->name('pengeluarantruckingheader.get');
    Route::get('pengeluarantruckingheader/export', [PengeluaranTruckingHeaderController::class, 'export'])->name('pengeluarantruckingheader.export');
    Route::get('pengeluarantruckingheader/report', [PengeluaranTruckingHeaderController::class, 'report'])->name('pengeluarantruckingheader.report');
    Route::resource('pengeluarantruckingheader', PengeluaranTruckingHeaderController::class);

    Route::resource('pengeluarantruckingdetail', PengeluaranTruckingDetailController::class);

    Route::get('hutangheader/index', [HutangHeaderController::class, 'index']);
    Route::get('hutangheader/{id}/delete', [HutangHeaderController::class, 'delete'])->name('hutangheader.delete');
    Route::get('hutangheader/get', [HutangHeaderController::class, 'get'])->name('hutangheader.get');
    Route::get('hutangheader/export', [HutangHeaderController::class, 'export'])->name('hutangheader.export');
    Route::get('hutangheader/report', [HutangHeaderController::class, 'report'])->name('hutangheader.report');
    Route::resource('hutangheader', HutangHeaderController::class);
    
    Route::resource('hutangdetail', HutangDetailController::class);

    Route::get('piutangheader/index', [PiutangHeaderController::class, 'index']);
    Route::get('piutangheader/{id}/delete', [PiutangHeaderController::class, 'delete'])->name('piutangheader.delete');
    Route::get('piutangheader/get', [PiutangHeaderController::class, 'get'])->name('piutangheader.get');
    Route::get('piutangheader/export', [PiutangHeaderController::class, 'export'])->name('piutangheader.export');
    Route::get('piutangheader/report', [PiutangHeaderController::class, 'report'])->name('piutangheader.report');
    Route::resource('piutangheader', PiutangHeaderController::class);

    Route::resource('piutangdetail', PiutangDetailController::class);

    Route::get('pelunasanpiutangheader/index', [PelunasanPiutangHeaderController::class, 'index']);
    Route::get('pelunasanpiutangheader/{id}/delete', [PelunasanPiutangHeaderController::class, 'delete'])->name('pelunasanpiutangheader.delete');
    Route::get('pelunasanpiutangheader/{id}/getpiutang', [PelunasanPiutangHeaderController::class, 'getpiutang'])->name('pelunasanpiutangheader.getpiutang');
    Route::get('pelunasanpiutangheader/get', [PelunasanPiutangHeaderController::class, 'get'])->name('pelunasanpiutangheader.get');
    Route::get('pelunasanpiutangheader/export', [PelunasanPiutangHeaderController::class, 'export'])->name('pelunasanpiutangheader.export');
    Route::get('pelunasanpiutangheader/report', [PelunasanPiutangHeaderController::class, 'report'])->name('pelunasanpiutangheader.report');
    Route::resource('pelunasanpiutangheader', PelunasanPiutangHeaderController::class);

    Route::resource('pelunasanpiutangdetail', PelunasanPiutangDetailController::class);

    Route::get('hutangbayarheader/index', [HutangBayarHeaderController::class, 'index']);
    Route::get('hutangbayarheader/{id}/delete', [HutangBayarHeaderController::class, 'delete'])->name('hutangbayarheader.delete');
    Route::get('hutangbayarheader/get', [HutangBayarHeaderController::class, 'get'])->name('hutangbayarheader.get');
    Route::get('hutangbayarheader/export', [HutangBayarHeaderController::class, 'export'])->name('hutangbayarheader.export');
    Route::get('hutangbayarheader/report', [HutangBayarHeaderController::class, 'report'])->name('hutangbayarheader.report');
    Route::resource('hutangbayarheader', HutangBayarHeaderController::class);

    Route::resource('hutangbayardetail', HutangBayarDetailController::class);

    
    Route::get('gajisupirheader/index', [GajiSupirHeaderController::class, 'index']);
    Route::get('gajisupirheader/{id}/delete', [GajiSupirHeaderController::class, 'delete'])->name('gajisupirheader.delete');
    Route::get('gajisupirheader/get', [GajiSupirHeaderController::class, 'get'])->name('gajisupirheader.get');
    Route::get('gajisupirheader/export', [GajiSupirHeaderController::class, 'export'])->name('gajisupirheader.export');
    Route::get('gajisupirheader/report', [GajiSupirHeaderController::class, 'report'])->name('gajisupirheader.report');
    Route::resource('gajisupirheader', GajiSupirHeaderController::class);

    Route::resource('gajisupirdetail', GajiSupirDetailController::class);
    
    Route::get('prosesgajisupirheader/index', [ProsesGajiSupirHeaderController::class, 'index']);
    Route::get('prosesgajisupirheader/{id}/delete', [ProsesGajiSupirHeaderController::class, 'delete'])->name('prosesgajisupirheader.delete');
    Route::get('prosesgajisupirheader/get', [ProsesGajiSupirHeaderController::class, 'get'])->name('prosesgajisupirheader.get');
    Route::get('prosesgajisupirheader/export', [ProsesGajiSupirHeaderController::class, 'export'])->name('prosesgajisupirheader.export');
    Route::get('prosesgajisupirheader/report', [ProsesGajiSupirHeaderController::class, 'report'])->name('prosesgajisupirheader.report');
    Route::resource('prosesgajisupirheader', ProsesGajiSupirHeaderController::class);
    Route::resource('prosesgajisupirdetail', ProsesGajiSupirDetailController::class);

    
    Route::get('invoiceheader/index', [InvoiceHeaderController::class, 'index']);
    Route::get('invoiceheader/{id}/delete', [InvoiceHeaderController::class, 'delete'])->name('invoiceheader.delete');
    Route::get('invoiceheader/get', [InvoiceHeaderController::class, 'get'])->name('invoiceheader.get');
    Route::get('invoiceheader/export', [InvoiceHeaderController::class, 'export'])->name('invoiceheader.export');
    Route::get('invoiceheader/report', [InvoiceHeaderController::class, 'report'])->name('invoiceheader.report');
    Route::resource('invoiceheader', InvoiceHeaderController::class);
    Route::resource('invoicedetail', InvoiceDetailController::class);
    
    Route::get('invoiceextraheader/index', [InvoiceExtraHeaderController::class, 'index']);
    Route::get('invoiceextraheader/get', [InvoiceExtraHeaderController::class, 'get'])->name('invoiceextraheader.get');
    Route::get('invoiceextraheader/export', [InvoiceExtraHeaderController::class, 'export'])->name('invoiceextraheader.export');
    Route::get('invoiceextraheader/report/{id}', [InvoiceExtraHeaderController::class, 'report'])->name('invoiceextraheader.report');
    Route::resource('invoiceextraheader', InvoiceExtraHeaderController::class);
    Route::resource('invoiceextradetail', InvoiceExtraDetailController::class);
    
    Route::get('approvaltransaksiheader/index', [ApprovalTransaksiHeaderController::class, 'index']);
    Route::resource('approvaltransaksiheader', ApprovalTransaksiHeaderController::class);

    Route::get('approvalinvoiceheader/index', [ApprovalInvoiceHeaderController::class, 'index']);
    Route::resource('approvalinvoiceheader', ApprovalInvoiceHeaderController::class);
    
    Route::get('approvalbukacetak/index', [ApprovalBukaCetakController::class, 'index']);
    Route::resource('approvalbukacetak', ApprovalBukaCetakController::class);

    Route::get('penerimaangiroheader/index', [PenerimaanGiroHeaderController::class, 'index']);
    Route::get('penerimaangiroheader/{id}/delete', [PenerimaanGiroHeaderController::class, 'delete'])->name('penerimaangiroheader.delete');
    Route::get('penerimaangiroheader/get', [PenerimaanGiroHeaderController::class, 'get'])->name('penerimaangiroheader.get');
    Route::get('penerimaangiroheader/export', [PenerimaanGiroHeaderController::class, 'export'])->name('penerimaangiroheader.export');
    Route::get('penerimaangiroheader/report', [PenerimaanGiroHeaderController::class, 'report'])->name('penerimaangiroheader.report');
    Route::resource('penerimaangiroheader', PenerimaanGiroHeaderController::class);
    Route::resource('penerimaangirodetail', PenerimaanGiroDetailController::class);

    Route::get('jurnalumumpusatheader/index', [JurnalUmumPusatHeaderController::class, 'index']);
    Route::get('jurnalumumpusatheader/get', [JurnalUmumPusatHeaderController::class, 'get'])->name('jurnalumumpusatheader.get');
    Route::get('jurnalumumpusatheader/export', [JurnalUmumPusatHeaderController::class, 'export'])->name('jurnalumumpusatheader.export');
    Route::get('jurnalumumpusatheader/report', [JurnalUmumPusatHeaderController::class, 'report'])->name('jurnalumumpusatheader.report');
    Route::resource('jurnalumumpusatheader', JurnalUmumPusatHeaderController::class);
    Route::resource('jurnalumumpusatdetail', JurnalUmumPusatDetailController::class);

    Route::get('harilibur/get', [HariLiburController::class, 'get'])->name('harilibur.get');
    Route::get('harilibur/index', [HariLiburController::class, 'index']);
    Route::resource('harilibur', HariLiburController::class);

    Route::get('reportall/report', [ReportAllController::class, 'report'])->name('reportall.report');
    Route::get('reportall/index', [ReportAllController::class, 'index']);
    Route::resource('reportall', ReportAllController::class);

    Route::get('pencairangiropengeluaranheader/index', [PencairanGiroPengeluaranHeaderController::class, 'index']);
    Route::get('pencairangiropengeluaranheader/get', [PencairanGiroPengeluaranHeaderController::class, 'get'])->name('pencairangiropengeluaranheader.get');
    Route::get('pencairangiropengeluaranheader/export', [PencairanGiroPengeluaranHeaderController::class, 'export'])->name('pencairangiropengeluaranheader.export');
    Route::get('pencairangiropengeluaranheader/report', [PencairanGiroPengeluaranHeaderController::class, 'report'])->name('pencairangiropengeluaranheader.report');
    Route::resource('pencairangiropengeluaranheader', PencairanGiroPengeluaranHeaderController::class);
    Route::resource('pencairangiropengeluarandetail', PencairanGiroPengeluaranDetailController::class);
    Route::get('reportneraca/report', [ReportNeracaController::class, 'report'])->name('reportneraca.report');
    Route::get('reportneraca/index', [ReportNeracaController::class, 'index']);
    Route::resource('reportneraca', ReportNeracaController::class);

    Route::get('approvalnotaheader/index', [ApprovalNotaHeaderController::class, 'index']);
    Route::resource('approvalnotaheader', ApprovalNotaHeaderController::class);

    Route::get('approvalhutangbayar/index', [ApprovalHutangBayarController::class, 'index']);
    Route::resource('approvalhutangbayar', ApprovalHutangBayarController::class);

    Route::get('pendapatansupirheader/export', [PendapatanSupirHeaderController::class, 'export'])->name('pendapatansupirheader.export');
    Route::get('pendapatansupirheader/report', [PendapatanSupirHeaderController::class, 'report'])->name('pendapatansupirheader.report');   
    Route::get('pendapatansupirheader/index', [PendapatanSupirHeaderController::class, 'index']);
    Route::resource('pendapatansupirheader', PendapatanSupirHeaderController::class);
    Route::resource('pendapatansupirdetail', PendapatanSupirDetailController::class);

    Route::get('approvalpendapatansupir/index', [ApprovalPendapatanSupirController::class, 'index']);
    Route::resource('approvalpendapatansupir', ApprovalPendapatanSupirController::class);
});

Route::patch('format', [FormatController::class, 'update']);
Route::get('lookup/{fileName}', [LookupController::class, 'show']);
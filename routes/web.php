<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AclController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StokController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TradoController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ExpSimController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\MandorController;
use App\Http\Controllers\OtobonController;
use App\Http\Controllers\RitasiController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\TujuanController;
use App\Http\Controllers\CcEmailController;
use App\Http\Controllers\ExpStnkController;
use App\Http\Controllers\JobEmklController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\ToEmailController;
use App\Http\Controllers\UserAclController;
use App\Http\Controllers\BccEmailController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;

use App\Http\Controllers\KelompokController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ListTripController;
use App\Http\Controllers\LogTrailController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TripInapController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AkunPusatController;
use App\Http\Controllers\AkuntansiController;
use App\Http\Controllers\AlatBayarController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportRicController;
use App\Http\Controllers\GandenganController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\InputTripController;
use App\Http\Controllers\JenisEmklController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ReportAllController;
use App\Http\Controllers\SpkHarianController;
use App\Http\Controllers\StokPusatController;
use App\Http\Controllers\TutupBukuController;

use App\Http\Controllers\UpahSupirController;
use App\Http\Controllers\AbsenTradoController;
use App\Http\Controllers\DataRitasiController;
use App\Http\Controllers\JenisOrderController;
use App\Http\Controllers\JenisTradoController;
use App\Http\Controllers\LogAbsensiController;

use App\Http\Controllers\MandorTripController;
use App\Http\Controllers\PindahBukuController;
use App\Http\Controllers\SupirSerapController;
use App\Http\Controllers\TripTangkiController;
use App\Http\Controllers\UpahRitasiController;
use App\Http\Controllers\BukaAbsensiController;
use App\Http\Controllers\ExpAsuransiController;
use App\Http\Controllers\HistoryTripController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Controllers\ReminderOliController;
use App\Http\Controllers\ReminderSpkController;
use App\Http\Controllers\SubKelompokController;
use App\Http\Controllers\TarifTangkiController;
use App\Http\Controllers\HutangDetailController;
use App\Http\Controllers\HutangHeaderController;
use App\Http\Controllers\OpnameHeaderController;
use App\Http\Controllers\ReminderStokController;
use App\Http\Controllers\ReportNeracaController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\BankPelangganController;

use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoiceHeaderController;
use App\Http\Controllers\KartuStokLamaController;

use App\Http\Controllers\LaporanNeracaController;
use App\Http\Controllers\MainAkunPusatController;
use App\Http\Controllers\PiutangDetailController;

use App\Http\Controllers\PiutangHeaderController;
use App\Http\Controllers\ReminderEmailController;

use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TypeAkuntansiController;
use App\Http\Controllers\ApprovalOpnameController;
use App\Http\Controllers\BlackListSupirController;
use App\Http\Controllers\LaporanArusKasController;
use App\Http\Controllers\LaporanKasBankController;
use App\Http\Controllers\PemutihanSupirController;
use App\Http\Controllers\PenerimaanStokController;
use App\Http\Controllers\StatusOliTradoController;
use App\Http\Controllers\StokPersediaanController;
use App\Http\Controllers\SuratPengantarController;
use App\Http\Controllers\ChargeGandenganController;
use App\Http\Controllers\GajiSupirDetailController;
use App\Http\Controllers\GajiSupirHeaderController;
use App\Http\Controllers\LaporanLabaRugiController;
use App\Http\Controllers\NotaDebetDetailController;
use App\Http\Controllers\NotaDebetHeaderController;

use App\Http\Controllers\OrderanTruckingController;
use App\Http\Controllers\PengeluaranStokController;
use App\Http\Controllers\ReminderServiceController;
use App\Http\Controllers\ServiceInDetailController;

use App\Http\Controllers\ServiceInHeaderController;
use App\Http\Controllers\StatusContainerController;

use App\Http\Controllers\UpahSupirTangkiController;
use App\Http\Controllers\ImportDataCabangController;
use App\Http\Controllers\JurnalUmumDetailController;

use App\Http\Controllers\JurnalUmumHeaderController;
use App\Http\Controllers\KasGantungDetailController;
use App\Http\Controllers\KasGantungHeaderController;

use App\Http\Controllers\LaporanBukuBesarController;
use App\Http\Controllers\LaporanHutangBBMController;
use App\Http\Controllers\LaporanKartuStokController;
use App\Http\Controllers\LaporanKasHarianController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanTripTradoController;
use App\Http\Controllers\LaporanUangJalanController;
use App\Http\Controllers\NotaKreditDetailController;
use App\Http\Controllers\NotaKreditHeaderController;
use App\Http\Controllers\PenerimaanDetailController;
use App\Http\Controllers\PenerimaanHeaderController;
use App\Http\Controllers\ServiceOutDetailController;
use App\Http\Controllers\ServiceOutHeaderController;
use App\Http\Controllers\TarikDataAbsensiController;
use App\Http\Controllers\UpahSupirRincianController;
use App\Http\Controllers\ApprovalBukaCetakController;
use App\Http\Controllers\ApprovalStokReuseController;
use App\Http\Controllers\ExportLaporanStokController;
use App\Http\Controllers\HutangBayarDetailController;

use App\Http\Controllers\HutangBayarHeaderController;
use App\Http\Controllers\HutangExtraDetailController;
use App\Http\Controllers\HutangExtraHeaderController;
use App\Http\Controllers\LaporanBiayaSupirController;
use App\Http\Controllers\LaporanDataJurnalController;
use App\Http\Controllers\LaporanHutangGiroController;
use App\Http\Controllers\LaporanJurnalUmumController;
use App\Http\Controllers\LaporanKasGantungController;
use App\Http\Controllers\MainTypeAkuntansiController;
use App\Http\Controllers\PengajuanTripInapController;
use App\Http\Controllers\PengeluaranDetailController;
use App\Http\Controllers\PengeluaranHeaderController;
use App\Http\Controllers\QtyTambahGantiOliController;
use App\Http\Controllers\UpahRitasiRincianController;
use App\Http\Controllers\AbsensiSupirDetailController;
use App\Http\Controllers\AbsensiSupirHeaderController;
use App\Http\Controllers\ApprovalNotaHeaderController;
use App\Http\Controllers\BukaPenerimaanStokController;
use App\Http\Controllers\InvoiceExtraDetailController;
use App\Http\Controllers\InvoiceExtraHeaderController;
use App\Http\Controllers\KaryawanLogAbsensiController;
use App\Http\Controllers\LaporanKartuPanjarController;
use App\Http\Controllers\LaporanPiutangGiroController;
use App\Http\Controllers\LaporanRitasiTradoController;
use App\Http\Controllers\LaporanTitipanEmklController;
use App\Http\Controllers\MandorAbsensiSupirController;
use App\Http\Controllers\penerimaanTruckingController;
use App\Http\Controllers\ProsesAbsensiSupirController;
use App\Http\Controllers\TarifDiscountHargaController;
use App\Http\Controllers\TarifHargaTertentuController;
use App\Http\Controllers\ApprovalHutangBayarController;
use App\Http\Controllers\ApprovalKirimBerkasController;
use App\Http\Controllers\ApprovalSupirGambarController;
use App\Http\Controllers\ApprovalTradoGambarController;
use App\Http\Controllers\BukaPengeluaranStokController;
use App\Http\Controllers\InvoiceLunasKePusatController;
use App\Http\Controllers\LaporanPemakaianBanController;
use App\Http\Controllers\PengeluaranTruckingController;
use App\Http\Controllers\LaporanArusDanaPusatController;
use App\Http\Controllers\LaporanDepositoSupirController;
use App\Http\Controllers\LaporanKlaimPJTSupirController;
use App\Http\Controllers\LaporanMutasiKasBankController;
use App\Http\Controllers\LaporanPemakaianStokController;
use App\Http\Controllers\LaporanPembelianStokController;
use App\Http\Controllers\LaporanPinjamanSupirController;


use App\Http\Controllers\PemutihanSupirDetailController;
use App\Http\Controllers\PenerimaanGiroDetailController;
use App\Http\Controllers\PenerimaanGiroHeaderController;
use App\Http\Controllers\PenerimaanStokDetailController;
use App\Http\Controllers\PenerimaanStokHeaderController;
use App\Http\Controllers\StatusGandenganTradoController;
use App\Http\Controllers\StatusGandenganTruckController;
use App\Http\Controllers\TradoTambahanAbsensiController;
use App\Http\Controllers\ApprovalInvoiceHeaderController;
use App\Http\Controllers\BiayaExtraSupirHeaderController;
use App\Http\Controllers\ExportLaporanDepositoController;
use App\Http\Controllers\ExportPemakaianBarangController;
use App\Http\Controllers\ExportPembelianBarangController;
use App\Http\Controllers\ExportRincianMingguanController;
use App\Http\Controllers\HistoriPenerimaanStokController;
use App\Http\Controllers\JurnalUmumPusatDetailController;
use App\Http\Controllers\JurnalUmumPusatHeaderController;
use App\Http\Controllers\LaporanOrderPembelianController;
use App\Http\Controllers\LaporanRekapSumbanganController;
use App\Http\Controllers\LaporanSaldoInventoryController;
use App\Http\Controllers\PelunasanHutangHeaderController;
use App\Http\Controllers\PendapatanSupirDetailController;
use App\Http\Controllers\PendapatanSupirHeaderController;
use App\Http\Controllers\PengeluaranStokDetailController;
use App\Http\Controllers\PengeluaranStokHeaderController;
use App\Http\Controllers\ProsesGajiSupirDetailController;
use App\Http\Controllers\ProsesGajiSupirHeaderController;
use App\Http\Controllers\RekapPenerimaanDetailController;
use App\Http\Controllers\RekapPenerimaanHeaderController;
use App\Http\Controllers\TradoSupirMilikMandorController;
use App\Http\Controllers\ExportLaporanKasHarianController;
use App\Http\Controllers\ExportPerhitunganBonusController;
use App\Http\Controllers\HistoriPengeluaranStokController;
use App\Http\Controllers\LaporanHistoryDepositoController;
use App\Http\Controllers\LaporanHistoryPinjamanController;
use App\Http\Controllers\LaporanPembelianBarangController;
use App\Http\Controllers\LaporanRitasiGandenganController;
use App\Http\Controllers\LaporanTransaksiHarianController;
use App\Http\Controllers\LaporanWarkatBelumCairController;
use App\Http\Controllers\PelunasanPiutangDetailController;
use App\Http\Controllers\PelunasanPiutangHeaderController;
use App\Http\Controllers\RekapPengeluaranDetailController;
use App\Http\Controllers\RekapPengeluaranHeaderController;
use App\Http\Controllers\ApprovalPendapatanSupirController;
use App\Http\Controllers\ApprovalSupirKeteranganController;
use App\Http\Controllers\ApprovalTradoKeteranganController;
use App\Http\Controllers\ApprovalTransaksiHeaderController;
use App\Http\Controllers\ExportLaporanKasGantungController;
use App\Http\Controllers\ExportPengeluaranBarangController;
use App\Http\Controllers\LaporanDepositoKaryawanController;
use App\Http\Controllers\LaporanRekapTitipanEmklController;
use App\Http\Controllers\LaporanApprovalStokReuseController;
use App\Http\Controllers\LaporanPenyesuaianBarangController;
use App\Http\Controllers\PenerimaanTruckingDetailController;
use App\Http\Controllers\PenerimaanTruckingHeaderController;
use App\Http\Controllers\LaporanBanGudangSementaraController;
use App\Http\Controllers\LaporanEstimasiKasGantungController;
use App\Http\Controllers\LaporanSaldoInventoryLamaController;
use App\Http\Controllers\MandorAbsensiSupirHistoryController;
use App\Http\Controllers\PengeluaranTruckingDetailController;
use App\Http\Controllers\PengeluaranTruckingHeaderController;
use App\Http\Controllers\PengembalianKasBankDetailController;
use App\Http\Controllers\PengembalianKasBankHeaderController;
use App\Http\Controllers\AbsensiSupirApprovalDetailController;
use App\Http\Controllers\AbsensiSupirApprovalHeaderController;
use App\Http\Controllers\ExportLaporanMingguanSupirController;
use App\Http\Controllers\LaporanKartuHutangPrediksiController;
use App\Http\Controllers\LaporanKartuPiutangPerAgenController;
use App\Http\Controllers\LaporanSupirLebihDariTradoController;
use App\Http\Controllers\LaporanSupplierBandingStokController;
use App\Http\Controllers\LaporanTripGandenganDetailController;
use App\Http\Controllers\ProsesUangJalanSupirDetailController;
use App\Http\Controllers\ProsesUangJalanSupirHeaderController;
use App\Http\Controllers\LaporanKartuHutangPerVendorController;
use App\Http\Controllers\LaporanPinjamanPerUnitTradoController;
use App\Http\Controllers\SuratPengantarBiayaTambahanController;
use App\Http\Controllers\InvoiceChargeGandenganHeaderController;
use App\Http\Controllers\LaporanPinjamanSupirKaryawanController;
use App\Http\Controllers\PengembalianKasGantungDetailController;
use App\Http\Controllers\PengembalianKasGantungHeaderController;
use App\Http\Controllers\LapKartuHutangPerVendorDetailController;
use App\Http\Controllers\LaporanHistoryTradoMilikSupirController;
use App\Http\Controllers\LaporanKartuHutangPerSupplierController;
use App\Http\Controllers\LaporanPemotonganPinjamanDepoController;
use App\Http\Controllers\LaporanHistorySupirMilikMandorController;
use App\Http\Controllers\LaporanHistoryTradoMilikMandorController;
use App\Http\Controllers\LaporanKeteranganPinjamanSupirController;
use App\Http\Controllers\LaporanPinjamanBandingPeriodeController;
use App\Http\Controllers\LaporanKalkulasiEmklController;
use App\Http\Controllers\LaporanMingguanSupirBedaMandorController;
use App\Http\Controllers\PencairanGiroPengeluaranDetailController;
use App\Http\Controllers\PencairanGiroPengeluaranHeaderController;
use App\Http\Controllers\LaporanKartuPiutangPerPelangganController;
use App\Http\Controllers\LaporanKartuPiutangPerPlgDetailController;
use App\Http\Controllers\LaporanPemotonganPinjamanPerEBSController;
use App\Http\Controllers\SuratPengantarApprovalInputTripController;
use App\Http\Controllers\ApprovalBukaTanggalSuratPengantarController;
use App\Http\Controllers\LaporanPemotonganPinjamanDepositoController;
use App\Http\Controllers\ExportRincianMingguanPendapatanSupirController;
use App\Http\Controllers\InvoiceEmklHeaderController;

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

Route::get('cekip', [AuthController::class, 'cekIp']);
Route::get('cekparam', [AuthController::class, 'cek_param']);

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::get('login/index', [AuthController::class, 'index']);
    Route::post('login', [AuthController::class, 'login'])->name('login.process');
});

Route::get('reset-password/expired', [ResetPasswordController::class, 'expired'])->name('reset-password.expired');
Route::get('reset-password/success', [ResetPasswordController::class, 'success'])->name('reset-password.success');

Route::get('reminderspkdetail/export', [ReminderSpkController::class, 'export'])->name('reminderspkdetail.export');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index')->middleware('jwt');

Route::get('statusolitrado/exportdetail', [StatusOliTradoController::class, 'exportdetail'])->name('statusolitrado.exportdetail');
Route::get('stokpusat/tokenmdn', [StokPusatController::class, 'tokenMdn']);
Route::get('stokpusat/tokenmks', [StokPusatController::class, 'tokenMks']);
Route::get('stokpusat/tokenjkt', [StokPusatController::class, 'tokenJkt']);
Route::get('stokpusat/tokenjkttnl', [StokPusatController::class, 'tokenJktTnl']);
Route::middleware(['auth', 'authorized'])->group(function () {
    Route::get('importdatacabang/index', [ImportDataCabangController::class, 'index']);
    Route::get('importdatacabang', [ImportDataCabangController::class, 'index']);

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

    Route::get('dataritasi/field_length', [DataRitasiController::class, 'fieldLength'])->name('dataritasi.field_length');
    Route::get('dataritasi/{id}/delete', [DataRitasiController::class, 'delete'])->name('dataritasi.delete');
    Route::get('dataritasi/index', [DataRitasiController::class, 'index']);
    Route::get('dataritasi/get', [DataRitasiController::class, 'get'])->name('dataritasi.get');
    Route::get('dataritasi/export', [DataRitasiController::class, 'export'])->name('dataritasi.export');
    Route::get('dataritasi/report', [DataRitasiController::class, 'report'])->name('dataritasi.report');
    Route::resource('dataritasi', DataRitasiController::class);

    Route::get('akuntansi/field_length', [AkuntansiController::class, 'fieldLength'])->name('akuntansi.field_length');
    Route::get('akuntansi/{id}/delete', [AkuntansiController::class, 'delete'])->name('akuntansi.delete');
    Route::get('akuntansi/index', [AkuntansiController::class, 'index']);
    Route::get('akuntansi/get', [AkuntansiController::class, 'get'])->name('akuntansi.get');
    Route::get('akuntansi/export', [AkuntansiController::class, 'export'])->name('akuntansi.export');
    Route::get('akuntansi/report', [AkuntansiController::class, 'report'])->name('akuntansi.report');
    Route::resource('akuntansi', AkuntansiController::class);

    Route::get('typeakuntansi/field_length', [TypeAkuntansiController::class, 'fieldLength'])->name('typeakuntansi.field_length');
    Route::get('typeakuntansi/{id}/delete', [TypeAkuntansiController::class, 'delete'])->name('typeakuntansi.delete');
    Route::get('typeakuntansi/index', [TypeAkuntansiController::class, 'index']);
    Route::get('typeakuntansi/get', [TypeAkuntansiController::class, 'get'])->name('typeakuntansi.get');
    Route::get('typeakuntansi/export', [TypeAkuntansiController::class, 'export'])->name('typeakuntansi.export');
    Route::get('typeakuntansi/report', [TypeAkuntansiController::class, 'report'])->name('typeakuntansi.report');
    Route::resource('typeakuntansi', TypeAkuntansiController::class);

    Route::get('maintypeakuntansi/field_length', [MainTypeAkuntansiController::class, 'fieldLength'])->name('maintypeakuntansi.field_length');
    Route::get('maintypeakuntansi/{id}/delete', [MainTypeAkuntansiController::class, 'delete'])->name('maintypeakuntansi.delete');
    Route::get('maintypeakuntansi/index', [MainTypeAkuntansiController::class, 'index']);
    Route::get('maintypeakuntansi/get', [MainTypeAkuntansiController::class, 'get'])->name('maintypeakuntansi.get');
    Route::get('maintypeakuntansi/export', [MainTypeAkuntansiController::class, 'export'])->name('maintypeakuntansi.export');
    Route::get('maintypeakuntansi/report', [MainTypeAkuntansiController::class, 'report'])->name('maintypeakuntansi.report');
    Route::resource('maintypeakuntansi', MainTypeAkuntansiController::class);

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
    Route::get('role/acl/grid', [RoleController::class, 'aclGrid']);
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
    Route::get('user/acl/grid', [UserController::class, 'aclGrid']);
    Route::get('user/role/grid', [UserController::class, 'roleGrid']);
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

    Route::get('absensisupir_detail/kasgantung/grid', [AbsensiSupirDetailController::class, 'kasgantungGrid']);
    Route::get('absensisupir_detail/detail/grid', [AbsensiSupirDetailController::class, 'detailGrid']);
    Route::resource('absensisupir_detail', AbsensiSupirDetailController::class);

    Route::get('approvalsupirgambar/index', [ApprovalSupirGambarController::class, 'index']);
    Route::resource('approvalsupirgambar', ApprovalSupirGambarController::class);

    Route::get('approvalsupirketerangan/index', [ApprovalSupirKeteranganController::class, 'index']);
    Route::resource('approvalsupirketerangan', ApprovalSupirKeteranganController::class);

    Route::get('blacklistsupir/index', [BlackListSupirController::class, 'index']);
    Route::resource('blacklistsupir', BlackListSupirController::class);

    Route::get('tradosupirmilikmandor/index', [TradoSupirMilikMandorController::class, 'index']);
    Route::resource('tradosupirmilikmandor', TradoSupirMilikMandorController::class);

    Route::get('bukaabsensi/index', [BukaAbsensiController::class, 'index']);
    Route::resource('bukaabsensi', BukaAbsensiController::class);

    Route::get('bukapenerimaanstok/index', [BukaPenerimaanStokController::class, 'index']);
    Route::resource('bukapenerimaanstok', BukaPenerimaanStokController::class);
    Route::get('bukapengeluaranstok/index', [BukaPengeluaranStokController::class, 'index']);
    Route::resource('bukapengeluaranstok', BukaPengeluaranStokController::class);

    Route::get('suratpengantarapprovalinputtrip/index', [SuratPengantarApprovalInputTripController::class, 'index']);
    Route::resource('suratpengantarapprovalinputtrip', SuratPengantarApprovalInputTripController::class);

    Route::get('absensisupirapprovalheader/{id}/delete', [AbsensiSupirApprovalHeaderController::class, 'delete'])->name('absensisupirapprovalheader.delete');
    Route::get('absensisupirapprovalheader/index', [AbsensiSupirApprovalHeaderController::class, 'index']);
    Route::get('absensisupirapprovalheader/get', [AbsensiSupirApprovalHeaderController::class, 'get'])->name('absensisupirapprovalheader.get');
    Route::get('absensisupirapprovalheader/export', [AbsensiSupirApprovalHeaderController::class, 'export'])->name('absensisupirapprovalheader.export');
    Route::get('absensisupirapprovalheader/report', [AbsensiSupirApprovalHeaderController::class, 'report'])->name('absensisupirapprovalheader.report');
    Route::resource('absensisupirapprovalheader', AbsensiSupirApprovalHeaderController::class);

    Route::get('absensisupirapprovaldetail/jurnal/grid', [AbsensiSupirApprovalDetailController::class, 'jurnalGrid']);
    Route::get('absensisupirapprovaldetail/pengeluaran/grid', [AbsensiSupirApprovalDetailController::class, 'pengeluaranGrid']);
    Route::get('absensisupirapprovaldetail/detail/grid', [AbsensiSupirApprovalDetailController::class, 'detailGrid']);
    Route::resource('absensisupirapprovaldetail', AbsensiSupirApprovalDetailController::class);

    Route::get('mandorabsensisupirhistory', [MandorAbsensiSupirHistoryController::class, 'index']);
    Route::get('mandorabsensisupirhistory/index', [MandorAbsensiSupirHistoryController::class, 'index']);
    Route::get('mandorabsensisupir/index', [MandorAbsensiSupirController::class, 'index']);
    Route::resource('mandorabsensisupir', MandorAbsensiSupirController::class);

    Route::get('invoicelunaskepusat/report', [InvoiceLunasKePusatController::class, 'report'])->name('invoicelunaskepusat.report');
    Route::get('invoicelunaskepusat/export', [InvoiceLunasKePusatController::class, 'export'])->name('invoicelunaskepusat.export');
    Route::get('invoicelunaskepusat/index', [InvoiceLunasKePusatController::class, 'index']);
    Route::resource('invoicelunaskepusat', InvoiceLunasKePusatController::class);


    Route::get('historytrip/index', [HistoryTripController::class, 'index']);
    Route::get('listtrip/index', [ListTripController::class, 'index']);
    Route::get('inputtrip/index', [InputTripController::class, 'index']);
    Route::get('historytrip', [HistoryTripController::class, 'index']);
    Route::get('listtrip', [ListTripController::class, 'index']);
    Route::get('inputtrip', [InputTripController::class, 'index']);

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
    Route::get('trado/report', [TradoController::class, 'report'])->name('trado.report');
    Route::get('trado/export', [TradoController::class, 'export'])->name('trado.export');
    Route::get('trado/get', [TradoController::class, 'get'])->name('trado.get');
    Route::get('trado/index', [TradoController::class, 'index']);
    Route::resource('trado', TradoController::class);

    Route::get('stok/field_length', [StokController::class, 'fieldLength'])->name('stok.field_length');
    Route::get('stok/{id}/delete', [StokController::class, 'delete'])->name('stok.delete');
    Route::get('stok/get', [StokController::class, 'get'])->name('stok.get');
    Route::get('stok/report', [StokController::class, 'report'])->name('stok.report');
    Route::get('stok/index', [StokController::class, 'index']);
    Route::resource('stok', StokController::class);

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
    Route::get('container/export', [ContainerController::class, 'export'])->name('container.export');
    Route::get('container/report', [ContainerController::class, 'report'])->name('container.report');
    Route::resource('container', ContainerController::class);

    Route::get('qtytambahgantioli/field_length', [QtyTambahGantiOliController::class, 'fieldLength'])->name('qtytambahgantioli.field_length');
    Route::get('qtytambahgantioli/{id}/delete', [QtyTambahGantiOliController::class, 'delete'])->name('qtytambahgantioli.delete');
    Route::get('qtytambahgantioli/index', [QtyTambahGantiOliController::class, 'index']);
    Route::get('qtytambahgantioli/get', [QtyTambahGantiOliController::class, 'get'])->name('qtytambahgantioli.get');
    Route::get('qtytambahgantioli/export', [QtyTambahGantiOliController::class, 'export'])->name('qtytambahgantioli.export');
    Route::get('qtytambahgantioli/report', [QtyTambahGantiOliController::class, 'report'])->name('qtytambahgantioli.report');
    Route::resource('qtytambahgantioli', QtyTambahGantiOliController::class);    

    Route::get('tarifdiscountharga/field_length', [TarifDiscountHargaController::class, 'fieldLength'])->name('tarifdiscountharga.field_length');
    Route::get('tarifdiscountharga/{id}/delete', [TarifDiscountHargaController::class, 'delete'])->name('tarifdiscountharga.delete');
    Route::get('tarifdiscountharga/index', [TarifDiscountHargaController::class, 'index']);
    Route::get('tarifdiscountharga/get', [TarifDiscountHargaController::class, 'get'])->name('tarifdiscountharga.get');
    Route::get('tarifdiscountharga/export', [TarifDiscountHargaController::class, 'export'])->name('tarifdiscountharga.export');
    Route::get('tarifdiscountharga/report', [TarifDiscountHargaController::class, 'report'])->name('tarifdiscountharga.report');
    Route::resource('tarifdiscountharga', TarifDiscountHargaController::class);

    Route::get('tarifhargatertentu/index', [TarifHargaTertentuController::class, 'index']);
    Route::get('tarifhargatertentu/export', [TarifHargaTertentuController::class, 'export'])->name('tarifhargatertentu.export');
    Route::get('tarifhargatertentu/report', [TarifHargaTertentuController::class, 'report'])->name('tarifhargatertentu.report');
    Route::resource('tarifhargatertentu', TarifHargaTertentuController::class);




    Route::get('supir/field_length', [SupirController::class, 'fieldLength'])->name('supir.field_length');
    Route::get('supir/{id}/delete', [SupirController::class, 'delete'])->name('supir.delete');
    Route::get('supir/get', [SupirController::class, 'get'])->name('supir.get');
    Route::get('supir/index', [SupirController::class, 'index']);
    Route::get('supir/export', [SupirController::class, 'export'])->name('supir.export');
    Route::get('supir/report', [SupirController::class, 'report'])->name('supir.report');
    Route::resource('supir', SupirController::class);

    Route::get('bank/field_length', [BankController::class, 'fieldLength'])->name('bank.field_length');
    Route::get('bank/index', [BankController::class, 'index']);
    Route::get('bank/{id}/delete', [BankController::class, 'delete'])->name('bank.delete');
    Route::get('bank/get', [BankController::class, 'get'])->name('bank.get');
    Route::get('bank/index', [BankController::class, 'index']);
    Route::get('bank/report', [BankController::class, 'report'])->name('bank.report');
    Route::resource('bank', BankController::class);

    Route::get('absentrado/field_length', [AbsenTradoController::class, 'fieldLength'])->name('absentrado.field_length');
    Route::get('absentrado/{id}/delete', [AbsenTradoController::class, 'delete'])->name('absentrado.delete');
    Route::get('absentrado/index', [AbsenTradoController::class, 'index']);
    Route::get('absentrado/report', [AbsenTradoController::class, 'report'])->name('absentrado.report');
    Route::get('absentrado/export', [AbsenTradoController::class, 'export'])->name('absentrado.export');
    Route::get('absentrado/get', [AbsenTradoController::class, 'get'])->name('absentrado.get');
    Route::resource('absentrado', AbsenTradoController::class);

    Route::get('customer/field_length', [CustomerController::class, 'fieldLength'])->name('customer.field_length');
    Route::get('customer/{id}/delete', [CustomerController::class, 'delete'])->name('customer.delete');
    Route::get('customer/index', [CustomerController::class, 'index']);
    Route::get('customer/report', [CustomerController::class, 'report'])->name('customer.report');
    Route::get('customer/export', [CustomerController::class, 'export'])->name('customer.export');
    Route::get('customer/get', [CustomerController::class, 'get'])->name('customer.get');
    Route::resource('customer', CustomerController::class);

    Route::get('akunpusat/field_length', [AkunPusatController::class, 'fieldLength'])->name('akunpusat.field_length');
    Route::get('akunpusat/{id}/delete', [AkunPusatController::class, 'delete'])->name('akunpusat.delete');
    Route::get('akunpusat/index', [AkunPusatController::class, 'index']);
    Route::get('akunpusat/report', [AkunPusatController::class, 'report'])->name('akunpusat.report');
    Route::get('akunpusat/export', [AkunPusatController::class, 'export'])->name('akunpusat.export');
    Route::get('akunpusat/get', [AkunPusatController::class, 'get'])->name('akunpusat.get');
    Route::resource('akunpusat', AkunPusatController::class);

    Route::get('mainakunpusat/index', [MainAkunPusatController::class, 'index']);
    Route::get('mainakunpusat/report', [MainAkunPusatController::class, 'report'])->name('mainakunpusat.report');
    Route::get('mainakunpusat/export', [MainAkunPusatController::class, 'export'])->name('mainakunpusat.export');
    Route::resource('mainakunpusat', MainAkunPusatController::class);

    Route::get('alatbayar/field_length', [AlatBayarController::class, 'fieldLength'])->name('alatbayar.field_length');
    Route::get('alatbayar/{id}/delete', [AlatBayarController::class, 'delete'])->name('alatbayar.delete');
    Route::get('alatbayar/get', [AlatBayarController::class, 'get'])->name('alatbayar.get');
    Route::get('alatbayar/index', [AlatBayarController::class, 'index']);
    Route::get('alatbayar/report', [AlatBayarController::class, 'report'])->name('alatbayar.report');
    Route::resource('alatbayar', AlatBayarController::class);

    Route::get('bankpelanggan/field_length', [BankPelangganController::class, 'fieldLength'])->name('bankpelanggan.field_length');
    Route::get('bankpelanggan/{id}/delete', [BankPelangganController::class, 'delete'])->name('bankpelanggan.delete');
    Route::get('bankpelanggan/get', [BankPelangganController::class, 'get'])->name('bankpelanggan.get');
    Route::get('bankpelanggan/index', [BankPelangganController::class, 'index']);
    Route::get('bankpelanggan/report', [BankPelangganController::class, 'report'])->name('bankpelanggan.report');
    Route::resource('bankpelanggan', BankPelangganController::class);

    Route::get('jenisemkl/field_length', [JenisEmklController::class, 'fieldLength'])->name('jenisemkl.field_length');
    Route::get('jenisemkl/{id}/delete', [JenisEmklController::class, 'delete'])->name('jenisemkl.delete');
    Route::get('jenisemkl/get', [JenisEmklController::class, 'get'])->name('jenisemkl.get');
    Route::get('jenisemkl/index', [JenisEmklController::class, 'index']);
    Route::get('jenisemkl/export', [JenisEmklController::class, 'export'])->name('jenisemkl.export');
    Route::get('jenisemkl/report', [JenisEmklController::class, 'report'])->name('jenisemkl.report');
    Route::resource('jenisemkl', JenisEmklController::class);

    Route::get('jenisorder/field_length', [JenisOrderController::class, 'fieldLength'])->name('jenisorder.field_length');
    Route::get('jenisorder/{id}/delete', [JenisOrderController::class, 'delete'])->name('jenisorder.delete');
    Route::get('jenisorder/get', [JenisOrderController::class, 'get'])->name('jenisorder.get');
    Route::get('jenisorder/index', [JenisOrderController::class, 'index']);
    Route::get('jenisorder/export', [JenisOrderController::class, 'export'])->name('jenisorder.export');
    Route::get('jenisorder/report', [JenisOrderController::class, 'report'])->name('jenisorder.report');
    Route::resource('jenisorder', JenisOrderController::class);

    Route::get('jenistrado/field_length', [JenisTradoController::class, 'fieldLength'])->name('jenistrado.field_length');
    Route::get('jenistrado/{id}/delete', [JenisTradoController::class, 'delete'])->name('jenistrado.delete');
    Route::get('jenistrado/get', [JenisTradoController::class, 'get'])->name('jenistrado.get');
    Route::get('jenistrado/index', [JenisTradoController::class, 'index']);
    Route::get('jenistrado/export', [JenisTradoController::class, 'export'])->name('jenistrado.export');
    Route::get('jenistrado/report', [JenisTradoController::class, 'report'])->name('jenistrado.report');
    Route::resource('jenistrado', JenisTradoController::class);

    Route::get('kasgantungheader/{id}/delete', [KasGantungHeaderController::class, 'delete'])->name('kasgantungheader.delete');
    Route::get('kasgantungheader/index', [KasGantungHeaderController::class, 'index']);
    Route::get('kasgantungheader/get', [KasGantungHeaderController::class, 'get'])->name('kasgantungheader.get');
    Route::get('kasgantungheader/export', [KasGantungHeaderController::class, 'export'])->name('kasgantungheader.export');
    Route::get('kasgantungheader/report', [KasGantungHeaderController::class, 'report'])->name('kasgantungheader.report');
    Route::resource('kasgantungheader', KasGantungHeaderController::class);

    Route::get('kasgantungdetail/jurnal/grid', [KasGantungDetailController::class, 'jurnalGrid']);
    Route::get('kasgantungdetail/pengeluaran/grid', [KasGantungDetailController::class, 'pengeluaranGrid']);
    Route::get('kasgantungdetail/detail/grid', [KasGantungDetailController::class, 'detailGrid']);
    Route::resource('kasgantungdetail', KasGantungDetailController::class);

    Route::get('pengembaliankasgantungheader/get', [PengembalianKasGantungHeaderController::class, 'get'])->name('pengembaliankasgantungheader.get');
    Route::get('pengembaliankasgantungheader/export', [PengembalianKasGantungHeaderController::class, 'export'])->name('pengembaliankasgantungheader.export');
    Route::get('pengembaliankasgantungheader/report', [PengembalianKasGantungHeaderController::class, 'report'])->name('pengembaliankasgantungheader.report');
    Route::get('pengembaliankasgantungheader/index', [PengembalianKasGantungHeaderController::class, 'index']);
    Route::resource('pengembaliankasgantungheader', PengembalianKasGantungHeaderController::class);

    Route::get('pengembaliankasgantungdetail/jurnal/grid', [PengembalianKasGantungDetailController::class, 'jurnalGrid']);
    Route::get('pengembaliankasgantungdetail/penerimaan/grid', [PengembalianKasGantungDetailController::class, 'penerimaanGrid']);
    Route::get('pengembaliankasgantungdetail/detail/grid', [PengembalianKasGantungDetailController::class, 'detailGrid']);
    Route::resource('pengembaliankasgantungdetail', PengembalianKasGantungDetailController::class);

    Route::get('pengembaliankasbankheader/get', [PengembalianKasbankHeaderController::class, 'get'])->name('pengembaliankasbankheader.get');
    Route::get('pengembaliankasbankheader/export', [PengembalianKasbankHeaderController::class, 'export'])->name('pengembaliankasbankheader.export');
    Route::get('pengembaliankasbankheader/report', [PengembalianKasbankHeaderController::class, 'report'])->name('pengembaliankasbankheader.report');
    Route::get('pengembaliankasbankheader/index', [PengembalianKasbankHeaderController::class, 'index']);
    Route::resource('pengembaliankasbankheader', PengembalianKasbankHeaderController::class);

    Route::get('pengembaliankasbankdetail/jurnal/grid', [PengembalianKasBankDetailController::class, 'jurnalGrid']);
    Route::get('pengembaliankasbankdetail/pengeluaran/grid', [PengembalianKasBankDetailController::class, 'pengeluaranGrid']);
    Route::get('pengembaliankasbankdetail/detail/grid', [PengembalianKasBankDetailController::class, 'detailGrid']);
    Route::resource('pengembaliankasbankdetail', PengembalianKasBankDetailController::class);

    Route::get('notakreditheader/get', [NotaKreditHeaderController::class, 'get'])->name('notakreditheader.get');
    Route::get('notakreditheader/export', [NotaKreditHeaderController::class, 'export'])->name('notakreditheader.export');
    Route::get('notakreditheader/report', [NotaKreditHeaderController::class, 'report'])->name('notakreditheader.report');
    Route::get('notakreditheader/index', [NotaKreditHeaderController::class, 'index']);
    Route::resource('notakreditheader', NotaKreditHeaderController::class);

    Route::get('notakreditdetail/jurnal/grid', [NotaKreditDetailController::class, 'jurnalGrid']);
    Route::get('notakreditdetail/penerimaan/grid', [NotaKreditDetailController::class, 'penerimaanGrid']);
    Route::get('notakreditdetail/pelunasan/grid', [NotaKreditDetailController::class, 'pelunasanGrid']);
    Route::get('notakreditdetail/detail/grid', [NotaKreditDetailController::class, 'detailGrid']);
    Route::resource('notakreditdetail', NotaKreditDetailController::class);

    Route::get('notadebetheader/get', [NotaDebetHeaderController::class, 'get'])->name('notadebetheader.get');
    Route::get('notadebetheader/export', [NotaDebetHeaderController::class, 'export'])->name('notadebetheader.export');
    Route::get('notadebetheader/report/{id}', [NotaDebetHeaderController::class, 'report'])->name('notadebetheader.report');
    Route::get('notadebetheader/index', [NotaDebetHeaderController::class, 'index']);
    Route::resource('notadebetheader', NotaDebetHeaderController::class);

    Route::get('notadebetdetail/jurnal/grid', [NotaDebetDetailController::class, 'jurnalGrid']);
    Route::get('notadebetdetail/penerimaan/grid', [NotaDebetDetailController::class, 'penerimaanGrid']);
    Route::get('notadebetdetail/pelunasan/grid', [NotaDebetDetailController::class, 'pelunasanGrid']);
    Route::get('notadebetdetail/detail/grid', [NotaDebetDetailController::class, 'detailGrid']);
    Route::resource('notadebetdetail', NotaDebetDetailController::class);

    Route::get('gudang/field_length', [GudangController::class, 'fieldLength'])->name('gudang.field_length');
    Route::get('gudang/{id}/delete', [GudangController::class, 'delete'])->name('gudang.delete');
    Route::get('gudang/get', [GudangController::class, 'get'])->name('gudang.get');
    Route::get('gudang/index', [GudangController::class, 'index']);
    Route::get('gudang/report', [GudangController::class, 'report'])->name('gudang.report');
    Route::get('gudang/export', [GudangController::class, 'export'])->name('gudang.export');
    Route::resource('gudang', GudangController::class);

    Route::get('subkelompok/report', [SubKelompokController::class, 'report'])->name('subkelompok.report');
    Route::get('subkelompok/{id}/delete', [SubKelompokController::class, 'delete'])->name('subkelompok.delete');
    Route::get('subkelompok/get', [SubKelompokController::class, 'get'])->name('subkelompok.get');
    Route::get('subkelompok/index', [SubKelompokController::class, 'index']);
    Route::get('subkelompok/report', [SubKelompokController::class, 'report'])->name('subkelompok.report');
    Route::get('subkelompok/export', [SubKelompokController::class, 'export'])->name('subkelompok.export');
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
    Route::get('kategori/report', [KategoriController::class, 'report'])->name('kategori.report');
    Route::get('kategori/export', [KategoriController::class, 'export'])->name('kategori.export');
    Route::resource('kategori', KategoriController::class);

    Route::get('kelompok/field_length', [KelompokController::class, 'fieldLength'])->name('kelompok.field_length');
    Route::get('kelompok/{id}/delete', [KelompokController::class, 'delete'])->name('kelompok.delete');
    Route::get('kelompok/get', [KelompokController::class, 'get'])->name('kelompok.get');
    Route::get('kelompok/index', [KelompokController::class, 'index']);
    Route::get('kelompok/report', [KelompokController::class, 'report'])->name('kelompok.report');
    Route::get('kelompok/export', [KelompokController::class, 'export'])->name('kelompok.export');
    Route::resource('kelompok', KelompokController::class);

    Route::get('kerusakan/field_length', [KerusakanController::class, 'fieldLength'])->name('kerusakan.field_length');
    Route::get('kerusakan/{id}/delete', [KerusakanController::class, 'delete'])->name('kerusakan.delete');
    Route::get('kerusakan/get', [KerusakanController::class, 'get'])->name('kerusakan.get');
    Route::get('kerusakan/index', [KerusakanController::class, 'index']);
    Route::get('kerusakan/export', [KerusakanController::class, 'export'])->name('kerusakan.export');
    Route::get('kerusakan/report', [KerusakanController::class, 'report'])->name('kerusakan.report');
    Route::resource('kerusakan', KerusakanController::class);

    Route::get('penerima/report', [PenerimaController::class, 'report'])->name('penerima.report');
    Route::get('penerima/{id}/delete', [PenerimaController::class, 'delete'])->name('penerima.delete');
    Route::get('penerima/get', [PenerimaController::class, 'get'])->name('penerima.get');
    Route::get('penerima/index', [PenerimaController::class, 'index']);
    Route::resource('penerima', PenerimaController::class);

    Route::get('shipper/report', [ShipperController::class, 'report'])->name('shipper.report');
    Route::get('shipper/{id}/delete', [ShipperController::class, 'delete'])->name('shipper.delete');
    Route::get('shipper/get', [ShipperController::class, 'get'])->name('shipper.get');
    Route::get('shipper/index', [ShipperController::class, 'index']);
    Route::resource('shipper', ShipperController::class);

    Route::get('statuscontainer/report', [StatusContainerController::class, 'report'])->name('statuscontainer.report');
    Route::get('statuscontainer/{id}/delete', [StatusContainerController::class, 'delete'])->name('statuscontainer.delete');
    Route::get('statuscontainer/get', [StatusContainerController::class, 'get'])->name('statuscontainer.get');
    Route::get('statuscontainer/index', [StatusContainerController::class, 'index']);
    Route::resource('statuscontainer', StatusContainerController::class)->parameters(['statuscontainer' => 'statusContainer']);

    Route::get('kota/field_length', [KotaController::class, 'fieldLength'])->name('kota.field_length');
    Route::get('kota/{id}/delete', [KotaController::class, 'delete'])->name('kota.delete');
    Route::get('kota/get', [KotaController::class, 'get'])->name('kota.get');
    Route::get('kota/export', [KotaController::class, 'export'])->name('kota.export');
    Route::get('kota/report', [KotaController::class, 'report'])->name('kota.report');
    Route::get('kota/index', [KotaController::class, 'index']);
    Route::resource('kota', KotaController::class);

    Route::get('mandor/field_length', [MandorController::class, 'fieldLength'])->name('mandor.field_length');
    Route::get('mandor/{id}/delete', [MandorController::class, 'delete'])->name('mandor.delete');
    Route::get('mandor/get', [MandorController::class, 'get'])->name('mandor.get');
    Route::get('mandor/index', [MandorController::class, 'index']);
    Route::get('mandor/export', [MandorController::class, 'export'])->name('mandor.export');
    Route::get('mandor/report', [MandorController::class, 'report'])->name('mandor.report');
    Route::resource('mandor', MandorController::class);

    Route::get('merk/field_length', [MerkController::class, 'fieldLength'])->name('merk.field_length');
    Route::get('merk/{id}/delete', [MerkController::class, 'delete'])->name('merk.delete');
    Route::get('merk/get', [MerkController::class, 'get'])->name('merk.get');
    Route::get('merk/index', [MerkController::class, 'index']);
    Route::get('merk/report', [MerkController::class, 'report'])->name('merk.report');
    Route::get('merk/export', [MerkController::class, 'export'])->name('merk.export');
    Route::resource('merk', MerkController::class);

    Route::get('penerimaantrucking/report', [PenerimaanTruckingController::class, 'report'])->name('penerimaantrucking.report');
    Route::get('penerimaantrucking/{id}/delete', [PenerimaanTruckingController::class, 'delete'])->name('penerimaantrucking.delete');
    Route::get('penerimaantrucking/get', [PenerimaanTruckingController::class, 'get'])->name('penerimaantrucking.get');
    Route::get('penerimaantrucking/index', [PenerimaanTruckingController::class, 'index']);
    Route::get('penerimaantrucking/export', [PenerimaanTruckingController::class, 'export'])->name('penerimaantrucking.export');
    Route::get('penerimaantrucking/report', [PenerimaanTruckingController::class, 'report'])->name('penerimaantrucking.report');
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
    Route::get('pengeluarantrucking/export', [PengeluaranTruckingController::class, 'export'])->name('pengeluarantrucking.export');
    Route::get('pengeluarantrucking/report', [PengeluaranTruckingController::class, 'report'])->name('pengeluarantrucking.report');
    Route::resource('pengeluarantrucking', PengeluaranTruckingController::class);

    Route::get('satuan/field_length', [SatuanController::class, 'fieldLength'])->name('satuan.field_length');
    Route::get('satuan/{id}/delete', [SatuanController::class, 'delete'])->name('satuan.delete');
    Route::get('satuan/get', [SatuanController::class, 'get'])->name('satuan.get');
    Route::get('satuan/index', [SatuanController::class, 'index']);
    Route::get('satuan/report', [SatuanController::class, 'report'])->name('satuan.report');
    Route::get('satuan/export', [SatuanController::class, 'export'])->name('satuan.export');
    Route::resource('satuan', SatuanController::class);

    Route::get('zona/field_length', [ZonaController::class, 'fieldLength'])->name('zona.field_length');
    Route::get('zona/{id}/delete', [ZonaController::class, 'delete'])->name('zona.delete');
    Route::get('zona/get', [ZonaController::class, 'get'])->name('zona.get');
    Route::get('zona/index', [ZonaController::class, 'index']);
    Route::get('zona/export', [ZonaController::class, 'export'])->name('zona.export');
    Route::get('zona/report', [ZonaController::class, 'report'])->name('zona.report');
    Route::resource('zona', ZonaController::class);
    
    Route::get('tujuan/field_length', [TujuanController::class, 'fieldLength'])->name('tujuan.field_length');
    Route::get('tujuan/{id}/delete', [TujuanController::class, 'delete'])->name('tujuan.delete');
    Route::get('tujuan/get', [TujuanController::class, 'get'])->name('tujuan.get');
    Route::get('tujuan/index', [TujuanController::class, 'index']);
    Route::get('tujuan/export', [TujuanController::class, 'export'])->name('tujuan.export');
    Route::get('tujuan/report', [TujuanController::class, 'report'])->name('tujuan.report');
    Route::resource('tujuan', TujuanController::class);

    Route::get('tarif/field_length', [TarifController::class, 'fieldLength'])->name('tarif.field_length');
    Route::get('tarif/{id}/delete', [TarifController::class, 'delete'])->name('tarif.delete');
    Route::get('tarif/export', [TarifController::class, 'export'])->name('tarif.export');
    Route::get('tarif/report', [TarifController::class, 'report'])->name('tarif.report');
    Route::get('tarif/get', [TarifController::class, 'get'])->name('tarif.get');
    Route::get('tarif/index', [TarifController::class, 'index']);
    Route::resource('tarif', TarifController::class);

    Route::get('jobemkl/field_length', [JobEmklController::class, 'fieldLength'])->name('jobemkl.field_length');
    Route::get('jobemkl/{id}/delete', [JobEmklController::class, 'delete'])->name('jobemkl.delete');
    Route::get('jobemkl/get', [JobEmklController::class, 'get'])->name('jobemkl.get');
    Route::get('jobemkl/index', [JobEmklController::class, 'index']);
    Route::get('jobemkl/export', [JobEmklController::class, 'export'])->name('jobemkl.export');
    Route::get('jobemkl/report', [JobEmklController::class, 'report'])->name('jobemkl.report');
    Route::resource('jobemkl', JobEmklController::class);
    
    Route::get('marketing/field_length', [MarketingController::class, 'fieldLength'])->name('marketing.field_length');
    Route::get('marketing/{id}/delete', [MarketingController::class, 'delete'])->name('marketing.delete');
    Route::get('marketing/get', [MarketingController::class, 'get'])->name('marketing.get');
    Route::get('marketing/index', [MarketingController::class, 'index']);
    Route::get('marketing/export', [MarketingController::class, 'export'])->name('marketing.export');
    Route::get('marketing/report', [MarketingController::class, 'report'])->name('marketing.report');
    Route::resource('marketing', MarketingController::class);

    Route::get('orderantrucking/field_length', [OrderanTruckingController::class, 'fieldLength'])->name('orderantrucking.field_length');
    Route::get('orderantrucking/{id}/delete', [OrderanTruckingController::class, 'delete'])->name('orderantrucking.delete');
    Route::get('orderantrucking/get', [OrderanTruckingController::class, 'get'])->name('orderantrucking.get');
    Route::get('orderantrucking/index', [OrderanTruckingController::class, 'index']);
    Route::get('orderantrucking/export', [OrderanTruckingController::class, 'export'])->name('orderantrucking.export');
    Route::get('orderantrucking/report', [OrderanTruckingController::class, 'report'])->name('orderantrucking.report');
    Route::resource('orderantrucking', OrderanTruckingController::class);

    Route::get('chargegandengan/export', [ChargeGandenganController::class, 'export'])->name('chargegandengan.export');
    Route::get('chargegandengan/report', [ChargeGandenganController::class, 'report'])->name('chargegandengan.report');
    Route::get('chargegandengan/index', [ChargeGandenganController::class, 'index']);
    Route::resource('chargegandengan', ChargeGandenganController::class);

    Route::get('reminderservice/index', [ReminderServiceController::class, 'index'])->name('reminderservice.export');
    Route::get('reminderservice/index', [ReminderServiceController::class, 'index'])->name('reminderservice.report');
    Route::get('reminderservice/index', [ReminderServiceController::class, 'index'])->name('reminderservice.index');
    Route::get('reminderservice', [ReminderServiceController::class, 'index'])->name('reminderservice.get');

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
    Route::get('suratpengantar/report', [SuratPengantarController::class, 'report'])->name('suratpengantar.report');
    Route::get('suratpengantar/export', [SuratPengantarController::class, 'export'])->name('suratpengantar.export');
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
    Route::get('ritasi/export', [RitasiController::class, 'export'])->name('ritasi.export');
    Route::get('ritasi/report', [RitasiController::class, 'report'])->name('ritasi.report');
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

    Route::get('penerimaandetail/jurnal/grid', [PenerimaanDetailController::class, 'jurnalGrid']);
    Route::get('penerimaandetail/detail/grid', [PenerimaanDetailController::class, 'detailGrid']);
    Route::resource('penerimaandetail', PenerimaanDetailController::class);

    //pengeluaran
    Route::get('pengeluaranheader/{id}/delete', [PengeluaranHeaderController::class, 'delete'])->name('pengeluaranheader.delete');
    Route::get('pengeluaranheader/index', [PengeluaranHeaderController::class, 'index']);
    Route::get('pengeluaranheader/get', [PengeluaranHeaderController::class, 'get'])->name('pengeluaranheader.get');
    Route::get('pengeluaranheader/export', [PengeluaranHeaderController::class, 'export'])->name('pengeluaranheader.export');
    Route::get('pengeluaranheader/report', [PengeluaranHeaderController::class, 'report'])->name('pengeluaranheader.report');
    Route::resource('pengeluaranheader', PengeluaranHeaderController::class);

    Route::get('pengeluarandetail/jurnal/grid', [PengeluaranDetailController::class, 'jurnalGrid']);
    Route::get('pengeluarandetail/detail/grid', [PengeluaranDetailController::class, 'detailGrid']);
    Route::resource('pengeluarandetail', PengeluaranDetailController::class);

    Route::get('rekappengeluaranheader/{id}/delete', [RekapPengeluaranHeaderController::class, 'delete'])->name('rekappengeluaranheader.delete');
    Route::get('rekappengeluaranheader/index', [RekapPengeluaranHeaderController::class, 'index']);
    Route::get('rekappengeluaranheader/get', [RekapPengeluaranHeaderController::class, 'get'])->name('rekappengeluaranheader.get');
    Route::get('rekappengeluaranheader/export', [RekapPengeluaranHeaderController::class, 'export'])->name('rekappengeluaranheader.export');
    Route::get('rekappengeluaranheader/report/{id}', [RekapPengeluaranHeaderController::class, 'report'])->name('rekappengeluaranheader.report');
    Route::resource('rekappengeluaranheader', RekapPengeluaranHeaderController::class);

    // Route::resource('rekappengeluarandetail', RekapPengeluaranDetailController::class);

    Route::get('rekappenerimaanheader/{id}/delete', [RekapPenerimaanHeaderController::class, 'delete'])->name('rekappenerimaanheader.delete');
    Route::get('rekappenerimaanheader/index', [RekapPenerimaanHeaderController::class, 'index']);
    Route::get('rekappenerimaanheader/get', [RekapPenerimaanHeaderController::class, 'get'])->name('rekappenerimaanheader.get');
    Route::get('rekappenerimaanheader/export', [RekapPenerimaanHeaderController::class, 'export'])->name('rekappenerimaanheader.export');
    Route::get('rekappenerimaanheader/report', [RekapPenerimaanHeaderController::class, 'report'])->name('rekappenerimaanheader.report');
    Route::resource('rekappenerimaanheader', RekapPenerimaanHeaderController::class);

    // Route::resource('rekappenerimaandetail', RekapPenerimaanDetailController::class);

    //penerimaan trucking
    Route::get('penerimaantruckingheader/{id}/delete', [PenerimaanTruckingHeaderController::class, 'delete'])->name('penerimaantruckingheader.delete');
    Route::get('penerimaantruckingheader/index', [PenerimaanTruckingHeaderController::class, 'index']);
    Route::get('penerimaantruckingheader/get', [PenerimaanTruckingHeaderController::class, 'get'])->name('penerimaantruckingheader.get');
    Route::get('penerimaantruckingheader/export', [PenerimaanTruckingHeaderController::class, 'export'])->name('penerimaantruckingheader.export');
    Route::get('penerimaantruckingheader/report', [PenerimaanTruckingHeaderController::class, 'report'])->name('penerimaantruckingheader.report');
    Route::resource('penerimaantruckingheader', PenerimaanTruckingHeaderController::class);

    Route::get('penerimaantruckingdetail/jurnal/grid', [PenerimaanTruckingDetailController::class, 'jurnalGrid']);
    Route::get('penerimaantruckingdetail/penerimaan/grid', [PenerimaanTruckingDetailController::class, 'penerimaanGrid']);
    Route::get('penerimaantruckingdetail/detail/grid', [PenerimaanTruckingDetailController::class, 'detailGrid']);
    Route::resource('penerimaantruckingdetail', PenerimaanTruckingDetailController::class);

    Route::get('penerimaanstokheader/get', [PenerimaanStokHeaderController::class, 'get'])->name('penerimaanstokheader.get');
    Route::get('penerimaanstokheader/export', [PenerimaanStokHeaderController::class, 'export'])->name('penerimaanstokheader.export');
    Route::get('penerimaanstokheader/report', [PenerimaanStokHeaderController::class, 'report'])->name('penerimaanstokheader.report');
    Route::get('penerimaanstokheader/index', [PenerimaanStokHeaderController::class, 'index']);
    Route::resource('penerimaanstokheader', PenerimaanStokHeaderController::class);

    Route::get('penerimaanstokdetail/jurnal/grid', [PenerimaanStokDetailController::class, 'jurnalGrid']);
    Route::get('penerimaanstokdetail/hutang/grid', [PenerimaanStokDetailController::class, 'hutangGrid']);
    Route::get('penerimaanstokdetail/detail/grid', [PenerimaanStokDetailController::class, 'detailGrid']);
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

    Route::get('pengeluarantruckingdetail/jurnal/grid', [PengeluaranTruckingDetailController::class, 'jurnalGrid']);
    Route::get('pengeluarantruckingdetail/pengeluaran/grid', [PengeluaranTruckingDetailController::class, 'pengeluaranGrid']);
    Route::get('pengeluarantruckingdetail/detail/grid', [PengeluaranTruckingDetailController::class, 'detailGrid']);
    Route::resource('pengeluarantruckingdetail', PengeluaranTruckingDetailController::class);

    Route::get('hutangheader/index', [HutangHeaderController::class, 'index']);
    Route::get('hutangheader/{id}/delete', [HutangHeaderController::class, 'delete'])->name('hutangheader.delete');
    Route::get('hutangheader/get', [HutangHeaderController::class, 'get'])->name('hutangheader.get');
    Route::get('hutangheader/export', [HutangHeaderController::class, 'export'])->name('hutangheader.export');
    Route::get('hutangheader/report', [HutangHeaderController::class, 'report'])->name('hutangheader.report');
    Route::resource('hutangheader', HutangHeaderController::class);

    Route::get('hutangdetail/jurnal/grid', [HutangDetailController::class, 'jurnalGrid']);
    Route::get('hutangdetail/history/grid', [HutangDetailController::class, 'historyGrid']);
    Route::get('hutangdetail/detail/grid', [HutangDetailController::class, 'detailGrid']);
    Route::resource('hutangdetail', HutangDetailController::class);

    Route::get('tutupbuku/index', [TutupBukuController::class, 'index']);
    Route::resource('tutupbuku', TutupBukuController::class);

    Route::get('approvalopname/index', [ApprovalOpnameController::class, 'index']);
    Route::resource('approvalopname', ApprovalOpnameController::class);

    Route::get('piutangheader/index', [PiutangHeaderController::class, 'index']);
    Route::get('piutangheader/{id}/delete', [PiutangHeaderController::class, 'delete'])->name('piutangheader.delete');
    Route::get('piutangheader/get', [PiutangHeaderController::class, 'get'])->name('piutangheader.get');
    Route::get('piutangheader/export', [PiutangHeaderController::class, 'export'])->name('piutangheader.export');
    Route::get('piutangheader/report', [PiutangHeaderController::class, 'report'])->name('piutangheader.report');
    Route::resource('piutangheader', PiutangHeaderController::class);

    Route::get('piutangdetail/jurnal/grid', [PiutangDetailController::class, 'jurnalGrid']);
    Route::get('piutangdetail/history/grid', [PiutangDetailController::class, 'historyGrid']);
    Route::get('piutangdetail/detail/grid', [PiutangDetailController::class, 'detailGrid']);
    Route::resource('piutangdetail', PiutangDetailController::class);

    Route::get('pelunasanpiutangheader/index', [PelunasanPiutangHeaderController::class, 'index']);
    Route::get('pelunasanpiutangheader/{id}/delete', [PelunasanPiutangHeaderController::class, 'delete'])->name('pelunasanpiutangheader.delete');
    Route::get('pelunasanpiutangheader/{id}/getpiutang', [PelunasanPiutangHeaderController::class, 'getpiutang'])->name('pelunasanpiutangheader.getpiutang');
    Route::get('pelunasanpiutangheader/get', [PelunasanPiutangHeaderController::class, 'get'])->name('pelunasanpiutangheader.get');
    Route::get('pelunasanpiutangheader/export', [PelunasanPiutangHeaderController::class, 'export'])->name('pelunasanpiutangheader.export');
    Route::get('pelunasanpiutangheader/report', [PelunasanPiutangHeaderController::class, 'report'])->name('pelunasanpiutangheader.report');
    Route::resource('pelunasanpiutangheader', PelunasanPiutangHeaderController::class);

    Route::get('pelunasanpiutangdetail/jurnal/grid', [PelunasanPiutangDetailController::class, 'jurnalGrid']);
    Route::get('pelunasanpiutangdetail/penerimaan/grid', [PelunasanPiutangDetailController::class, 'penerimaanGrid']);
    Route::get('pelunasanpiutangdetail/detail/grid', [PelunasanPiutangDetailController::class, 'detailGrid']);
    Route::resource('pelunasanpiutangdetail', PelunasanPiutangDetailController::class);

    Route::get('hutangbayarheader/index', [HutangBayarHeaderController::class, 'index']);
    Route::get('hutangbayarheader/{id}/delete', [HutangBayarHeaderController::class, 'delete'])->name('hutangbayarheader.delete');
    Route::get('hutangbayarheader/get', [HutangBayarHeaderController::class, 'get'])->name('hutangbayarheader.get');
    Route::get('hutangbayarheader/export', [HutangBayarHeaderController::class, 'export'])->name('hutangbayarheader.export');
    Route::get('hutangbayarheader/report', [HutangBayarHeaderController::class, 'report'])->name('hutangbayarheader.report');
    Route::resource('hutangbayarheader', HutangBayarHeaderController::class);

    Route::get('hutangbayardetail/jurnal/grid', [HutangBayarDetailController::class, 'jurnalGrid']);
    Route::get('hutangbayardetail/pengeluaran/grid', [HutangBayarDetailController::class, 'pengeluaranGrid']);
    Route::get('hutangbayardetail/detail/grid', [HutangBayarDetailController::class, 'detailGrid']);
    Route::resource('hutangbayardetail', HutangBayarDetailController::class);


    Route::get('gajisupirheader/index', [GajiSupirHeaderController::class, 'index']);
    Route::get('gajisupirheader/{id}/delete', [GajiSupirHeaderController::class, 'delete'])->name('gajisupirheader.delete');
    Route::get('gajisupirheader/get', [GajiSupirHeaderController::class, 'get'])->name('gajisupirheader.get');
    Route::get('gajisupirheader/export', [GajiSupirHeaderController::class, 'export'])->name('gajisupirheader.export');
    Route::get('gajisupirheader/report', [GajiSupirHeaderController::class, 'report'])->name('gajisupirheader.report');
    Route::resource('gajisupirheader', GajiSupirHeaderController::class);

    Route::get('gajisupirdetail/jurnal/grid', [GajiSupirDetailController::class, 'jurnalGrid']);
    Route::get('gajisupirdetail/absensi/grid', [GajiSupirDetailController::class, 'absensiGrid']);
    Route::get('gajisupirdetail/potsemua/grid', [GajiSupirDetailController::class, 'potsemuaGrid']);
    Route::get('gajisupirdetail/potpribadi/grid', [GajiSupirDetailController::class, 'potpribadiGrid']);
    Route::get('gajisupirdetail/deposito/grid', [GajiSupirDetailController::class, 'depositoGrid']);
    Route::get('gajisupirdetail/detail/grid', [GajiSupirDetailController::class, 'detailGrid']);
    Route::resource('gajisupirdetail', GajiSupirDetailController::class);

    Route::get('prosesgajisupirheader/index', [ProsesGajiSupirHeaderController::class, 'index']);
    Route::get('prosesgajisupirheader/{id}/delete', [ProsesGajiSupirHeaderController::class, 'delete'])->name('prosesgajisupirheader.delete');
    Route::get('prosesgajisupirheader/get', [ProsesGajiSupirHeaderController::class, 'get'])->name('prosesgajisupirheader.get');
    Route::get('prosesgajisupirheader/export', [ProsesGajiSupirHeaderController::class, 'export'])->name('prosesgajisupirheader.export');
    Route::get('prosesgajisupirheader/report', [ProsesGajiSupirHeaderController::class, 'report'])->name('prosesgajisupirheader.report');
    Route::resource('prosesgajisupirheader', ProsesGajiSupirHeaderController::class);

    Route::get('prosesgajisupirdetail/jurnal/grid', [ProsesGajiSupirDetailController::class, 'jurnalGrid']);
    Route::get('prosesgajisupirdetail/potsemua/grid', [ProsesGajiSupirDetailController::class, 'potsemuaGrid']);
    Route::get('prosesgajisupirdetail/potpribadi/grid', [ProsesGajiSupirDetailController::class, 'potpribadiGrid']);
    Route::get('prosesgajisupirdetail/deposito/grid', [ProsesGajiSupirDetailController::class, 'depositoGrid']);
    Route::get('prosesgajisupirdetail/pengeluaran/grid', [ProsesGajiSupirDetailController::class, 'pengeluaranGrid']);
    Route::get('prosesgajisupirdetail/detail/grid', [ProsesGajiSupirDetailController::class, 'detailGrid']);
    Route::resource('prosesgajisupirdetail', ProsesGajiSupirDetailController::class);


    Route::get('invoiceheader/index', [InvoiceHeaderController::class, 'index']);
    Route::get('invoiceheader/{id}/delete', [InvoiceHeaderController::class, 'delete'])->name('invoiceheader.delete');
    Route::get('invoiceheader/get', [InvoiceHeaderController::class, 'get'])->name('invoiceheader.get');
    Route::get('invoiceheader/export', [InvoiceHeaderController::class, 'export'])->name('invoiceheader.export');
    Route::get('invoiceheader/report', [InvoiceHeaderController::class, 'report'])->name('invoiceheader.report');
    Route::resource('invoiceheader', InvoiceHeaderController::class);
    Route::get('invoicedetail/jurnal/grid', [InvoiceDetailController::class, 'jurnalGrid']);
    Route::get('invoicedetail/piutang/grid', [InvoiceDetailController::class, 'piutangGrid']);
    Route::get('invoicedetail/detail/grid', [InvoiceDetailController::class, 'detailGrid']);
    Route::resource('invoicedetail', InvoiceDetailController::class);

    Route::get('invoiceextraheader/index', [InvoiceExtraHeaderController::class, 'index']);
    Route::get('invoiceextraheader/get', [InvoiceExtraHeaderController::class, 'get'])->name('invoiceextraheader.get');
    Route::get('invoiceextraheader/export', [InvoiceExtraHeaderController::class, 'export'])->name('invoiceextraheader.export');
    Route::get('invoiceextraheader/report', [InvoiceExtraHeaderController::class, 'report'])->name('invoiceextraheader.report');
    Route::resource('invoiceextraheader', InvoiceExtraHeaderController::class);
    Route::get('invoiceextradetail/jurnal/grid', [InvoiceExtraDetailController::class, 'jurnalGrid']);
    Route::get('invoiceextradetail/piutang/grid', [InvoiceExtraDetailController::class, 'piutangGrid']);
    Route::get('invoiceextradetail/detail/grid', [InvoiceExtraDetailController::class, 'detailGrid']);
    Route::resource('invoiceextradetail', InvoiceExtraDetailController::class);

    Route::get('invoicechargegandenganheader/index', [InvoiceChargeGandenganHeaderController::class, 'index']);
    Route::get('invoicechargegandenganheader/export', [InvoiceChargeGandenganHeaderController::class, 'export'])->name('invoicechargegandenganheader.export');
    Route::get('invoicechargegandenganheader/report', [InvoiceChargeGandenganHeaderController::class, 'report'])->name('invoicechargegandenganheader.report');
    Route::resource('invoicechargegandenganheader', InvoiceChargeGandenganHeaderController::class);


    Route::get('approvaltransaksiheader/index', [ApprovalTransaksiHeaderController::class, 'index']);
    Route::resource('approvaltransaksiheader', ApprovalTransaksiHeaderController::class);

    Route::get('approvalinvoiceheader/index', [ApprovalInvoiceHeaderController::class, 'index']);
    Route::resource('approvalinvoiceheader', ApprovalInvoiceHeaderController::class);

    Route::get('approvalbukacetak/index', [ApprovalBukaCetakController::class, 'index']);
    Route::resource('approvalbukacetak', ApprovalBukaCetakController::class);

    // Route::get('approvalkirimberkas/index', [ApprovalKirimBerkasController::class, 'index']);
    // Route::resource('approvalkirimberkas', ApprovalKirimBerkasController::class);

    Route::get('penerimaangiroheader/index', [PenerimaanGiroHeaderController::class, 'index']);
    Route::get('penerimaangiroheader/{id}/delete', [PenerimaanGiroHeaderController::class, 'delete'])->name('penerimaangiroheader.delete');
    Route::get('penerimaangiroheader/get', [PenerimaanGiroHeaderController::class, 'get'])->name('penerimaangiroheader.get');
    Route::get('penerimaangiroheader/export', [PenerimaanGiroHeaderController::class, 'export'])->name('penerimaangiroheader.export');
    Route::get('penerimaangiroheader/report', [PenerimaanGiroHeaderController::class, 'report'])->name('penerimaangiroheader.report');
    Route::resource('penerimaangiroheader', PenerimaanGiroHeaderController::class);
    Route::get('penerimaangirodetail/jurnal/grid', [PenerimaanGiroDetailController::class, 'jurnalGrid']);
    Route::get('penerimaangirodetail/detail/grid', [PenerimaanGiroDetailController::class, 'detailGrid']);
    Route::resource('penerimaangirodetail', PenerimaanGiroDetailController::class);

    Route::get('jurnalumumpusatheader/index', [JurnalUmumPusatHeaderController::class, 'index']);
    Route::get('jurnalumumpusatheader/get', [JurnalUmumPusatHeaderController::class, 'get'])->name('jurnalumumpusatheader.get');
    Route::get('jurnalumumpusatheader/export', [JurnalUmumPusatHeaderController::class, 'export'])->name('jurnalumumpusatheader.export');
    Route::get('jurnalumumpusatheader/report', [JurnalUmumPusatHeaderController::class, 'report'])->name('jurnalumumpusatheader.report');
    Route::resource('jurnalumumpusatheader', JurnalUmumPusatHeaderController::class);
    Route::resource('jurnalumumpusatdetail', JurnalUmumPusatDetailController::class);

    Route::get('harilibur/get', [HariLiburController::class, 'get'])->name('harilibur.get');
    Route::get('harilibur/export', [HariLiburController::class, 'export'])->name('harilibur.export');
    Route::get('harilibur/report', [HariLiburController::class, 'report'])->name('harilibur.report');
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
    Route::get('pencairangiropengeluarandetail/jurnal/grid', [PencairanGiroPengeluaranDetailController::class, 'jurnalGrid']);
    Route::get('pencairangiropengeluarandetail/detail/grid', [PencairanGiroPengeluaranDetailController::class, 'detailGrid']);
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

    Route::get('stokpersediaan/export', [StokPersediaanController::class, 'export'])->name('stokpersediaan.export');
    Route::get('stokpersediaan/report', [StokPersediaanController::class, 'report'])->name('stokpersediaan.report');
    Route::get('stokpersediaan/index', [StokPersediaanController::class, 'index']);
    Route::resource('stokpersediaan', StokPersediaanController::class);

    Route::get('kartustok/export', [KartuStokController::class, 'export'])->name('kartustok.export');
    Route::get('kartustok/report', [KartuStokController::class, 'report'])->name('kartustok.report');
    Route::get('kartustok/index', [KartuStokController::class, 'index']);
    Route::resource('kartustok', KartuStokController::class);

    Route::get('kartustoklama/export', [KartuStokLamaController::class, 'export'])->name('kartustoklama.export');
    Route::get('kartustoklama/report', [KartuStokLamaController::class, 'report'])->name('kartustoklama.report');
    Route::get('kartustoklama/index', [KartuStokLamaController::class, 'index']);
    Route::resource('kartustoklama', KartuStokLamaController::class);    

    Route::get('historipenerimaanstok/export', [HistoriPenerimaanStokController::class, 'export'])->name('historipenerimaanstok.export');
    Route::get('historipenerimaanstok/report', [HistoriPenerimaanStokController::class, 'report'])->name('historipenerimaanstok.report');
    Route::get('historipenerimaanstok/index', [HistoriPenerimaanStokController::class, 'index']);
    Route::resource('historipenerimaanstok', HistoriPenerimaanStokController::class);

    Route::get('historipengeluaranstok/export', [HistoriPengeluaranStokController::class, 'export'])->name('historipengeluaranstok.export');
    Route::get('historipengeluaranstok/report', [HistoriPengeluaranStokController::class, 'report'])->name('historipengeluaranstok.report');
    Route::get('historipengeluaranstok/index', [HistoriPengeluaranStokController::class, 'index']);
    Route::resource('historipengeluaranstok', HistoriPengeluaranStokController::class);

    Route::get('laporankasbank/report', [LaporanKasBankController::class, 'report'])->name('laporankasbank.report');
    Route::get('laporankasbank/export', [LaporanKasBankController::class, 'export'])->name('laporankasbank.export');
    Route::get('laporankasbank/index', [LaporanKasBankController::class, 'index']);
    Route::resource('laporankasbank', LaporanKasBankController::class);

    Route::get('laporanbukubesar/export', [LaporanBukuBesarController::class, 'export'])->name('laporanbukubesar.export');
    Route::get('laporanbukubesar/report', [LaporanBukuBesarController::class, 'report'])->name('laporanbukubesar.report');
    Route::get('laporanbukubesar/index', [LaporanBukuBesarController::class, 'index']);
    Route::resource('laporanbukubesar', LaporanBukuBesarController::class);

    Route::get('laporandatajurnal/report', [LaporanDataJurnalController::class, 'report'])->name('laporandatajurnal.report');
    Route::get('laporandatajurnal/export', [LaporanDataJurnalController::class, 'export'])->name('laporandatajurnal.export');
    Route::get('laporandatajurnal/index', [LaporanDataJurnalController::class, 'index'])->name('laporandatajurnal.index');
    Route::get('laporandatajurnal', [LaporanDataJurnalController::class, 'index']);
    
    Route::get('tarikdataabsensi/export', [TarikDataAbsensiController::class, 'export'])->name('tarikdataabsensi.export');
    Route::get('tarikdataabsensi/index', [TarikDataAbsensiController::class, 'index'])->name('tarikdataabsensi.index');
    Route::get('tarikdataabsensi', [TarikDataAbsensiController::class, 'index']);


    Route::get('prosesuangjalansupirheader/index', [ProsesUangJalanSupirHeaderController::class, 'index']);
    Route::get('prosesuangjalansupirheader/get', [ProsesUangJalanSupirHeaderController::class, 'get'])->name('prosesuangjalansupirheader.get');
    Route::get('prosesuangjalansupirheader/export', [ProsesUangJalanSupirHeaderController::class, 'export'])->name('prosesuangjalansupirheader.export');
    Route::get('prosesuangjalansupirheader/report', [ProsesUangJalanSupirHeaderController::class, 'report'])->name('prosesuangjalansupirheader.report');
    Route::resource('prosesuangjalansupirheader', ProsesUangJalanSupirHeaderController::class);

    Route::get('prosesuangjalansupirdetail/transfer/grid', [ProsesUangJalanSupirDetailController::class, 'transferGrid']);
    Route::get('prosesuangjalansupirdetail/detail/grid', [ProsesUangJalanSupirDetailController::class, 'detailGrid']);
    Route::resource('prosesuangjalansupirdetail', ProsesUangJalanSupirDetailController::class);

    Route::get('laporandepositosupir/report', [LaporanDepositoSupirController::class, 'report'])->name('laporandepositosupir.report');
    Route::get('laporandepositosupir/export', [LaporanDepositoSupirController::class, 'export'])->name('laporandepositosupir.export');
    Route::get('laporandepositosupir/index', [LaporanDepositoSupirController::class, 'index']);
    Route::resource('laporandepositosupir', LaporanDepositoSupirController::class);

    Route::get('laporandepositokaryawan/report', [LaporanDepositoKaryawanController::class, 'report'])->name('laporandepositokaryawan.report');
    Route::get('laporandepositokaryawan/export', [LaporanDepositoKaryawanController::class, 'export'])->name('laporandepositokaryawan.export');
    Route::get('laporandepositokaryawan/index', [LaporanDepositoKaryawanController::class, 'index']);
    Route::resource('laporandepositokaryawan', LaporanDepositoKaryawanController::class);

    Route::get('laporanlabarugi/report', [LaporanLabaRugiController::class, 'report'])->name('laporanlabarugi.report');
    Route::get('laporanlabarugi/export', [LaporanLabaRugiController::class, 'export'])->name('laporanlabarugi.export');
    Route::get('laporanlabarugi/index', [LaporanLabaRugiController::class, 'index']);
    Route::resource('laporanlabarugi', LaporanLabaRugiController::class);

    Route::get('laporanpemakaianstok/report', [LaporanPemakaianStokController::class, 'report'])->name('laporanpemakaianstok.report');
    Route::get('laporanpemakaianstok/export', [LaporanPemakaianStokController::class, 'export'])->name('laporanpemakaianstok.export');
    Route::get('laporanpemakaianstok/index', [LaporanPemakaianStokController::class, 'index']);
    Route::resource('laporanpemakaianstok', LaporanPemakaianStokController::class);

    Route::get('laporanpembelianbarang/report', [LaporanPembelianBarangController::class, 'report'])->name('laporanpembelianbarang.report');
    Route::get('laporanpembelianbarang/export', [LaporanPembelianBarangController::class, 'export'])->name('laporanpembelianbarang.export');
    Route::get('laporanpembelianbarang/index', [LaporanPembelianBarangController::class, 'index']);
    Route::resource('laporanlapembelianbarang', LaporanPembelianBarangController::class);

    Route::get('laporanstok/report', [LaporanStokController::class, 'report'])->name('laporanstok.report');
    Route::get('laporanstok/export', [LaporanStokController::class, 'export'])->name('laporanstok.export');
    Route::get('laporanstok/index', [LaporanStokController::class, 'index']);
    Route::resource('laporanstok', LaporanStokController::class);


    Route::get('laporanhistorydeposito/report', [LaporanHistoryDepositoController::class, 'report'])->name('laporanhistorydeposito.report');
    Route::get('laporanhistorydeposito/export', [LaporanHistoryDepositoController::class, 'export'])->name('laporanhistorydeposito.export');
    Route::get('laporanhistorydeposito/index', [LaporanHistoryDepositoController::class, 'index']);
    Route::resource('laporanhistorydeposito', LaporanHistoryDepositoController::class);

    Route::get('laporantransaksiharian/report', [LaporanTransaksiHarianController::class, 'report'])->name('laporantransaksiharian.report');
    Route::get('laporantransaksiharian/export', [LaporanTransaksiHarianController::class, 'export'])->name('laporantransaksiharian.export');
    Route::get('laporantransaksiharian/index', [LaporanTransaksiHarianController::class, 'index']);
    Route::resource('laporantransaksiharian', LaporanTransaksiHarianController::class);

    Route::get('laporanpinjamansupir/export', [LaporanPinjamanSupirController::class, 'export'])->name('laporanpinjamansupir.export');
    Route::get('laporanpinjamansupir/report', [LaporanPinjamanSupirController::class, 'report'])->name('laporanpinjamansupir.report');
    Route::get('laporanpinjamansupir/index', [LaporanPinjamanSupirController::class, 'index']);
    Route::resource('laporanpinjamansupir', LaporanPinjamanSupirController::class);

    Route::get('laporanketeranganpinjamansupir/report', [LaporanKeteranganPinjamanSupirController::class, 'report'])->name('laporanketeranganpinjamansupir.report');
    Route::get('laporanketeranganpinjamansupir/export', [LaporanKeteranganPinjamanSupirController::class, 'export'])->name('laporanketeranganpinjamansupir.export');
    Route::get('laporanketeranganpinjamansupir/index', [LaporanKeteranganPinjamanSupirController::class, 'index']);
    Route::resource('laporanketeranganpinjamansupir', LaporanKeteranganPinjamanSupirController::class);

    Route::get('laporanpinjamanbandingperiode/report', [LaporanPinjamanBandingPeriodeController::class, 'report'])->name('laporanpinjamanbandingperiode.report');
    Route::get('laporanpinjamanbandingperiode/export', [LaporanPinjamanBandingPeriodeController::class, 'export'])->name('laporanpinjamanbandingperiode.export');
    Route::get('laporanpinjamanbandingperiode/index', [LaporanPinjamanBandingPeriodeController::class, 'index']);
    Route::resource('laporanpinjamanbandingperiode', LaporanPinjamanBandingPeriodeController::class);

    Route::get('laporankalkulasiemkl/export', [LaporanKalkulasiEmklController::class, 'export'])->name('laporankalkulasiemkl.export');
    Route::get('laporankalkulasiemkl/index', [LaporanKalkulasiEmklController::class, 'index']);
    Route::resource('laporankalkulasiemkl', LaporanKalkulasiEmklController::class);

    Route::get('laporankasharian/report', [LaporanKasHarianController::class, 'report'])->name('laporankasharian.report');
    Route::get('laporankasharian/export', [LaporanKasHarianController::class, 'export'])->name('laporankasharian.export');
    Route::get('laporankasharian/index', [LaporanKasHarianController::class, 'index']);
    Route::resource('laporankasharian', LaporanKasHarianController::class);


    Route::get('lapkartuhutangpervendordetail/report', [LapKartuHutangPerVendorDetailController::class, 'report'])->name('lapkartuhutangpervendordetail.report');
    Route::get('lapkartuhutangpervendordetail/index', [LapKartuHutangPerVendorDetailController::class, 'index']);
    Route::resource('lapkartuhutangpervendordetail', LapKartuHutangPerVendorDetailController::class);

    Route::get('laporanwarkatbelumcair/report', [LaporanWarkatBelumCairController::class, 'report'])->name('laporanwarkatbelumcair.report');
    Route::get('laporanwarkatbelumcair/index', [LaporanWarkatBelumCairController::class, 'index']);
    Route::resource('laporanwarkatbelumcair', LaporanWarkatBelumCairController::class);

    Route::get('laporanpemakaianban/report', [LaporanPemakaianBanController::class, 'report'])->name('laporanpemakaianban.report');
    Route::get('laporanpemakaianban/export', [LaporanPemakaianBanController::class, 'export'])->name('laporanpemakaianban.export');
    Route::get('laporanpemakaianban/index', [LaporanPemakaianBanController::class, 'index']);
    Route::resource('laporanpemakaianban', LaporanPemakaianBanController::class);

    Route::get('laporanpenyesuaianbarang/report', [LaporanPenyesuaianBarangController::class, 'report'])->name('laporanpenyesuaianbarang.report');
    Route::get('laporanpenyesuaianbarang/export', [LaporanPenyesuaianBarangController::class, 'export'])->name('laporanpenyesuaianbarang.export');
    Route::get('laporanpenyesuaianbarang/index', [LaporanPenyesuaianBarangController::class, 'index']);
    Route::resource('laporanpenyesuaianbarang', LaporanPenyesuaianBarangController::class);

    Route::get('laporanhutangbbm/export', [LaporanHutangBBMController::class, 'export'])->name('laporanhutangbbm.export');
    Route::get('laporanhutangbbm/report', [LaporanHutangBBMController::class, 'report'])->name('laporanhutangbbm.report');
    Route::get('laporanhutangbbm/index', [LaporanHutangBBMController::class, 'index']);
    Route::resource('laporanhutangbbm', LaporanHutangBBMController::class);

    Route::get('laporantriptrado/report', [LaporanTripTradoController::class, 'report'])->name('laporantriptrado.report');
    Route::get('laporantriptrado/export', [LaporanTripTradoController::class, 'export'])->name('laporantriptrado.export');
    Route::get('laporantriptrado/index', [LaporanTripTradoController::class, 'index']);
    Route::resource('laporantriptrado', LaporanTripTradoController::class);

    Route::get('laporankartuhutangprediksi/export', [LaporanKartuHutangPrediksiController::class, 'export'])->name('laporankartuhutangprediksi.export');
    Route::get('laporankartuhutangprediksi/report', [LaporanKartuHutangPrediksiController::class, 'report'])->name('laporankartuhutangprediksi.report');
    Route::get('laporankartuhutangprediksi/index', [LaporanKartuHutangPrediksiController::class, 'index']);
    Route::resource('laporankartuhutangprediksi', LaporanKartuHutangPrediksiController::class);

    Route::get('laporantripgandengandetail/report', [LaporanTripGandenganDetailController::class, 'report'])->name('laporantripgandengandetail.report');
    Route::get('laporantripgandengandetail/export', [LaporanTripGandenganDetailController::class, 'export'])->name('laporantripgandengandetail.export');
    Route::get('laporantripgandengandetail/index', [LaporanTripGandenganDetailController::class, 'index']);
    Route::resource('laporantripgandengandetail', LaporanTripGandenganDetailController::class);

    Route::get('laporanuangjalan/report', [LaporanUangJalanController::class, 'report'])->name('laporanuangjalan.report');
    Route::get('laporanuangjalan/export', [LaporanUangJalanController::class, 'export'])->name('laporanuangjalan.export');
    Route::get('laporanuangjalan/index', [LaporanUangJalanController::class, 'index']);
    Route::resource('laporanuangjalan', LaporanUangJalanController::class);

    Route::get('laporanjurnalumum/report', [LaporanJurnalUmumController::class, 'report'])->name('laporanjurnalumum.report');
    Route::get('laporanjurnalumum/export', [LaporanJurnalUmumController::class, 'export'])->name('laporanjurnalumum.export');
    Route::get('laporanjurnalumum/index', [LaporanJurnalUmumController::class, 'index']);
    Route::resource('laporanjurnalumum', LaporanJurnalUmumController::class);


    Route::get('laporanpembelian/report', [LaporanPembelianController::class, 'report'])->name('laporanpembelian.report');
    Route::get('laporanpembelian/export', [LaporanPembelianController::class, 'export'])->name('laporanpembelian.export');
    Route::get('laporanpembelian/index', [LaporanPembelianController::class, 'index']);
    Route::resource('laporanpembelian', LaporanPembelianController::class);

    Route::get('laporanpembelianstok/report', [LaporanPembelianStokController::class, 'report'])->name('laporanpembelianstok.report');
    Route::get('laporanpembelianstok/export', [LaporanPembelianStokController::class, 'export'])->name('laporanpembelianstok.export');
    Route::get('laporanpembelianstok/index', [LaporanPembelianStokController::class, 'index']);
    Route::resource('laporanpembelianstok', LaporanPembelianStokController::class);

    Route::get('laporanhutanggiro/report', [LaporanHutangGiroController::class, 'report'])->name('laporanhutanggiro.report');
    Route::get('laporanhutanggiro/export', [LaporanHutangGiroController::class, 'export'])->name('laporanhutanggiro.export');
    Route::get('laporanhutanggiro/index', [LaporanHutangGiroController::class, 'index']);
    Route::resource('laporanhutanggiro', LaporanHutangGiroController::class);

    Route::get('laporanpinjamansupirkaryawan/export', [LaporanPinjamanSupirKaryawanController::class, 'export'])->name('laporanpinjamansupirkaryawan.export');
    Route::get('laporanpinjamansupirkaryawan/report', [LaporanPinjamanSupirKaryawanController::class, 'report'])->name('laporanpinjamansupirkaryawan.report');
    Route::get('laporanpinjamansupirkaryawan/index', [LaporanPinjamanSupirKaryawanController::class, 'index']);
    Route::resource('laporanpinjamansupirkaryawan', LaporanPinjamanSupirKaryawanController::class);

    Route::get('laporanpemotonganpinjamanperebs/report', [LaporanPemotonganPinjamanPerEBSController::class, 'report'])->name('laporanpemotonganpinjamanperebs.report');
    Route::get('laporanpemotonganpinjamanperebs/export', [LaporanPemotonganPinjamanPerEBSController::class, 'export'])->name('laporanpemotonganpinjamanperebs.export');
    Route::get('laporanpemotonganpinjamanperebs/index', [LaporanPemotonganPinjamanPerEBSController::class, 'index']);
    Route::resource('laporanpemotonganpinjamanperebs', LaporanPemotonganPinjamanPerEBSController::class);

    Route::get('laporansupirlebihdaritrado/report', [LaporanSupirLebihDariTradoController::class, 'report'])->name('laporansupirlebihdaritrado.report');
    Route::get('laporansupirlebihdaritrado/export', [LaporanSupirLebihDariTradoController::class, 'export'])->name('laporansupirlebihdaritrado.export');
    Route::get('laporansupirlebihdaritrado/index', [LaporanSupirLebihDariTradoController::class, 'index']);
    Route::resource('laporansupirlebihdaritrado', LaporanSupirLebihDariTradoController::class);

    Route::get('laporanpemotonganpinjamandepo/report', [LaporanPemotonganPinjamanDepoController::class, 'report'])->name('laporanpemotonganpinjamandepo.report');
    Route::get('laporanpemotonganpinjamandepo/index', [LaporanPemotonganPinjamanDepoController::class, 'index']);
    Route::resource('laporanpemotonganpinjamandepo', LaporanPemotonganPinjamanDepoController::class);

    Route::get('laporanrekapsumbangan/report', [LaporanRekapSumbanganController::class, 'report'])->name('laporanrekapsumbangan.report');
    Route::get('laporanrekapsumbangan/export', [LaporanRekapSumbanganController::class, 'export'])->name('laporanrekapsumbangan.export');
    Route::get('laporanrekapsumbangan/index', [LaporanRekapSumbanganController::class, 'index']);
    Route::resource('laporanrekapsumbangan', LaporanRekapSumbanganController::class);

    Route::get('laporanklaimpjtsupir/report', [LaporanKlaimPJTSupirController::class, 'report'])->name('laporanklaimpjtsupir.report');
    Route::get('laporanklaimpjtsupir/export', [LaporanKlaimPJTSupirController::class, 'export'])->name('laporanklaimpjtsupir.export');
    Route::get('laporanklaimpjtsupir/index', [LaporanKlaimPJTSupirController::class, 'index']);
    Route::resource('laporanklaimpjtsupir', LaporanKlaimPJTSupirController::class);

    Route::get('laporankartupiutangperpelanggan/report', [LaporanKartuPiutangPerPelangganController::class, 'report'])->name('laporankartupiutangperpelanggan.report');
    Route::get('laporankartupiutangperpelanggan/index', [LaporanKartuPiutangPerPelangganController::class, 'index']);
    Route::resource('laporankartupiutangperpelanggan', LaporanKartuPiutangPerPelangganController::class);

    Route::get('laporankartupiutangperplgdetail/report', [LaporanKartuPiutangPerPlgDetailController::class, 'report'])->name('laporankartupiutangperplgdetail.report');
    Route::get('laporankartupiutangperplgdetail/index', [LaporanKartuPiutangPerPlgDetailController::class, 'index']);
    Route::resource('laporankartupiutangperplgdetail', LaporanKartuPiutangPerPlgDetailController::class);

    Route::get('laporanorderpembelian/report', [LaporanOrderPembelianController::class, 'report'])->name('laporanorderpembelian.report');
    Route::get('laporanorderpembelian/index', [LaporanOrderPembelianController::class, 'index']);
    Route::resource('laporanorderpembelian', LaporanOrderPembelianController::class);

    Route::get('laporanneraca/report', [LaporanNeracaController::class, 'report'])->name('laporanneraca.report');
    Route::get('laporanneraca/export', [LaporanNeracaController::class, 'export'])->name('laporanneraca.export');
    Route::get('laporanneraca/index', [LaporanNeracaController::class, 'index']);
    Route::resource('laporanneraca', LaporanNeracaController::class);

    Route::get('exportpengeluaranbarang/export', [ExportPengeluaranBarangController::class, 'export'])->name('exportpengeluaranbarang.export');
    Route::get('exportpengeluaranbarang/index', [ExportPengeluaranBarangController::class, 'index']);
    Route::resource('exportpengeluaranbarang', ExportPengeluaranBarangController::class);

    Route::get('exportpembelianbarang/export', [ExportPembelianBarangController::class, 'export'])->name('exportpembelianbarang.export');
    Route::get('exportpembelianbarang/index', [ExportPembelianBarangController::class, 'index']);
    Route::resource('exportpembelianbarang', ExportPembelianBarangController::class);

    // Route::get('exportlaporandeposito/export', [ExportLaporanDepositoController::class, 'export'])->name('exportlaporandeposito.export');
    // Route::get('exportlaporandeposito/index', [ExportLaporanDepositoController::class, 'index']);
    // Route::resource('exportlaporandeposito', ExportLaporanDepositoController::class);

    Route::get('exportlaporankasgantung/export', [ExportLaporanKasGantungController::class, 'export'])->name('exportlaporankasgantung.export');
    Route::get('exportlaporankasgantung/index', [ExportLaporanKasGantungController::class, 'index']);
    Route::resource('exportlaporankasgantung', ExportLaporanKasGantungController::class);



    Route::get('exportlaporanstok/export', [ExportLaporanStokController::class, 'export'])->name('exportlaporanstok.export');
    Route::get('exportlaporanstok/index', [ExportLaporanStokController::class, 'index']);
    Route::resource('exportlaporanstok', ExportLaporanStokController::class);

    Route::get('laporanritasitrado/export', [LaporanRitasiTradoController::class, 'export'])->name('laporanritasitrado.export');
    Route::get('laporanritasitrado/index', [LaporanRitasiTradoController::class, 'index']);
    Route::resource('laporanritasitrado', LaporanRitasiTradoController::class);

    Route::get('laporanritasigandengan/export', [LaporanRitasiGandenganController::class, 'export'])->name('laporanritasigandengan.export');
    Route::get('laporanritasigandengan/index', [LaporanRitasiGandenganController::class, 'index']);
    Route::resource('laporanritasigandengan', LaporanRitasiGandenganController::class);

    Route::get('laporanhistorypinjaman/export', [LaporanHistoryPinjamanController::class, 'export'])->name('laporanhistorypinjaman.export');
    Route::get('laporanhistorypinjaman/report', [LaporanHistoryPinjamanController::class, 'report'])->name('laporanhistorypinjaman.report');
    Route::get('laporanhistorypinjaman/index', [LaporanHistoryPinjamanController::class, 'index']);
    Route::resource('laporanhistorypinjaman', LaporanHistoryPinjamanController::class);

    Route::get('pemutihansupir/index', [PemutihanSupirController::class, 'index']);
    Route::get('pemutihansupir/report', [PemutihanSupirController::class, 'report'])->name('pemutihansupir.report');
    Route::get('pemutihansupir/export', [PemutihanSupirController::class, 'export'])->name('pemutihansupir.export');
    Route::resource('pemutihansupir', PemutihanSupirController::class);
    Route::resource('pemutihansupirdetail', PemutihanSupirDetailController::class);

    Route::get('exportpemakaianbarang/export', [ExportPemakaianBarangController::class, 'export'])->name('exportpemakaianbarang.export');
    Route::get('exportpemakaianbarang/index', [ExportPemakaianBarangController::class, 'index']);
    Route::resource('exportpemakaianbarang', ExportPemakaianBarangController::class);

    Route::get('exportrincianmingguanpendapatan/export', [ExportRincianMingguanPendapatanSupirController::class, 'export'])->name('exportrincianmingguanpendapatan.export');
    Route::get('exportrincianmingguanpendapatan/index', [ExportRincianMingguanPendapatanSupirController::class, 'index']);
    Route::resource('exportrincianmingguanpendapatan', ExportRincianMingguanPendapatanSupirController::class);


    Route::get('laporankasgantung/report', [LaporanKasGantungController::class, 'report'])->name('laporankasgantung.report');
    Route::get('laporankasgantung/export', [LaporanKasGantungController::class, 'export'])->name('laporankasgantung.export');
    Route::get('laporankasgantung/index', [LaporanKasGantungController::class, 'index']);
    Route::resource('laporankasgantung', LaporanKasGantungController::class);

    Route::get('laporanpiutanggiro/report', [LaporanPiutangGiroController::class, 'report'])->name('laporanpiutanggiro.report');
    Route::get('laporanpiutanggiro/export', [LaporanPiutangGiroController::class, 'export'])->name('laporanpiutanggiro.export');
    Route::get('laporanpiutanggiro/index', [LaporanPiutangGiroController::class, 'index']);
    Route::resource('laporanpiutanggiro', LaporanPiutangGiroController::class);

    Route::get('laporantitipanemkl/report', [LaporanTitipanEmklController::class, 'report'])->name('laporantitipanemkl.report');
    Route::get('laporantitipanemkl/export', [LaporanTitipanEmklController::class, 'export'])->name('laporantitipanemkl.export');
    Route::get('laporantitipanemkl/index', [LaporanTitipanEmklController::class, 'index']);
    Route::resource('laporantitipanemkl', LaporanTitipanEmklController::class);

    Route::get('laporanrekaptitipanemkl/report', [LaporanRekapTitipanEmklController::class, 'report'])->name('laporanrekaptitipanemkl.report');
    Route::get('laporanrekaptitipanemkl/export', [LaporanRekapTitipanEmklController::class, 'export'])->name('laporanrekaptitipanemkl.export');
    Route::get('laporanrekaptitipanemkl/index', [LaporanRekapTitipanEmklController::class, 'index']);
    Route::resource('laporanrekaptitipanemkl', LaporanRekapTitipanEmklController::class);

    Route::get('laporankartuhutangpersupplier/report', [LaporanKartuHutangPerSupplierController::class, 'report'])->name('laporankartuhutangpersupplier.report');
    Route::get('laporankartuhutangpersupplier/export', [LaporanKartuHutangPerSupplierController::class, 'export'])->name('laporankartuhutangpersupplier.export');
    Route::get('laporankartuhutangpersupplier/index', [LaporanKartuHutangPerSupplierController::class, 'index']);
    Route::resource('laporankartuhutangpersupplier', LaporanKartuHutangPerSupplierController::class);

    Route::get('laporankartupiutangperagen/report', [LaporanKartuPiutangPerAgenController::class, 'report'])->name('laporankartupiutangperagen.report');
    Route::get('laporankartupiutangperagen/export', [LaporanKartuPiutangPerAgenController::class, 'export'])->name('laporankartupiutangperagen.export');
    Route::get('laporankartupiutangperagen/index', [LaporanKartuPiutangPerAgenController::class, 'index']);
    Route::resource('laporankartupiutangperagen', LaporanKartuPiutangPerAgenController::class);

    Route::get('laporankartupanjar/report', [LaporanKartuPanjarController::class, 'report'])->name('laporankartupanjar.report');
    Route::get('laporankartupanjar/export', [LaporanKartuPanjarController::class, 'export'])->name('laporankartupanjar.export');
    Route::get('laporankartupanjar/index', [LaporanKartuPanjarController::class, 'index']);
    Route::resource('laporankartupanjar', LaporanKartuPanjarController::class);    

    Route::get('laporanbangudangsementara/export', [LaporanBanGudangSementaraController::class, 'export'])->name('laporanbangudangsementara.export');
    Route::get('laporanbangudangsementara/report', [LaporanBanGudangSementaraController::class, 'report'])->name('laporanbangudangsementara.report');
    Route::get('laporanbangudangsementara/index', [LaporanBanGudangSementaraController::class, 'index']);
    Route::resource('laporanbangudangsementara', LaporanBanGudangSementaraController::class);

    Route::get('laporanestimasikasgantung/report', [LaporanEstimasiKasGantungController::class, 'report'])->name('laporanestimasikasgantung.report');
    Route::get('laporanestimasikasgantung/index', [LaporanEstimasiKasGantungController::class, 'index']);
    Route::resource('laporanestimasikasgantung', LaporanEstimasiKasGantungController::class);

    Route::get('exportrincianmingguan/export', [ExportRincianMingguanController::class, 'export'])->name('exportrincianmingguan.export');
    Route::get('exportrincianmingguan/index', [ExportRincianMingguanController::class, 'index']);
    Route::resource('exportrincianmingguan', ExportRincianMingguanController::class);

    Route::get('exportlaporankasharian/report', [ExportLaporanKasHarianController::class, 'report'])->name('exportlaporankasharian.report');
    Route::get('exportlaporankasharian/export', [ExportLaporanKasHarianController::class, 'export'])->name('exportlaporankasharian.export');
    Route::get('exportlaporankasharian/index', [ExportLaporanKasHarianController::class, 'index']);
    Route::resource('exportlaporankasharian', ExportLaporanKasHarianController::class);

    Route::get('exportlaporanmingguansupir/export', [ExportLaporanMingguanSupirController::class, 'export'])->name('exportlaporanmingguansupir.export');
    Route::get('exportlaporanmingguansupir/index', [ExportLaporanMingguanSupirController::class, 'index']);
    Route::resource('exportlaporanmingguansupir', ExportLaporanMingguanSupirController::class);

    Route::get('pindahbuku/export', [PindahBukuController::class, 'export'])->name('pindahbuku.export');
    Route::get('pindahbuku/report', [PindahBukuController::class, 'report'])->name('pindahbuku.report');
    Route::get('pindahbuku/index', [PindahBukuController::class, 'index']);
    Route::resource('pindahbuku', PindahBukuController::class);

    Route::get('laporankartuhutangpervendor/report', [LaporanKartuHutangPerVendorController::class, 'report'])->name('laporankartuhutangpervendor.report');
    Route::get('laporankartuhutangpervendor/index', [LaporanKartuHutangPerVendorController::class, 'index']);
    Route::resource('laporankartuhutangpervendor', LaporanKartuHutangPerVendorController::class);

    Route::get('laporanmutasikasbank/report', [LaporanMutasiKasBankController::class, 'report'])->name('laporanmutasikasbank.report');
    Route::get('laporanmutasikasbank/index', [LaporanMutasiKasBankController::class, 'index']);
    Route::resource('laporanmutasikasbank', LaporanMutasiKasBankController::class);

    Route::get('laporanmutasikasbank/export', [LaporanMutasiKasBankController::class, 'export'])->name('laporanmutasikasbank.export');
    Route::get('laporanmutasikasbank/index', [LaporanMutasiKasBankController::class, 'index']);
    Route::resource('laporanmutasikasbank', LaporanMutasiKasBankController::class);

    Route::get('laporankartustok/report', [LaporanKartuStokController::class, 'report'])->name('laporankartustok.report');
    Route::get('laporankartustok/index', [LaporanKartuStokController::class, 'index']);
    Route::resource('laporankartustok', LaporanKartuStokController::class);

    Route::get('laporansaldoinventory/export', [LaporanSaldoInventoryController::class, 'export'])->name('laporansaldoinventory.export');
    Route::get('laporansaldoinventory/report', [LaporanSaldoInventoryController::class, 'report'])->name('laporansaldoinventory.report');
    Route::get('laporansaldoinventory/index', [LaporanSaldoInventoryController::class, 'index']);
    Route::resource('laporansaldoinventory', LaporanSaldoInventoryController::class);
    
    // Route::get('laporansaldoinventory/export', [LaporanSaldoInventoryController::class, 'export'])->name('laporansaldoinventory.export');
    Route::get('laporansupplierbandingstok/report', [LaporanSupplierBandingStokController::class, 'report'])->name('laporansupplierbandingstok.report');
    Route::get('laporansupplierbandingstok/index', [LaporanSupplierBandingStokController::class, 'index']);
    Route::resource('laporansupplierbandingstok', LaporanSupplierBandingStokController::class);

    Route::get('laporansaldoinventorylama/export', [LaporanSaldoInventoryLamaController::class, 'export'])->name('laporansaldoinventorylama.export');
    Route::get('laporansaldoinventorylama/report', [LaporanSaldoInventoryLamaController::class, 'report'])->name('laporansaldoinventorylama.report');
    Route::get('laporansaldoinventorylama/index', [LaporanSaldoInventoryLamaController::class, 'index']);
    Route::resource('laporansaldoinventorylama', LaporanSaldoInventoryLamaController::class);

    Route::get('laporanaruskas/report', [LaporanArusKasController::class, 'report'])->name('laporanaruskas.report');
    Route::get('laporanaruskas/export', [LaporanArusKasController::class, 'export'])->name('laporanaruskas.export');
    Route::get('laporanaruskas/index', [LaporanArusKasController::class, 'index']);
    Route::resource('laporanaruskas', LaporanArusKasController::class);

    Route::get('karyawan/get', [KaryawanController::class, 'get'])->name('karyawan.get');
    Route::get('karyawan/index', [KaryawanController::class, 'index']);
    Route::get('karyawan/report', [KaryawanController::class, 'report'])->name('karyawan.report');
    Route::get('karyawan/export', [KaryawanController::class, 'export'])->name('karyawan.export');
    Route::resource('karyawan', KaryawanController::class);

    Route::get('approvaltradogambar/index', [ApprovalTradoGambarController::class, 'index']);
    Route::resource('approvaltradogambar', ApprovalTradoGambarController::class);

    Route::get('approvaltradoketerangan/index', [ApprovalTradoKeteranganController::class, 'index']);
    Route::resource('approvaltradoketerangan', ApprovalTradoKeteranganController::class);

    Route::get('ubahpassword/index', [UbahPasswordController::class, 'index']);
    Route::resource('ubahpassword', UbahPasswordController::class);

    Route::get('laporanpinjamanperunittrado/report', [LaporanPinjamanPerUnitTradoController::class, 'report'])->name('laporanpinjamanperunittrado.report');
    Route::get('laporanpinjamanperunittrado/export', [LaporanPinjamanPerUnitTradoController::class, 'export'])->name('laporanpinjamanperunittrado.export');
    Route::get('laporanpinjamanperunittrado/index', [LaporanPinjamanPerUnitTradoController::class, 'index']);
    Route::resource('laporanpinjamanperunittrado', LaporanPinjamanPerUnitTradoController::class);

    Route::get('stokpusat/index', [StokPusatController::class, 'index']);
    Route::resource('stokpusat', StokPusatController::class);

    Route::get('hutangextraheader/index', [HutangExtraHeaderController::class, 'index']);
    Route::get('hutangextraheader/export', [HutangExtraHeaderController::class, 'export'])->name('hutangextraheader.export');
    Route::get('hutangextraheader/report', [HutangExtraHeaderController::class, 'report'])->name('hutangextraheader.report');
    Route::resource('hutangextraheader', HutangExtraHeaderController::class);
    Route::get('hutangextradetail/jurnal/grid', [HutangExtraDetailController::class, 'jurnalGrid']);
    Route::get('hutangextradetail/hutang/grid', [HutangExtraDetailController::class, 'hutangGrid']);
    Route::get('hutangextradetail/detail/grid', [HutangExtraDetailController::class, 'detailGrid']);
    Route::resource('hutangextradetail', HutangExtraDetailController::class);

    Route::get('logabsensi/export', [LogAbsensiController::class, 'export'])->name('logabsensi.export');
    Route::get('logabsensi/report', [LogAbsensiController::class, 'report'])->name('logabsensi.report');
    Route::get('logabsensi/index', [LogAbsensiController::class, 'index']);
    Route::resource('logabsensi', LogAbsensiController::class);

    Route::get('karyawanlogabsensi/index', [KaryawanLogAbsensiController::class, 'index']);
    Route::resource('karyawanlogabsensi', KaryawanLogAbsensiController::class);

    Route::get('reminderoli/export', [ReminderOliController::class, 'export'])->name('reminderoli.export');
    Route::get('reminderoli/index', [ReminderOliController::class, 'index']);
    Route::resource('reminderoli', ReminderOliController::class);

    Route::get('expsim/index', [ExpSimController::class, 'index']);
    Route::resource('expsim', ExpSimController::class);
    Route::get('expstnk/index', [ExpStnkController::class, 'index']);
    Route::resource('expstnk', ExpStnkController::class);
    Route::get('expasuransi/index', [ExpAsuransiController::class, 'index']);
    Route::resource('expasuransi', ExpAsuransiController::class);

    Route::get('reminderstok/export', [ReminderStokController::class, 'export'])->name('reminderstok.export');
    Route::get('reminderstok/index', [ReminderStokController::class, 'index']);
    Route::resource('reminderstok', ReminderStokController::class);
    Route::get('statusolitrado/export', [StatusOliTradoController::class, 'export'])->name('statusolitrado.export');
    // Route::get('statusolitrado/exportdetail', [StatusOliTradoController::class, 'exportdetail'])->name('statusolitrado.exportdetail');
    Route::get('statusolitrado/index', [StatusOliTradoController::class, 'index']);
    Route::resource('statusolitrado', StatusOliTradoController::class);

    Route::get('reminderspk/index', [ReminderSpkController::class, 'index']);
    Route::resource('reminderspk', ReminderSpkController::class);
    Route::get('spkharian/index', [SpkHarianController::class, 'index']);
    Route::resource('spkharian', SpkHarianController::class);
    Route::get('statusgandengantruck/index', [StatusGandenganTruckController::class, 'index']);
    Route::resource('statusgandengantruck', StatusGandenganTruckController::class);

    Route::get('opnameheader/index', [OpnameHeaderController::class, 'index']);
    Route::get('opnameheader/export', [OpnameHeaderController::class, 'export'])->name('opnameheader.export');
    Route::get('opnameheader/report', [OpnameHeaderController::class, 'report'])->name('opnameheader.report');
    Route::resource('opnameheader', OpnameHeaderController::class);

    Route::get('pelunasanhutangheader/index', [PelunasanHutangHeaderController::class, 'index']);
    Route::get('pelunasanhutangheader/export', [PelunasanHutangHeaderController::class, 'export'])->name('pelunasanhutangheader.export');
    Route::get('pelunasanhutangheader/report', [PelunasanHutangHeaderController::class, 'report'])->name('pelunasanhutangheader.report');
    Route::resource('pelunasanhutangheader', PelunasanHutangHeaderController::class);

    Route::get('exportric/export', [ExportRicController::class, 'export'])->name('exportric.export');
    Route::get('exportric/index', [ExportRicController::class, 'index']);
    Route::resource('exportric', ExportRicController::class);


    Route::get('toemail/index', [ToEmailController::class, 'index']);
    Route::resource('toemail', ToEmailController::class);
    Route::get('ccemail/index', [CcEmailController::class, 'index']);
    Route::resource('ccemail', CcEmailController::class);
    Route::get('bccemail/index', [BccEmailController::class, 'index']);
    Route::resource('bccemail', BccEmailController::class);
    Route::get('reminderemail/index', [ReminderEmailController::class, 'index']);
    Route::resource('reminderemail', ReminderEmailController::class);

    Route::get('tripinap/index', [TripInapController::class, 'index']);
    Route::get('tripinap/report', [TripInapController::class, 'report'])->name('tripinap.report');
    Route::resource('tripinap', TripInapController::class);
    
    Route::get('pengajuantripinap/index', [PengajuanTripInapController::class, 'index']);
    Route::get('pengajuantripinap/report', [PengajuanTripInapController::class, 'report'])->name('pengajuantripinap.report');
    Route::resource('pengajuantripinap', PengajuanTripInapController::class);

    Route::get('laporanmingguansupirbedamandor/export', [LaporanMingguanSupirBedaMandorController::class, 'export'])->name('laporanmingguansupirbedamandor.export');
    Route::get('laporanmingguansupirbedamandor/index', [LaporanMingguanSupirBedaMandorController::class, 'index']);
    Route::resource('laporanmingguansupirbedamandor', LaporanMingguanSupirBedaMandorController::class);
    
    Route::get('supirserap/report', [SupirSerapController::class, 'report'])->name('supirserap.report');
    Route::get('supirserap/export', [SupirSerapController::class, 'export'])->name('supirserap.export');
    Route::get('supirserap/index', [SupirSerapController::class, 'index']);
    Route::resource('supirserap', SupirSerapController::class);
    
    Route::get('tradotambahanabsensi/report', [TradoTambahanAbsensiController::class, 'report'])->name('tradotambahanabsensi.report');
    Route::get('tradotambahanabsensi/export', [TradoTambahanAbsensiController::class, 'export'])->name('tradotambahanabsensi.export');
    Route::get('tradotambahanabsensi/index', [TradoTambahanAbsensiController::class, 'index']);
    Route::resource('tradotambahanabsensi', TradoTambahanAbsensiController::class);

    Route::get('laporanbiayasupir/export', [LaporanBiayaSupirController::class, 'export'])->name('laporanbiayasupir.export');
    Route::get('laporanbiayasupir/index', [LaporanBiayaSupirController::class, 'index']);
    Route::resource('laporanbiayasupir', LaporanBiayaSupirController::class);
    
    Route::get('otobon/report', [OtobonController::class, 'report'])->name('otobon.report');
    Route::get('otobon/index', [OtobonController::class, 'index']);
    Route::resource('otobon', OtobonController::class);
    
    Route::get('lapangan/report', [LapanganController::class, 'report'])->name('lapangan.report');
    Route::get('lapangan/index', [LapanganController::class, 'index']);
    Route::resource('lapangan', LapanganController::class);
    
    Route::get('laporanhistorysupirmilikmandor/report', [LaporanHistorySupirMilikMandorController::class, 'report'])->name('laporanhistorysupirmilikmandor.report');
    Route::get('laporanhistorysupirmilikmandor/export', [LaporanHistorySupirMilikMandorController::class, 'export'])->name('laporanhistorysupirmilikmandor.export');
    Route::get('laporanhistorysupirmilikmandor/index', [LaporanHistorySupirMilikMandorController::class, 'index']);
    Route::resource('laporanhistorysupirmilikmandor', LaporanHistorySupirMilikMandorController::class);
    
    Route::get('laporanhistorytradomilikmandor/report', [LaporanHistoryTradoMilikMandorController::class, 'report'])->name('laporanhistorytradomilikmandor.report');
    Route::get('laporanhistorytradomilikmandor/export', [LaporanHistoryTradoMilikMandorController::class, 'export'])->name('laporanhistorytradomilikmandor.export');
    Route::get('laporanhistorytradomilikmandor/index', [LaporanHistoryTradoMilikMandorController::class, 'index']);
    Route::resource('laporanhistorytradomilikmandor', LaporanHistoryTradoMilikMandorController::class);
    
    Route::get('laporanhistorytradomiliksupir/report', [LaporanHistoryTradoMilikSupirController::class, 'report'])->name('laporanhistorytradomiliksupir.report');
    Route::get('laporanhistorytradomiliksupir/export', [LaporanHistoryTradoMilikSupirController::class, 'export'])->name('laporanhistorytradomiliksupir.export');
    Route::get('laporanhistorytradomiliksupir/index', [LaporanHistoryTradoMilikSupirController::class, 'index']);
    Route::resource('laporanhistorytradomiliksupir', LaporanHistoryTradoMilikSupirController::class);
    
    Route::get('laporanapprovalstokreuse/report', [LaporanApprovalStokReuseController::class, 'report'])->name('laporanapprovalstokreuse.report');
    Route::get('laporanapprovalstokreuse/export', [LaporanApprovalStokReuseController::class, 'export'])->name('laporanapprovalstokreuse.export');
    Route::get('laporanapprovalstokreuse/index', [LaporanApprovalStokReuseController::class, 'index']);
    Route::resource('laporanapprovalstokreuse', LaporanApprovalStokReuseController::class);
    
    Route::get('exportperhitunganbonus/report', [ExportPerhitunganBonusController::class, 'report'])->name('exportperhitunganbonus.report');
    Route::get('exportperhitunganbonus/export', [ExportPerhitunganBonusController::class, 'export'])->name('exportperhitunganbonus.export');
    Route::get('exportperhitunganbonus/index', [ExportPerhitunganBonusController::class, 'index']);
    Route::resource('exportperhitunganbonus', ExportPerhitunganBonusController::class);
    Route::get('suratpengantarbiayatambahan/index', [SuratPengantarBiayaTambahanController::class, 'index']);
    Route::resource('suratpengantarbiayatambahan', SuratPengantarBiayaTambahanController::class);

    Route::get('laporanarusdanapusat/report', [LaporanArusDanaPusatController::class, 'report'])->name('laporanarusdanapusat.report');
    Route::get('laporanarusdanapusat/export', [LaporanArusDanaPusatController::class, 'export'])->name('laporanarusdanapusat.export');
    Route::get('laporanarusdanapusat/index', [LaporanArusDanaPusatController::class, 'index']);
    Route::resource('laporanarusdanapusat', LaporanArusDanaPusatController::class);
    
    Route::get('triptangki/report', [TripTangkiController::class, 'report'])->name('triptangki.report');
    Route::get('triptangki/index', [TripTangkiController::class, 'index']);
    Route::resource('triptangki', TripTangkiController::class);

    Route::get('tariftangki/export', [TarifTangkiController::class, 'export'])->name('tariftangki.export');
    Route::get('tariftangki/report', [TarifTangkiController::class, 'report'])->name('tariftangki.report');
    Route::get('tariftangki/index', [TarifTangkiController::class, 'index']);
    Route::resource('tariftangki', TarifTangkiController::class);

    Route::get('upahsupirtangki/export', [UpahSupirTangkiController::class, 'export'])->name('upahsupirtangki.export');
    Route::get('upahsupirtangki/report', [UpahSupirTangkiController::class, 'report'])->name('upahsupirtangki.report');
    Route::get('upahsupirtangki/index', [UpahSupirTangkiController::class, 'index']);
    Route::resource('upahsupirtangki', UpahSupirTangkiController::class);

    Route::get('biayaextrasupirheader/index', [BiayaExtraSupirHeaderController::class, 'index']);
    Route::resource('biayaextrasupirheader', BiayaExtraSupirHeaderController::class); 
    
    Route::get('statusgandengantrado/index', [StatusGandenganTradoController::class, 'index']);
    Route::resource('statusgandengantrado', StatusGandenganTradoController::class);

    // Route::get('invoiceemklheader/export', [InvoiceEmklHeaderController::class, 'export'])->name('invoiceemklheader.export');
    Route::get('invoiceemklheader/report', [InvoiceEmklHeaderController::class, 'report'])->name('invoiceemklheader.report');
    Route::get('invoiceemklheader/index', [InvoiceEmklHeaderController::class, 'index']);
    Route::resource('invoiceemklheader', InvoiceEmklHeaderController::class);
});

Route::patch('format', [FormatController::class, 'update']);
Route::get('lookup/{fileName}', [LookupController::class, 'show']);

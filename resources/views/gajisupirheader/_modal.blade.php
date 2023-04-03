<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form action="" method="post">

                    <div class="modal-body">

                        <div class="master">
                            <input type="hidden" name="id">
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NO BUKTI <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" name="nobukti" class="form-control" readonly>
                                </div>

                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TANGGAL BUKTI <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="tglbukti" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        SUPIR <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="hidden" name="supir_id">
                                    <input type="text" name="supir" autocomplete="off" class="form-control supir-lookup">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TANGGAL DARI <span class="text-danger">*</span>
                                    </label>
                                </div>

                                <div class="col-12 col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="tgldari" class="form-control datepicker" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TANGGAL SAMPAI <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="tglsampai" class="form-control datepicker" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <button class="btn btn-secondary" type="button" id="btnTampil"><i class="fas fa-sync"></i>
                                        RELOAD</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div id="tabs" class="dejavu" style="font-size:12px">
                                    <ul>
                                        <li><a href="#tabs-1">Rekap Rincian</a></li>
                                        <li><a href="#tabs-2">Pot. pinjaman (semua)</a></li>
                                        <li><a href="#tabs-3">Pot. pinjaman (pribadi)</a></li>
                                        <li><a href="#tabs-4">deposito</a></li>
                                        <li><a href="#tabs-5">bbm</a></li>
                                    </ul>
                                    <div id="tabs-1">
                                        <table id="rekapRincian"></table>
                                    </div>

                                    <div id="tabs-2">
                                        <div class="table-responsive table-scroll">
                                            <table class="table table-bordered mt-3" id="potonganSemua" style="width:1250px;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th width="1%">pilih</th>
                                                        <th width="10%">SUPIR</th>
                                                        <th width="20%">NO PINJAMAN</th>
                                                        <th width="9%">SISA</th>
                                                        <th width="20%">NOMINAL</th>
                                                        <th width="40%">KETERANGAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyPotSemua">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td>
                                                            <p id="sisaPotSemua" class="text-right font-weight-bold"></p>
                                                        </td>
                                                        <td>
                                                            <p id="nominalPotSemua" class="text-right font-weight-bold"></p>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="tabs-3">
                                        <div class="table-responsive table-scroll">
                                            <table class="table table-bordered mt-3" id="pinjamanPribadi" style="width:1200px;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th width="1%">pilih</th>
                                                        <th width="15%">NO PINJAMAN</th>
                                                        <th width="14%">SISA</th>
                                                        <th width="20%">NOMINAL</th>
                                                        <th width="50%">KETERANGAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyPinjPribadi">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td>
                                                            <p id="sisaPinjPribadi" class="text-right font-weight-bold"></p>
                                                        </td>
                                                        <td>
                                                            <p id="nominalPinjPribadi" class="text-right font-weight-bold"></p>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="tabs-4">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiDeposito" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiDeposito" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    Nominal Deposito</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomDeposito" class="form-control text-right">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    Keterangan Deposito</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketDeposito" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabs-5">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiBBM" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiBBM" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    Nominal BBM</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomBBM" class="form-control text-right">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2">
                                                <label class="col-form-label">
                                                    Keterangan BBM</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketBBM" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12 card">
                                <div class="card-body" id="detailLainnya">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button id="btnBatal" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    var today = new Date();

    let idRic
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()
    let supirId = 0
    let dari = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    let sampai = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    let selectedRows = [];
    let selectedNobukti = [];
    let selectedGajiSupir = [];
    let selectedGajiKenek = [];
    let selectedKomisiSupir = [];
    let selectedUpahRitasi = [];
    let selectedStatusRitasi = [];
    let selectedBiayaExtra = [];
    let selectedKetBiaya = [];
    let selectedTolSupir = [];
    let selectedRitasi = [];
    let subtotal = 0
    let sortnameRincian = 'nobuktitrip';
    let sortorderRincian = 'asc';
    let pageRincian = 0;
    let totalRecordRincian
    let limitRincian
    let postDataRincian
    let triggerClickRincian
    let indexRowRincian

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
            selectedNobukti.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_nobuktitrip"]`).text())
            selectedGajiSupir.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_gajisupir"]`).text())
            selectedGajiKenek.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_gajikenek"]`).text())
            selectedKomisiSupir.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_komisisupir"]`).text())
            selectedUpahRitasi.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_upahritasi"]`).text())
            selectedStatusRitasi.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_statusritasi"]`).text())
            selectedBiayaExtra.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_biayaextra"]`).text())
            selectedKetBiaya.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_keteranganbiaya"]`).text())
            selectedTolSupir.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_tolsupir"]`).text())
            selectedRitasi.push($(element).parents('tr').find(`td[aria-describedby="rekapRincian_ritasi_nobukti"]`).text())
            hitungNominal()

            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                    selectedNobukti.splice(i, 1);
                    selectedGajiSupir.splice(i, 1);
                    selectedGajiKenek.splice(i, 1);
                    selectedKomisiSupir.splice(i, 1);
                    selectedUpahRitasi.splice(i, 1);
                    selectedStatusRitasi.splice(i, 1);
                    selectedBiayaExtra.splice(i, 1);
                    selectedKetBiaya.splice(i, 1);
                    selectedTolSupir.splice(i, 1);
                    selectedRitasi.splice(i, 1);
                }
            }
            hitungNominal()
        }

    }

    function hitungNominal() {
        gajiSupir = 0;
        gajiKenek = 0;
        komisi = 0;
        tol = 0;
        upahRitasi = 0;
        biayaExtra = 0;
        $.each(selectedGajiSupir, function(index, item) {
            gajiSupir = gajiSupir + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedGajiKenek, function(index, item) {
            gajiKenek = gajiKenek + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedKomisiSupir, function(index, item) {
            komisi = komisi + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedUpahRitasi, function(index, item) {
            upahRitasi = upahRitasi + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedBiayaExtra, function(index, item) {
            biayaExtra = biayaExtra + parseFloat(item.replace(/,/g, ''))
        });
        $.each(selectedTolSupir, function(index, item) {
            tol = tol + parseFloat(item.replace(/,/g, ''))
        });
        subtotal = gajiSupir + gajiKenek + tol + upahRitasi + biayaExtra

        initAutoNumeric($('#crudForm').find(`[name="subtotal"]`).val(subtotal))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajisupir"]`).text(gajiSupir))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajikenek"]`).text(gajiKenek))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_komisisupir"]`).text(komisi))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_upahritasi"]`).text(upahRitasi))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_biayaextra"]`).text(biayaExtra))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_tolsupir"]`).text(tol))
        hitungSisa()
    }

    $(document).ready(function() {

        $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
            $('#crudForm').find(`[name="tglbuktiDeposito"]`).val($(this).val()).trigger('change');
            $('#crudForm').find(`[name="tglbuktiBBM"]`).val($(this).val()).trigger('change');
        });

        $(document).on('input', `#crudForm [name="uangmakanharian"]`, function(event) {
            let uangMakan = $(this).val()
            uangMakan = parseFloat(uangMakan.replaceAll(',', ''));
            uangMakan = Number.isNaN(uangMakan) ? 0 : uangMakan

            let subTotal = ($(`#crudForm [name="subtotal"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="subtotal"]`)[0])

            let total = subTotal + uangMakan

            let uangjalan = AutoNumeric.getNumber($(`#crudForm [name="uangjalan"]`)[0]);
            let deposito = ($(`#crudForm [name="deposito"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="deposito"]`)[0]);
            let bbm = ($(`#crudForm [name="bbm"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="bbm"]`)[0]);
            let potonganpinjaman = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjaman"]`)[0]);
            let potonganpinjamansemua = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjamansemua"]`)[0]);

            let sisa = total - (uangjalan + deposito + bbm + potonganpinjaman + potonganpinjamansemua)

            $(`#crudForm [name="sisa"]`).val(sisa)

            new AutoNumeric(`#crudForm [name="sisa"]`)
        })
        $(document).on('input', `#crudForm [name="nomDeposito"]`, function(event) {
            let nomDepo = AutoNumeric.getNumber($(this)[0]);

            $(`#crudForm [name="deposito"]`).val(nomDepo)
            new AutoNumeric(`#crudForm [name="deposito"]`)

            hitungSisa()

        })

        $(document).on('input', `#crudForm [name="nomBBM"]`, function(event) {
            let nomBBM = AutoNumeric.getNumber($(this)[0]);
            $(`#crudForm [name="bbm"]`).val(nomBBM)
            new AutoNumeric(`#crudForm [name="bbm"]`)
            hitungSisa()
        })
        $(document).on('input', `#crudForm [name="uangjalantidakterhitung"]`, function(event) {
            hitungSisa()
        })
        $(document).on('click', '#btnTampil', function(event) {
            event.preventDefault()
            let form = $('#crudForm')

            supirId = form.find(`[name="supir_id"]`).val()
            dari = form.find(`[name="tgldari"]`).val()
            sampai = form.find(`[name="tglsampai"]`).val()
            tglbukti = form.find(`[name="tglbukti"]`).val()
            let aksi = form.data('action')
            $('#tripList tbody').html('')
            $('#gajiSupir').html('')
            $('#gajiKenek').html('')

            selectAllRows(supirId, dari, sampai, aksi)
            $.ajax({
                url: `${apiUrl}gajisupirheader/getuangjalan`,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    limit: 0,
                    supir_id: supirId,
                    dari: dari,
                    sampai: sampai,
                    tglbukti: tglbukti
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    console.log(response)
                    initAutoNumeric(form.find(`[name="uangjalan"]`).val(response.data.uangjalan))

                }
            })

        })

        $('#btnSubmit').click(function(event) {

            let method
            let url
            let form = $('#crudForm')


            event.preventDefault()

            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            // let data = $('#crudForm').serializeArray()
            let data = []

            data.push({
                name: 'id',
                value: form.find(`[name="id"]`).val()
            })
            data.push({
                name: 'nobukti',
                value: form.find(`[name="nobukti"]`).val()
            })
            data.push({
                name: 'tglbukti',
                value: form.find(`[name="tglbukti"]`).val()
            })
            data.push({
                name: 'supir',
                value: form.find(`[name="supir"]`).val()
            })
            data.push({
                name: 'supir_id',
                value: form.find(`[name="supir_id"]`).val()
            })
            data.push({
                name: 'tgldari',
                value: form.find(`[name="tgldari"]`).val()
            })
            data.push({
                name: 'tglsampai',
                value: form.find(`[name="tglsampai"]`).val()
            })

            $.each(selectedRows, function(index, item) {
                data.push({
                    name: 'rincianId[]',
                    value: item
                })
            });
            $.each(selectedNobukti, function(index, item) {
                data.push({
                    name: 'rincian_nobukti[]',
                    value: item
                })
            });

            $.each(selectedGajiSupir, function(index, item) {
                data.push({
                    name: 'rincian_gajisupir[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });
            $.each(selectedGajiKenek, function(index, item) {
                data.push({
                    name: 'rincian_gajikenek[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });
            $.each(selectedKomisiSupir, function(index, item) {
                data.push({
                    name: 'rincian_komisisupir[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });
            $.each(selectedTolSupir, function(index, item) {
                data.push({
                    name: 'rincian_tolsupir[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });
            $.each(selectedUpahRitasi, function(index, item) {
                data.push({
                    name: 'rincian_upahritasi[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });
            $.each(selectedStatusRitasi, function(index, item) {
                data.push({
                    name: 'rincian_statusritasi[]',
                    value: item
                })
            });
            $.each(selectedRitasi, function(index, item) {
                data.push({
                    name: 'rincian_ritasi[]',
                    value: item
                })
            });
            $.each(selectedBiayaExtra, function(index, item) {
                data.push({
                    name: 'rincian_biayaextra[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });
            $.each(selectedKetBiaya, function(index, item) {
                data.push({
                    name: 'rincian_keteranganbiaya[]',
                    value: item
                })
            });



            $('#crudForm').find(`[name="uangmakanharian"]`).each((index, element) => {
                data.push({
                    name: 'uangmakanharian',
                    value: AutoNumeric.getNumber($(`#crudForm [name="uangmakanharian"]`)[index])
                })
            })
            $('#crudForm').find(`[name="subtotal"]`).each((index, element) => {
                data.push({
                    name: 'subtotal',
                    value: AutoNumeric.getNumber($(`#crudForm [name="subtotal"]`)[index])
                })
            })
            $('#crudForm').find(`[name="deposito"]`).each((index, element) => {
                data.push({
                    name: 'deposito',
                    value: AutoNumeric.getNumber($(`#crudForm [name="deposito"]`)[index])
                })
            })

            $('#crudForm').find(`[name="potonganpinjaman"]`).each((index, element) => {
                data.push({
                    name: 'potonganpinjaman',
                    value: AutoNumeric.getNumber($(`#crudForm [name="potonganpinjaman"]`)[index])
                })
            })

            $('#crudForm').find(`[name="bbm"]`).each((index, element) => {
                data.push({
                    name: 'bbm',
                    value: AutoNumeric.getNumber($(`#crudForm [name="bbm"]`)[index])
                })
            })

            $('#crudForm').find(`[name="uangjalan"]`).each((index, element) => {
                data.push({
                    name: 'uangjalan',
                    value: AutoNumeric.getNumber($(`#crudForm [name="uangjalan"]`)[index])
                })
            })
            $('#crudForm').find(`[name="uangjalantidakterhitung"]`).each((index, element) => {
                data.push({
                    name: 'uangjalantidakterhitung',
                    value: AutoNumeric.getNumber($(`#crudForm [name="uangjalantidakterhitung"]`)[index])
                })
            })

            $('#crudForm').find(`[name="nomDeposito"]`).each((index, element) => {
                data.push({
                    name: 'nomDeposito',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomDeposito"]`)[index])
                })
            })
            data.push({
                name: 'ketDeposito',
                value: form.find(`[name="ketDeposito"]`).val()
            })
            $('#crudForm').find(`[name="nomBBM"]`).each((index, element) => {
                data.push({
                    name: 'nomBBM',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomBBM"]`)[index])
                })
            })
            data.push({
                name: 'ketBBM',
                value: form.find(`[name="ketBBM"]`).val()
            })


            $('#tbodyPotSemua tr').each(function(row, tr) {


                if ($(this).find(`[name="pinjSemua[]"]`).is(':checked')) {

                    data.push({
                        name: 'nominalPS[]',
                        value: AutoNumeric.getNumber($(`#crudForm [name="nominalPS[]"]`)[row])
                    })
                    data.push({
                        name: 'pinjSemua[]',
                        value: $(this).find(`[name="pinjSemua[]"]`).val()
                    })
                    data.push({
                        name: 'pinjSemua_nobukti[]',
                        value: $(this).find(`[name="pinjSemua_nobukti[]"]`).val()
                    })
                    data.push({
                        name: 'pinjSemua_keterangan[]',
                        value: $(this).find(`[name="pinjSemua_keterangan[]"]`).val()
                    })
                }
            })

            $('#tbodyPinjPribadi tr').each(function(row, tr) {


                if ($(this).find(`[name="pinjPribadi[]"]`).is(':checked')) {

                    data.push({
                        name: 'nominalPP[]',
                        value: AutoNumeric.getNumber($(`#crudForm [name="nominalPP[]"]`)[row])
                    })
                    data.push({
                        name: 'pinjPribadi[]',
                        value: $(this).find(`[name="pinjPribadi[]"]`).val()
                    })
                    data.push({
                        name: 'pinjPribadi_nobukti[]',
                        value: $(this).find(`[name="pinjPribadi_nobukti[]"]`).val()
                    })
                    data.push({
                        name: 'pinjPribadi_keterangan[]',
                        value: $(this).find(`[name="pinjPribadi_keterangan[]"]`).val()
                    })
                }
            })

            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })
            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })

            data.push({
                name: 'tgldariheader',
                value: $('#tgldariheader').val()
            })
            data.push({
                name: 'tglsampaiheader',
                value: $('#tglsampaiheader').val()
            })

            let tgldariheader = $('#tgldariheader').val();
            let tglsampaiheader = $('#tglsampaiheader').val()

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}gajisupirheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}gajisupirheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}gajisupirheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}gajisupirheader`
                    break;
            }

            $(this).attr('disabled', '')
            $('#loader').removeClass('d-none')

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    id = response.data.id
                    $('#crudModal').find('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page
                    }).trigger('reloadGrid');
                    selectedRows = []
                    selectedNobukti = [];
                    selectedGajiSupir = [];
                    selectedGajiKenek = [];
                    selectedKomisiSupir = [];
                    selectedUpahRitasi = [];
                    selectedStatusRitasi = [];
                    selectedBiayaExtra = [];
                    selectedKetBiaya = [];
                    selectedTolSupir = [];
                    selectedRitasi = [];
                    if (id == 0) {
                        $('#detail').jqGrid().trigger('reloadGrid')
                    }
                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
                    }
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        errors = error.responseJSON.errors
                        keys = Object.keys(errors)
                        keyError = keys[0]
                        textError = keyError.substr(0, 9);
                        console.log(errors)
                        if (textError == 'nominalPS') {
                            pinjSemua = []
                            $('#tbodyPotSemua tr').each(function(row, tr) {
                                if ($(this).find(`[name="pinjSemua[]"]`).is(':checked')) {
                                    pinjSemua.push($(this).find(`[name="pinjSemua[]"]`).val())
                                }
                            })
                        } else if (textError == 'nominalPP') {
                            pinjPribadi = []
                            $('#tbodyPinjPribadi tr').each(function(row, tr) {
                                if ($(this).find(`[name="pinjPribadi[]"]`).is(':checked')) {
                                    pinjPribadi.push($(this).find(`[name="pinjPribadi[]"]`).val())
                                }
                            })
                        }

                        $.each(errors, (index, error) => {
                            let indexes = index.split(".");
                            let angka = indexes[1]

                            if (textError == 'nominalPS') {
                                row = pinjSemua[angka] - 1;
                            } else if (textError == 'nominalPP') {
                                row = pinjPribadi[angka] - 1;
                            }
                            let element;

                            if (indexes.length > 1) {
                                element = form.find(`[name="${indexes[0]}[]"]`)[row];
                            } else {
                                element = form.find(`[name="${indexes[0]}"]`)[0];
                            }

                            $(element).addClass("is-invalid");
                            $(`
                                <div class="invalid-feedback">
                                ${error[0].toLowerCase()}
                                </div>
                            `).appendTo($(element).parent());

                            if ($(element).length > 0 && $(element).is(":hidden")) {
                                return showDialog(error);
                            }
                            if (keyError == 'rincian') {
                                return showDialog(error);
                            }

                        });
                        // setErrorMessagesCheckForm(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.statusText)
                    }
                },
            }).always(() => {
                $('#loader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        $("#tabs").tabs()
        setFormBindKeys(form)

        activeGrid = null

        getMaxLength(form)
        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        selectedRows = []
        selectedNobukti = [];
        selectedGajiSupir = [];
        selectedGajiKenek = [];
        selectedKomisiSupir = [];
        selectedUpahRitasi = [];
        selectedStatusRitasi = [];
        selectedBiayaExtra = [];
        selectedKetBiaya = [];
        selectedTolSupir = [];
        selectedRitasi = [];
        $('#crudModal').find('.modal-body').html(modalBody)
    })


    function createGajiSupirHeader() {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)

        form.data('action', 'add')
        $('#crudModalTitle').text('Add Rincian Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiDeposito]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiBBM]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglbuktiPinjaman]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#detailLainnya').html('')
        getPotSemua($('#crudForm'))
        rekapRincian('getTrip')
        selectAllRows()
        detailLainnya()
        initDatepicker()
        form.find(`[name="subtotal"]`).addClass('disabled')
        initAutoNumeric($('#crudForm').find('[name=nomDeposito]'))
        initAutoNumeric($('#crudForm').find('[name=nomBBM]'))
        initAutoNumeric($('#crudForm').find('[name=nomPinjaman]'))
        initAutoNumeric($('#crudForm').find('[name=uangmakanharian]'))
        initAutoNumeric($('#crudForm').find('[name=uangjalantidakterhitung]'))
    }

    async function editGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        $('#crudModalTitle').text('Edit Rincian Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        showGajiSupir(form, Id, 'edit')
        let ricList = await getEditTrip(Id)
        rekapRincian(`${Id}/getEditTrip`)
        selectedRows = ricList.data.map((data) => {
            let element = $('#crudForm').find(`[name="rincianId[]"][value=${data.id}]`)

            element.prop('checked', true)
            element.parents('tr').addClass('bg-light-blue')

            return data.id
        })
        selectedNobukti = ricList.data.map((data) => data.nobuktitrip)
        selectedGajiSupir = ricList.data.map((data) => data.gajisupir)
        selectedGajiKenek = ricList.data.map((data) => data.gajikenek)
        selectedKomisiSupir = ricList.data.map((data) => data.komisisupir)
        selectedUpahRitasi = ricList.data.map((data) => data.upahritasi)
        selectedStatusRitasi = ricList.data.map((data) => data.statusritasi)
        selectedBiayaExtra = ricList.data.map((data) => data.biayaextra)
        selectedKetBiaya = ricList.data.map((data) => data.keteranganbiaya)
        selectedTolSupir = ricList.data.map((data) => data.tolsupir)
        selectedRitasi = ricList.data.map((data) => data.ritasi_nobukti)
        hitungNominal()
    }

    async function deleteGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)
        $('#crudModalTitle').text('Delete Rincian Gaji Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        form.find('#btnTampil').prop('disabled', true)
        showGajiSupir(form, Id, 'delete')
        let ricList = await getEditTrip(Id)
        rekapRincian(`${Id}/getEditTrip`)
        selectedRows = ricList.data.map((data) => {
            let element = $('#crudForm').find(`[name="rincianId[]"][value=${data.id}]`)

            element.prop('checked', true)
            element.parents('tr').addClass('bg-light-blue')

            return data.id
        })
        hitungNominal()
    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `${apiUrl}gajisupirheader/${Id}/cekvalidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var kodenobukti = response.kodenobukti
                if (kodenobukti == '1') {
                    var kodestatus = response.kodestatus
                    if (kodestatus == '1') {
                        showDialog(response.message['keterangan'])
                    } else {
                        cekValidasiAksi(Id, Aksi)

                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `${apiUrl}gajisupirheader/${Id}/cekValidasiAksi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var kondisi = response.kondisi
                if (kondisi == true) {
                    showDialog(response.message['keterangan'])
                } else {
                    if (Aksi == 'EDIT') {
                        editGajiSupirHeader(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteGajiSupirHeader(Id)
                    }
                }

            }
        })
    }

    function hitungSisa() {
        // hitung sisa
        let subtotal = ($(`#crudForm [name="subtotal"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="subtotal"]`)[0]);
        let uangmakanharian = ($(`#crudForm [name="uangmakanharian"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="uangmakanharian"]`)[0]);
        let total = subtotal + uangmakanharian;

        let uangjalan = AutoNumeric.getNumber($(`#crudForm [name="uangjalan"]`)[0]);
        let uangjalantidakterhitung = ($(`#crudForm [name="uangjalantidakterhitung"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="uangjalantidakterhitung"]`)[0]);
        let deposito = ($(`#crudForm [name="deposito"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="deposito"]`)[0]);
        let bbm = ($(`#crudForm [name="bbm"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="bbm"]`)[0]);
        let potonganpinjaman = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjaman"]`)[0]);
        let potonganpinjamansemua = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjamansemua"]`)[0]);

        let sisa = total - (uangjalan + deposito + bbm + potonganpinjaman + potonganpinjamansemua + uangjalantidakterhitung)
        $(`#crudForm [name="sisa"]`).val(sisa)
        new AutoNumeric(`#crudForm [name="sisa"]`)
    }

    function showGajiSupir(form, gajiId, aksi) {
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        detailLainnya()

        $.ajax({
            url: `${apiUrl}gajisupirheader/${gajiId}`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
                $.each(response.data, (index, value) => {
                    let element = form.find(`[name="${index}"]`)

                    form.find(`[name="${index}"]`).val(value)

                    if (element.hasClass('datepicker')) {
                        element.val(dateFormat(value))
                    }

                    if (index == 'supir') {
                        element.data('current-value', value).prop('readonly', true)
                        element.parent('.input-group').find('.button-clear').remove()
                        element.parent('.input-group').find('.input-group-append').remove()
                    }


                })
                console.log(response.data.supir_id)

                initAutoNumeric(form.find(`[name="subtotal"]`))
                initAutoNumeric(form.find(`[name="uangjalan"]`))
                initAutoNumeric(form.find(`[name="uangjalantidakterhitung"]`))
                initAutoNumeric(form.find(`[name="uangmakanharian"]`))
                initAutoNumeric(form.find(`[name="deposito"]`))
                initAutoNumeric(form.find(`[name="potonganpinjaman"]`))
                initAutoNumeric(form.find(`[name="potonganpinjamansemua"]`))
                initAutoNumeric(form.find(`[name="bbm"]`))


                if (response.pinjamanpribadi.length === 0) {
                    let detailRow = $(`
                        <tr>
                            <td colspan='5' class="text-center">TIDAK ADA DATA</td>
                        </tr>
                        `)

                    $('#pinjamanPribadi tbody').append(detailRow)

                } else {

                    let totalSisa = 0
                    let saldoAwal = 0;
                    $.each(response.pinjamanpribadi, (index, detail) => {
                        disabled = (detail.nominal == null) ? 'disabled' : '';
                        checked = (detail.gajisupir_id == null) ? '' : 'checked';
                        if ($)
                            totalSisa = totalSisa + parseFloat(detail.sisa);
                        saldoAwal = saldoAwal + parseFloat(detail.sisaawal);
                        let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

                        nominal = (detail.nominal == null) ? '' : detail.nominal;
                        let detailRow = $(`
                        <tr >
                        <td>
                            <input name='pinjPribadi[]' type="checkbox" id="checkItem" value="${detail.id}" ${checked}>
                            <input name='pinjPribadi_nobukti[]' type="hidden" value="${detail.nobukti}">
                        </td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPP autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${detail.sisaawal}">
                        </td>
                        <td id=${detail.id}>
                            <input type="text" name="nominalPP[]" class="form-control bayar text-right" ${disabled} value="${nominal}">
                        </td>
                        <td>${detail.keterangan}
                            <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}"></td>
                        </tr>
                    `)

                        initAutoNumeric(detailRow.find(`[name="sisaPP[]"]`))
                        initAutoNumeric(detailRow.find(`[name="nominalPP[]"]:not([disabled])`))
                        initAutoNumeric(detailRow.find(`[name="sisaAwalPP[]"]`))
                        initAutoNumeric(detailRow.find(`.sisaPP`))

                        $('#pinjamanPribadi tbody').append(detailRow)
                        setTotalPP()
                        setSisaPP()
                    })

                    // $('#sisaPinjPribadi').set(`${totalSisa}`)

                    // initAutoNumeric(form.find(`[name="saldopinjaman"]`).val(saldoAwal))
                    // initAutoNumeric(form.find(`[name="sisapinjaman"]`).val(totalSisa))
                    $(`#pinjamanPribadi tfoot`).show()
                }

                if (response.pinjamansemua != null) {

                    let totalSisa = 0
                    let saldoAwal = 0
                    $.each(response.pinjamansemua, (index, detail) => {
                        disabled = (detail.nominal == null) ? 'disabled' : '';
                        checked = (detail.gajisupir_id == null) ? '' : 'checked';
                        totalSisa = totalSisa + parseFloat(detail.sisa);
                        saldoAwal = saldoAwal + parseFloat(detail.sisaawal);
                        nominal = (detail.nominal == null) ? '' : detail.nominal;

                        let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
                        let detailRow = $(`
                        <tr >
                        <td>
                            <input name='pinjSemua[]' type="checkbox" id="checkItem" value="${detail.id}" ${checked}>
                            <input name='pinjSemua_nobukti[]' type="hidden" value="${detail.nobukti}">
                        </td>
                        <td>SEMUA</td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPS autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPS[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPS[]" class="autonumeric" value="${detail.sisa}">
                        </td>
                        <td id=${detail.id}>
                            <input type="text" name="nominalPS[]" value="${nominal}" ${disabled} class="form-control text-right">
                        </td>
                        <td>
                            ${detail.keterangan}
                            <input name='pinjSemua_keterangan[]' type="hidden" value="${detail.keterangan}">
                        </td>
                        </tr>
                    `)

                        initAutoNumeric(detailRow.find(`[name="nominalPS[]"]:not([disabled])`))
                        initAutoNumeric(detailRow.find(`[name="sisaPS[]"]`))
                        initAutoNumeric(detailRow.find(`[name="sisaAwalPS[]"]`))
                        initAutoNumeric(detailRow.find(`.sisaPS`))

                        $('#potonganSemua tbody').append(detailRow)
                        setTotalPS()
                        setSisaPS()

                    })

                    $('#sisaPotSemua').append(`${totalSisa}`)
                    // initAutoNumeric(form.find(`[name="saldopinjamansemua"]`).val(saldoAwal))
                    // initAutoNumeric(form.find(`[name="sisapinjamansemua"]`).val(totalSisa))
                    initAutoNumeric($('#potonganSemua tfoot').find('#sisaPotSemua'))
                    setRowNumbers()

                }
                if (response.deposito != null) {
                    form.find(`[name="nobuktiDeposito"]`).val(response.deposito.nobukti)
                    form.find(`[name="tglbuktiDeposito"]`).val(response.data.tglbukti)
                    initAutoNumeric(form.find(`[name="nomDeposito"]`).val(response.deposito.nominal))
                    form.find(`[name="ketDeposito"]`).val(response.deposito.keterangan)
                } else {
                    initAutoNumeric(form.find(`[name="nomDeposito"]`))
                }
                if (response.bbm != null) {
                    form.find(`[name="nobuktiBBM"]`).val(response.bbm.nobukti)
                    form.find(`[name="tglbuktiBBM"]`).val(response.data.tglbukti)
                    initAutoNumeric(form.find(`[name="nomBBM"]`).val(response.bbm.nominal))
                    form.find(`[name="ketBBM"]`).val(response.bbm.keterangan)
                } else {
                    initAutoNumeric(form.find(`[name="nomBBM"]`))
                }


                if (aksi == 'delete') {

                    form.find('[name]').addClass('disabled')
                    initDisabled()
                }
                hitungSisa()
            }
        })
    }

    function rekapRincian(url) {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }
        $("#rekapRincian").jqGrid({
                url: `${apiUrl}gajisupirheader/${url}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: '',
                        name: '',
                        width: 30,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        searchable: false,
                        searchoptions: {
                            type: 'checkbox',
                            clearSearch: false,
                            dataInit: function(element) {
                                supirId = $('#crudForm').find(`[name="supir_id"]`).val()
                                dari = $('#crudForm').find(`[name="tgldari"]`).val()
                                sampai = $('#crudForm').find(`[name="tglsampai"]`).val()
                                let aksi = $('#crudForm').data('action')

                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                if (disabled == '') {
                                    $(element).on('click', function() {
                                        if ($(this).is(':checked')) {
                                            selectAllRows(tglDari, tglSampai, aksi)
                                        } else {
                                            clearSelectedRows()
                                        }
                                    })
                                }
                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="rincianId[]" value="${rowData.id}" ${disabled} onchange="checkboxHandler(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        hidden: true
                    },
                    {
                        label: 'NO. BUKTI',
                        name: 'nobuktitrip',
                        align: 'left',
                    },
                    {
                        label: 'TANGGAL BUKTI',
                        name: 'tglbuktisp',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TRADO',
                        name: 'trado_id',
                        align: 'left'
                    },
                    {
                        label: 'DARI',
                        name: 'dari_id',
                        align: 'left'
                    },
                    {
                        label: 'SAMPAI',
                        name: 'sampai_id',
                        align: 'left'
                    },
                    {
                        label: 'NO CONT',
                        name: 'nocont',
                        align: 'left'
                    },
                    {
                        label: 'NO SP',
                        name: 'nosp',
                        align: 'left'
                    },
                    {
                        label: 'GAJI SUPIR',
                        name: 'gajisupir',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'GAJI KENEK',
                        name: 'gajikenek',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'KOMISI SUPIR',
                        name: 'komisisupir',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'TOL SUPIR',
                        name: 'tolsupir',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'NO BUKTI RITASI',
                        name: 'ritasi_nobukti',
                        align: 'left'
                    },
                    {
                        label: 'UPAH RITASI',
                        name: 'upahritasi',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'STATUS RITASI',
                        name: 'statusritasi',
                        align: 'left'
                    },
                    {
                        label: 'BIAYA EXTRA',
                        name: 'biayaextra',
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'KET. BIAYA EXTRA',
                        name: 'keteranganbiaya',
                        align: 'left'
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 400,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameRincian,
                sortorder: sortorderRincian,
                page: pageRincian,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: (jqXHR) => {
                    jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },

                onSelectRow: function(id) {
                    activeGrid = $(this)
                },
                loadComplete: function(data) {
                    let grid = $(this)
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    $.each(selectedRows, function(key, value) {

                        $('#rekapRincian tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).find(`td input:checkbox`).prop('checked', true)
                            }
                        })

                    });

                    /* Set global variables */
                    sortnameRincian = $(this).jqGrid("getGridParam", "sortname")
                    sortorderRincian = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordRincian = $(this).getGridParam("records")
                    limitRincian = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataRincian = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickRincian = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowRincian > $(this).getDataIDs().length - 1) {
                        indexRowRincian = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRows, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td input:checkbox`).prop('checked', true)
                            }
                        })
                    });

                    
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {
                    $(this).setGridParam({
                        postData: {
                            supirId: $('#crudForm [name=supir_id]').val(),
                            dari: $('#crudForm [name=tgldari]').val(),
                            sampai: $('#crudForm [name=tglsampai]').val(),
                        },
                    })
                    clearGlobalSearch($('#rekapRincian'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#rekapRincian'))

        /* Append global search */
        loadGlobalSearch($('#rekapRincian'))
    }


    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(2)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }


    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}gajisupirheader/field_length`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        if (value !== null && value !== 0 && value !== undefined) {
                            form.find(`[name=${index}]`).attr('maxlength', value)
                        }
                    })

                    form.attr('has-maxlength', true)
                },
                error: error => {
                    showDialog(error.statusText)
                }
            })
        }
    }

    function getPotSemua(form) {

        $.ajax({
            url: `${apiUrl}gajisupirheader/getpinjsemua`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

                let totalSisa = 0
                $.each(response.data, (index, detail) => {

                    let id = detail.id
                    totalSisa = totalSisa + parseFloat(detail.sisa);
                    let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
                    let supir = (detail.supir_id == 0) ? 'SEMUA' : '';
                    let detailRow = $(`
                        <tr>
                        <td>
                            <input name='pinjSemua[]' type="checkbox" id="checkItem" value="${id}">
                            <input name='pinjSemua_nobukti[]' type="hidden" value="${detail.nobukti}">
                        </td>
                        <td>${supir}</td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPS autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPS[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPS[]" class="autonumeric" value="${sisa}">
                        </td>
                        <td id=${id}>
                            <input type="text" name="nominalPS[]" disabled class="form-control bayar text-right">
                        </td>
                        <td>
                            ${detail.keterangan}
                            <input name='pinjSemua_keterangan[]' type="hidden" value="${detail.keterangan}"></td>
                        </tr>
                    `)

                    initAutoNumeric(detailRow.find(`[name="sisaPS[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisaAwalPS[]"]`))
                    initAutoNumeric(detailRow.find(`.sisaPS`))

                    $('#potonganSemua tbody').append(detailRow)
                    setTotalPS()

                })

                $('#sisaPotSemua').append(`${totalSisa}`)
                // initAutoNumeric($('#detailLainnya').find(`[name="saldopinjamansemua"]`).val(totalSisa))
                // initAutoNumeric($('#detailLainnya').find(`[name="sisapinjamansemua"]`).val(totalSisa))
                initAutoNumeric($('#potonganSemua tfoot').find('#sisaPotSemua'))
                setRowNumbers()

            }
        })

    }


    function setTotalPS() {
        let nominalDetails = $(`#tbodyPotSemua [name="nominalPS[]"]:not([disabled])`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#nominalPotSemua').set(total)
        initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjamansemua"]`).val(total))
        hitungSisa()
    }

    $(document).on('click', `#potonganSemua tbody [name="pinjSemua[]"]`, function() {

        if ($(this).prop("checked") == true) {

            $(this).closest('tr').find(`td [name="nominalPS[]"]`).prop('disabled', false)
            let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaPS[]"]`)[0])
            initAutoNumeric($(this).closest('tr').find(`td [name="nominalPS[]"]`))
            setTotalPS()
            setSisaPS()
        } else {

            let id = $(this).val()
            $(this).closest('tr').find(`td [name="nominalPS[]"]`).remove();
            let newBayarElement = `<input type="text" name="nominalPS[]" class="form-control bayar text-right" disabled>`
            $(this).closest('tr').find(`#${id}`).append(newBayarElement)

            let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwalPS[]"]`)[0])
            // $('#detailLainnya').find(`[name="potonganpinjamansemua"]`).val('')
            initAutoNumeric($(this).closest('tr').find(`td [name="sisaPS[]"]`).val(sisa))
            $(this).closest("tr").find(".sisaPS").html(sisa)
            initAutoNumeric($(this).closest("tr").find(".sisaPS"))

            setTotalPS()
            setSisaPS()
        }
    })

    $(document).on('input', `#tbodyPotSemua [name="nominalPS[]"]`, function(event) {

        setTotalPS()
        let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaPS[]"]`)[0])
        let sisaAwal = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaAwalPS[]"]`)[0])
        let bayar = $(this).val()
        bayar = parseFloat(bayar.replaceAll(',', ''));
        bayar = Number.isNaN(bayar) ? 0 : bayar
        totalSisa = sisaAwal - bayar
        $(this).closest("tr").find(".sisaPS").html(totalSisa)
        $(this).closest("tr").find(`[name="sisaPS[]"]`).val(totalSisa)

        initAutoNumeric($(this).closest("tr").find(".sisaPS"))
        let Sisa = $(`#tbodyPotSemua .sisaPS`)
        let total = 0

        $.each(Sisa, (index, SISA) => {
            total += AutoNumeric.getNumber(SISA)
        });
        new AutoNumeric('#sisaPotSemua').set(total)
    })

    function setSisaPS() {
        let nominalDetails = $(`.sisaPS`)
        let bayar = 0
        $.each(nominalDetails, (index, nominalDetail) => {
            bayar += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#sisaPotSemua').set(bayar)
    }

    function getPinjPribadi(supirId, form) {
        $.ajax({
            url: `${apiUrl}gajisupirheader/${supirId}/getpinjpribadi`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

                let totalSisa = 0
                $.each(response.data, (index, detail) => {

                    let id = detail.id
                    totalSisa = totalSisa + parseFloat(detail.sisa);
                    let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
                    let detailRow = $(`
                        <tr >
                        <td>
                            <input name='pinjPribadi[]' type="checkbox" id="checkItem" value="${id}">
                            <input name='pinjPribadi_nobukti[]' type="hidden" value="${detail.nobukti}">
                        </td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPP autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${sisa}">
                        </td>
                        <td id=${id}>
                            <input type="text" name="nominalPP[]" disabled class="form-control bayar text-right">
                        </td>
                        <td>
                            ${detail.keterangan}
                            <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}">
                        </td>
                        </tr>
                    `)

                    initAutoNumeric(detailRow.find(`[name="sisaPP[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisaAwalPP[]"]`))
                    initAutoNumeric(detailRow.find(`.sisaPP`))

                    $('#pinjamanPribadi tbody').append(detailRow)
                    setTotalPP()
                    // setSisaPP()
                })

                // $('#sisaPinjPribadi').set(`${totalSisa}`)

                $(`#pinjamanPribadi tfoot`).show()
                // initAutoNumeric($('#detailLainnya').find(`[name="saldopinjaman"]`).val(totalSisa))
                // initAutoNumeric($('#detailLainnya').find(`[name="sisapinjaman"]`).val(totalSisa))
                // initAutoNumeric($('#pinjamanPribadi tfoot').find('#sisaPinjPribadi'))
                // setRowNumbers()

            }
        })
    }

    function setTotalPP() {
        let nominalDetails = $(`#tbodyPinjPribadi [name="nominalPP[]"]:not([disabled])`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#nominalPinjPribadi').set(total)
        initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjaman"]`).val(total))

        hitungSisa()
    }

    $(document).on('click', `#pinjamanPribadi tbody [name="pinjPribadi[]"]`, function() {

        if ($(this).prop("checked") == true) {

            $(this).closest('tr').find(`td [name="nominalPP[]"]`).prop('disabled', false)
            let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaPP[]"]`)[0])
            initAutoNumeric($(this).closest('tr').find(`td [name="nominalPP[]"]`))
            // initAutoNumeric($(this).closest('tr').find(`td [name="nominalPP[]"]`).val(sisa))
            // let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominalPP[]"]`)[0])
            // let totalSisa = sisa - bayar

            // $(this).closest("tr").find(".sisaPP").html(totalSisa)
            // $(this).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)
            // initAutoNumeric($(this).closest("tr").find(".sisaPP"))

            setTotalPP()
            setSisaPP()
        } else {

            let id = $(this).val()
            $(this).closest('tr').find(`td [name="nominalPP[]"]`).remove();
            let newBayarElement = `<input type="text" name="nominalPP[]" class="form-control text-right" disabled>`
            $(this).closest('tr').find(`#${id}`).append(newBayarElement)
            $('#detailLainnya').find(`[name="potonganpinjaman"]`).val('')
            let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwalPP[]"]`)[0])

            initAutoNumeric($(this).closest('tr').find(`td [name="sisaPP[]"]`).val(sisa))
            $(this).closest("tr").find(".sisaPP").html(sisa)
            initAutoNumeric($(this).closest("tr").find(".sisaPP"))

            setTotalPP()
            setSisaPP()
        }
    })

    $(document).on('input', `#tbodyPinjPribadi [name="nominalPP[]"]`, function(event) {

        setTotalPP()
        let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaPP[]"]`)[0])
        let sisaAwal = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaAwalPP[]"]`)[0])
        let bayar = $(this).val()
        bayar = parseFloat(bayar.replaceAll(',', ''));
        bayar = Number.isNaN(bayar) ? 0 : bayar
        totalSisa = sisaAwal - bayar
        $(this).closest("tr").find(".sisaPP").html(totalSisa)
        $(this).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)

        initAutoNumeric($(this).closest("tr").find(".sisaPP"))
        let Sisa = $(`#tbodyPinjPribadi .sisaPP`)
        let total = 0

        $.each(Sisa, (index, SISA) => {
            total += AutoNumeric.getNumber(SISA)
        });
        new AutoNumeric('#sisaPinjPribadi').set(total)
    })

    function setSisaPP() {
        let nominalDetails = $(`.sisaPP`)
        let bayar = 0
        $.each(nominalDetails, (index, nominalDetail) => {
            bayar += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#sisaPinjPribadi').set(bayar)
    }


    function detailLainnya() {
        let detailRow = $(`
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   total uang borongan
                  </label>
                </div>
                <div class="col-12 col-md-9">
                  <input type="text" name="subtotal" class="form-control autonumeric" readonly>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   uang makan
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="uangmakanharian" class="form-control text-right">
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   total potongan uang jalan Tidak Terhitung
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="uangjalantidakterhitung" class="form-control text-right">
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   total potongan uang jalan
                  </label>
                </div>
                <div class="col-12 col-md-9">
                  <input type="text" name="uangjalan" class="form-control autonumeric" readonly>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   total Potongan Pinjaman 
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="potonganpinjaman" class="form-control autonumeric" readonly>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   total Potongan Pinjaman (SEMUA)
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="potonganpinjamansemua" class="form-control autonumeric" readonly>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   total Deposito
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="deposito" class="form-control autonumeric" readonly>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   total Potongan BBM
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="bbm" class="form-control autonumeric" readonly>
                </div>
            </div>
            
            <hr style="border: 1px solid rgb(0 0 0 / 58%);">

            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   Sisa yang diterima supir
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="sisa" class="form-control autonumeric" readonly>
                </div>
            </div>



                                   
    `)
        $('#detailLainnya').append(detailRow)

        initAutoNumeric(detailRow.find('.autonumeric'))

    }

    function initLookup() {
        $('.supir-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supir_id]').first().val(supir.id)
                $(`#pinjamanPribadi tfoot`).hide()
                $(`#sisaPinjPribadi`).html('')
                $(`#sisaPinjPribadi`).append('0.00')
                $('#tbodyPinjPribadi').html('')
                getPinjPribadi(supir.id, $('#crudForm'))
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supir_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    async function getEditTrip(gajiId) {
        return await $.ajax({
            url: `${apiUrl}gajisupirheader/${gajiId}/getEditTrip`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                supirId: $('#crudForm [name=supir_id]').val(),
                dari: dari,
                sampai: sampai,
                sortIndex: sortnameRincian,
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: (response) => {
                return response
            },
            error: (error) => {
                showDialog(error.responseJSON.message)
            }
        })
    }

    function clearSelectedRows() {
        selectedRows = []
        selectedNobukti = [];
        selectedGajiSupir = [];
        selectedGajiKenek = [];
        selectedKomisiSupir = [];
        selectedUpahRitasi = [];
        selectedStatusRitasi = [];
        selectedBiayaExtra = [];
        selectedKetBiaya = [];
        selectedTolSupir = [];
        selectedRitasi = [];
        $('#rekapRincian').trigger('reloadGrid')
    }

    function selectAllRows(supirId, dari, sampai, aksi) {
        if (aksi == 'edit') {
            ricId = $(`#crudForm`).find(`[name="id"]`).val()
            url = `${ricId}/getEditTrip`
        } else {
            url = 'getTrip'
        }
        $.ajax({
            url: `${apiUrl}gajisupirheader/${url}`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                supirId: supirId,
                dari: dari,
                sampai: sampai,
                sortIndex: sortnameRincian,
                aksi: aksi
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: (response) => {
                selectedRows = response.data.map((data) => data.id)
                selectedNobukti = response.data.map((data) => data.nobuktitrip)
                selectedGajiSupir = response.data.map((data) => data.gajisupir)
                selectedGajiKenek = response.data.map((data) => data.gajikenek)
                selectedKomisiSupir = response.data.map((data) => data.komisisupir)
                selectedUpahRitasi = response.data.map((data) => data.upahritasi)
                selectedStatusRitasi = response.data.map((data) => data.statusritasi)
                selectedBiayaExtra = response.data.map((data) => data.biayaextra)
                selectedKetBiaya = response.data.map((data) => data.keteranganbiaya)
                selectedTolSupir = response.data.map((data) => data.tolsupir)
                selectedRitasi = response.data.map((data) => data.ritasi_nobukti)

                $('#rekapRincian').jqGrid('setGridParam', {
                    url: `${apiUrl}gajisupirheader/${url}`,
                    postData: {
                        supirId: $('#crudForm').find('[name=supir_id]').val(),
                        dari: $('#crudForm').find('[name=tgldari]').val(),
                        sampai: $('#crudForm').find('[name=tglsampai]').val(),
                        aksi: aksi
                    },
                }).trigger('reloadGrid');
                hitungNominal()

            }
        })

    }
</script>
@endpush()
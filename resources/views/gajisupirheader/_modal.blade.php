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
                                        NO BUKTI <span class="text-danger"></span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" name="nobukti" class="form-control" readonly>
                                </div>

                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TGL BUKTI <span class="text-danger">*</span>
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
                                    <input type="text" name="supir" id="supir" autocomplete="off" class="form-control supir-lookup">
                                </div>
                            </div>

                            <div class="row form-group statusjeniskendaraan">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        STATUS JENIS KENDARAAN <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <select name="statusjeniskendaraan" class="form-control select2bs4" id="statusjeniskendaraan">
                                        <option value="">-- PILIH STATUS JENIS KENDARAAN --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        TGL DARI <span class="text-danger">*</span>
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
                                        TGL SAMPAI <span class="text-danger">*</span>
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
                                    <button class="btn btn-primary" type="button" id="btnTampil"><i class="fas fa-sync"></i>
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
                                        <li><a href="#tabs-6">absensi</a></li>
                                    </ul>
                                    <div id="tabs-1">
                                        <table id="rekapRincian"></table>
                                    </div>

                                    <div id="tabs-2">
                                        <table id="tablePotSemua"></table>
                                    </div>

                                    <div id="tabs-3">
                                        <table id="tablePotPribadi"></table>
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
                                                    TGL bukti</label>
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
                                            <div class="col-12 col-sm-9 col-md-10" id="contNomDepo">
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
                                                    TGL bukti</label>
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
                                            <div class="col-12 col-sm-9 col-md-10" id="contNomBbm">
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
                                    <div id="tabs-6">
                                        <table id="tableAbsensi"></table>
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
                            Save
                        </button>
                        <button id="btnSaveAdd" class="btn btn-success">
                            <i class="fas fa-file-upload"></i>
                            Save & Add
                        </button>
                        <button id="btnBatal" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Cancel
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

    let komisiGajiKenek
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

    let sortnameAbsensi = 'absensi_nobukti';
    let sortorderAbsensi = 'asc';
    let pageAbsensi = 0;
    let totalRecordAbsensi
    let limitAbsensi
    let postDataAbsensi
    let triggerClickAbsensi
    let indexRowAbsensi
    let selectedRowsAbsensi = [];
    let selectedRowsAbsensiNobukti = [];
    let selectedRowsAbsensiUangjalan = [];
    let selectedRowsAbsensiTrado = [];
    let isReload = false;
    let isJenisTangki

    function checkboxHandler(element, rowId) {

        let isChecked = $(element).is(":checked");
        let editableColumns = $("#rekapRincian").getGridParam("editableColumns");
        let selectedRowIds = $("#rekapRincian").getGridParam("selectedRowIds");
        let originalGridData = $("#rekapRincian")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

        editableColumns.forEach((editableColumn) => {

            if (!isChecked) {
                for (var i = 0; i < selectedRowIds.length; i++) {
                    if (selectedRowIds[i] == rowId) {
                        selectedRowIds.splice(i, 1);
                    }
                }

                $("#rekapRincian").jqGrid("setCell", rowId, "uangmakanberjenjang", 0);
                $(`#rekapRincian tr#${rowId}`).find(`td[aria-describedby="rekapRincian_uangmakanberjenjang"]`).attr("value", 0)
                // hitungNominal()
                hitung(selectedRowIds)
                $(element).parents('tr').removeClass('bg-light-blue')
            } else {
                selectedRowIds.push(rowId);

                // hitungNominal()
                hitung(selectedRowIds)
                $(element).parents('tr').addClass('bg-light-blue')
            }
        });

        $("#rekapRincian").jqGrid("setGridParam", {
            selectedRowIds: selectedRowIds,
        });



    }

    function hitung(selectedRowIds) {
        gajiSupir = 0;
        gajiKenek = 0;
        komisi = 0;
        tol = 0;
        upahRitasi = 0;
        biayaExtra = 0;
        biayaExtraSupir = 0;
        $.each(selectedRowIds, (index, value) => {
            dataTrip = $("#rekapRincian").jqGrid("getLocalRow", value);
            let selectedGaji = dataTrip.gajisupir
            let selectedKenek = dataTrip.gajikenek
            let selectedKomisi = dataTrip.komisisupir
            let selectedTol = dataTrip.tolsupir
            let selectedUpahRitasi = dataTrip.upahritasi
            let selectedBiayaExtra = dataTrip.biayaextra
            let selectedBiayaExtraSupir = dataTrip.biayaextrasupir_nominal

            gajiSupir = gajiSupir + parseFloat(selectedGaji)
            gajiKenek = gajiKenek + parseFloat(selectedKenek)
            komisi = komisi + parseFloat(selectedKomisi)
            tol = tol + parseFloat(selectedTol)
            upahRitasi = upahRitasi + parseFloat(selectedUpahRitasi)
            biayaExtra = biayaExtra + parseFloat(selectedBiayaExtra)
            biayaExtraSupir = biayaExtraSupir + parseFloat(selectedBiayaExtraSupir)
        })
        if (komisiGajiKenek == 'YA') {
            subtotal = gajiSupir + tol + upahRitasi + biayaExtra + biayaExtraSupir
        } else {
            subtotal = gajiSupir + gajiKenek + tol + upahRitasi + biayaExtra + biayaExtraSupir
        }
        initAutoNumeric($('#crudForm').find(`[name="subtotal"]`).val(subtotal))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajisupir"]`).text(gajiSupir))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajikenek"]`).text(gajiKenek))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_komisisupir"]`).text(komisi))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_upahritasi"]`).text(upahRitasi))
        initAutoNumericMinus($('.footrow').find(`td[aria-describedby="rekapRincian_biayaextra"]`).text(biayaExtra))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_tolsupir"]`).text(tol))
        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_biayaextrasupir_nominal"]`).text(biayaExtraSupir))
        hitungSisa()
    }

    function checkboxAbsensiHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRowsAbsensi.push($(element).val())
            selectedRowsAbsensiNobukti.push($(element).parents('tr').find(`td[aria-describedby="tableAbsensi_absensi_nobukti"]`).text())
            selectedRowsAbsensiTrado.push($(element).parents('tr').find(`td[aria-describedby="tableAbsensi_absensi_tradoid"]`).text())
            selectedRowsAbsensiUangjalan.push($(element).parents('tr').find(`td[aria-describedby="tableAbsensi_absensi_uangjalan"]`).text())
            hitungUangJalan()

            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRowsAbsensi.length; i++) {
                if (selectedRowsAbsensi[i] == value) {
                    selectedRowsAbsensi.splice(i, 1);
                    selectedRowsAbsensiNobukti.splice(i, 1);
                    selectedRowsAbsensiUangjalan.splice(i, 1);
                    selectedRowsAbsensiTrado.splice(i, 1);
                }
            }
            hitungUangJalan()
        }

    }

    function hitungUangJalan() {
        uangJalan = 0;
        $.each(selectedRowsAbsensiUangjalan, function(index, item) {
            uangJalan = uangJalan + parseFloat(item.replace(/,/g, ''))
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableAbsensi_absensi_uangjalan"]`).text(uangJalan))
        initAutoNumeric($('#crudForm').find(`[name="uangjalan"]`).val(uangJalan))
        hitungSisa()
    }

    // function hitungNominal() {
    //     gajiSupir = 0;
    //     gajiKenek = 0;
    //     komisi = 0;
    //     tol = 0;
    //     upahRitasi = 0;
    //     biayaExtra = 0;
    //     $.each(selectedGajiSupir, function(index, item) {
    //         gajiSupir = gajiSupir + parseFloat(item.replace(/,/g, ''))
    //     });
    //     $.each(selectedGajiKenek, function(index, item) {
    //         gajiKenek = gajiKenek + parseFloat(item.replace(/,/g, ''))
    //     });
    //     $.each(selectedKomisiSupir, function(index, item) {
    //         komisi = komisi + parseFloat(item.replace(/,/g, ''))
    //     });
    //     $.each(selectedUpahRitasi, function(index, item) {
    //         upahRitasi = upahRitasi + parseFloat(item.replace(/,/g, ''))
    //     });
    //     $.each(selectedBiayaExtra, function(index, item) {
    //         biayaExtra = biayaExtra + parseFloat(item.replace(/,/g, ''))
    //     });
    //     $.each(selectedTolSupir, function(index, item) {
    //         tol = tol + parseFloat(item.replace(/,/g, ''))
    //     });
    //     subtotal = gajiSupir + gajiKenek + tol + upahRitasi + biayaExtra
    //     console.log(subtotal)
    //     initAutoNumeric($('#crudForm').find(`[name="subtotal"]`).val(subtotal))
    //     initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajisupir"]`).text(gajiSupir))
    //     initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_gajikenek"]`).text(gajiKenek))
    //     initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_komisisupir"]`).text(komisi))
    //     initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_upahritasi"]`).text(upahRitasi))
    //     initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_biayaextra"]`).text(biayaExtra))
    //     initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_tolsupir"]`).text(tol))
    //     hitungSisa()
    // }

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
            let uangmakanBerjenjang = ($(`#crudForm [name="berjenjanguangmakan"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="berjenjanguangmakan"]`)[0])

            let total = subTotal + uangMakan + uangmakanBerjenjang

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

        $(document).on('input', `#crudForm [name="biayaextraheader"]`, function(event) {
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
            $('#loaderGrid').removeClass('d-none')
            getAllTrip(aksi)
                .then((response) => {

                    $("#rekapRincian")[0].p.selectedRowIds = [];
                    let selectedTrip = []
                    if ($('#crudForm').data('action') == 'add') {
                        $.each(response.data, (index, value) => {
                            selectedTrip.push(value.id)
                        })
                    }
                    // selectedRows = response.data.map((data) => data.id)
                    // selectedNobukti = response.data.map((data) => data.nobuktitrip)
                    // selectedGajiSupir = response.data.map((data) => data.gajisupir)
                    // selectedGajiKenek = response.data.map((data) => data.gajikenek)
                    // selectedKomisiSupir = response.data.map((data) => data.komisisupir)
                    // selectedUpahRitasi = response.data.map((data) => data.upahritasi)
                    // selectedStatusRitasi = response.data.map((data) => data.statusritasi)
                    // selectedBiayaExtra = response.data.map((data) => data.biayaextra)
                    // selectedKetBiaya = response.data.map((data) => data.keteranganbiaya)
                    // selectedTolSupir = response.data.map((data) => data.tolsupir)
                    // selectedRitasi = response.data.map((data) => data.ritasi_nobukti)


                    if ($('#crudForm').data('action') == 'edit') {
                        isReload = true;
                        $(`[name="rincianId[]"]`).prop('disabled', false)

                    }
                    $('#rekapRincian').jqGrid('setGridParam', {
                        datatype: "local",
                        data: response.data,
                        originalData: response.data,
                        rowNum: response.data.length,
                        selectedRowIds: selectedTrip
                    }).trigger('reloadGrid');

                    hitung(selectedTrip)
                })
                .catch((error) => {
                    console.log('error getrip ', error)
                    $('#loaderGrid').addClass('d-none')
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                })

            if (dari != '' && sampai != '' && supirId != '') {


                getAllAbsensi(supirId, dari, sampai, aksi)
                    .then((response) => {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        if ($('#crudForm').data('action') == 'add') {
                            selectedRowsAbsensi = []
                            selectedRowsAbsensiNobukti = []
                            selectedRowsAbsensiUangjalan = []
                            selectedRowsAbsensiTrado = []
                            $.each(response.data, (index, value) => {
                                selectedRowsAbsensi.push(value.absensi_id)
                                selectedRowsAbsensiNobukti.push(value.absensi_nobukti)
                                selectedRowsAbsensiUangjalan.push(value.absensi_uangjalan)
                                selectedRowsAbsensiTrado.push(value.absensi_tradoid)
                            })
                        }
                        if ($('#crudForm').data('action') == 'edit') {
                            selectedRowsAbsensi = []
                            selectedRowsAbsensiNobukti = []
                            selectedRowsAbsensiUangjalan = []
                            selectedRowsAbsensiTrado = []
                            isReload = true;
                            $(`[name="absensiId[]"]`).prop('disabled', false)

                        }
                        $('#tableAbsensi').jqGrid('setGridParam', {
                            url: `${apiUrl}gajisupirheader/${urlAbsensi}`,
                            postData: {
                                supir_id: $('#crudForm').find('[name=supir_id]').val(),
                                tgldari: $('#crudForm').find('[name=tgldari]').val(),
                                tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                                statusjeniskendaraan: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val(),
                                aksi: aksi
                            },
                            datatype: "json"
                        }).trigger('reloadGrid');
                        hitungUangJalan()
                    })
                    .catch((error) => {

                        console.log('error getabsen ', error)
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()
                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    })
            }

            // getDataPotSemua().then((response) => {
            //     $("#tablePotSemua")[0].p.selectedRowIds = [];
            //     if ($('#crudForm').data('action') == 'add') {
            //         selectedRowId = [];
            //     } else {
            //         selectedRowId = response.selectedId;
            //     }
            //     // setTimeout(() => {

            //     $("#tablePotSemua")
            //         .jqGrid("setGridParam", {
            //             datatype: "local",
            //             data: response.data,
            //             originalData: response.data,
            //             rowNum: response.data.length,
            //             selectedRowIds: selectedRowId
            //         })
            //         .trigger("reloadGrid");
            //     // }, 100);

            // });
            // selectAllRowsAbsensi(supirId, dari, sampai, aksi)
            // $.ajax({
            //     url: `${apiUrl}gajisupirheader/getuangjalan`,
            //     method: 'POST',
            //     dataType: 'JSON',
            //     data: {
            //         limit: 0,
            //         supir_id: supirId,
            //         dari: dari,
            //         sampai: sampai,
            //         tglbukti: tglbukti
            //     },
            //     headers: {
            //         Authorization: `Bearer ${accessToken}`
            //     },
            //     success: response => {
            //         console.log(response)
            //         initAutoNumeric(form.find(`[name="uangjalan"]`).val(response.data.uangjalan))

            //     }
            // })

            let supir = form.find(`[name="supir"]`).val();
            let defaultKetBBM = "HUTANG BBM SUPIR " + supir + " PERIODE " + dari + " S/D " + sampai;
            let defaultKetDeposito = "DEPOSITO SUPIR " + supir + " PERIODE " + dari + " S/D " + sampai;
            if (aksi == 'add') {

                form.find(`[name="ketDeposito"]`).val(defaultKetDeposito);
                form.find(`[name="ketBBM"]`).val(defaultKetBBM);

            }
        })


        $('#btnSubmit').click(function(event) {
            event.preventDefault()
            submit($(this).attr('id'))
        })
        $('#btnSaveAdd').click(function(event) {
            event.preventDefault()
            submit($(this).attr('id'))
        })

        function submit(button) {

            let method
            let url
            let form = $('#crudForm')



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
            data.push({
                name: 'aksi',
                value: action.toUpperCase()
            })


            let selectedRowsTrip = $("#rekapRincian").getGridParam("selectedRowIds");
            $.each(selectedRowsTrip, function(index, value) {
                dataTrip = $("#rekapRincian").jqGrid("getLocalRow", value);
                let selectedUangMakanBerjenjang = (dataTrip.uangmakanberjenjang == undefined) ? 0 : dataTrip.uangmakanberjenjang;
                data.push({
                    name: 'uangmakanjenjang[]',
                    value: (isNaN(selectedUangMakanBerjenjang)) ? parseFloat(selectedUangMakanBerjenjang.replaceAll(',', '')) : selectedUangMakanBerjenjang
                })
                data.push({
                    name: 'rincianId[]',
                    value: dataTrip.id
                })
                data.push({
                    name: 'rincian_nobukti[]',
                    value: dataTrip.nobuktitrip
                })
                data.push({
                    name: 'rincian_gajisupir[]',
                    value: parseFloat(dataTrip.gajisupir)
                })
                data.push({
                    name: 'rincian_gajikenek[]',
                    value: parseFloat(dataTrip.gajikenek)
                })
                data.push({
                    name: 'rincian_komisisupir[]',
                    value: parseFloat(dataTrip.komisisupir)
                })
                data.push({
                    name: 'rincian_tolsupir[]',
                    value: parseFloat(dataTrip.tolsupir)
                })
                data.push({
                    name: 'rincian_upahritasi[]',
                    value: parseFloat(dataTrip.upahritasi)
                })
                data.push({
                    name: 'rincian_statusritasi[]',
                    value: dataTrip.statusritasi
                })
                data.push({
                    name: 'rincian_biayaextrasupir_nobukti[]',
                    value: dataTrip.biayaextrasupir_nobukti
                })
                data.push({
                    name: 'rincian_biayaextrasupir_nominal[]',
                    value: parseFloat(dataTrip.biayaextrasupir_nominal)
                })
                data.push({
                    name: 'rincian_biayaextrasupir_keterangan[]',
                    value: dataTrip.biayaextrasupir_keterangan
                })
                data.push({
                    name: 'rincian_ritasi[]',
                    value: dataTrip.ritasi_nobukti
                })
                data.push({
                    name: 'rincian_biayaextra[]',
                    value: parseFloat(dataTrip.biayaextra)
                })
                data.push({
                    name: 'rincian_keteranganbiaya[]',
                    value: dataTrip.keteranganbiaya
                })
                data.push({
                    name: 'rincian_container[]',
                    value: dataTrip.container_id
                })
                data.push({
                    name: 'rincian_statuscontainer[]',
                    value: dataTrip.statuscontainer_id
                })
                data.push({
                    name: 'rincian_upahid[]',
                    value: dataTrip.upah_id
                })
            });

            $.each(selectedRowsAbsensiNobukti, function(index, item) {
                data.push({
                    name: 'absensi_nobukti[]',
                    value: item
                })
            });
            $.each(selectedRowsAbsensiTrado, function(index, item) {
                data.push({
                    name: 'absensi_trado_id[]',
                    value: item
                })
            });
            $.each(selectedRowsAbsensiUangjalan, function(index, item) {
                data.push({
                    name: 'absensi_uangjalan[]',
                    value: parseFloat(item.replaceAll(',', ''))
                })
            });

            $('#crudForm').find(`[name="biayaextraheader"]`).each((index, element) => {
                data.push({
                    name: 'biayaextraheader',
                    value: AutoNumeric.getNumber($(`#crudForm [name="biayaextraheader"]`)[index])
                })
            })
            data.push({
                name: 'keteranganextra',
                value: form.find(`[name="keteranganextra"]`).val()
            })
            $('#crudForm').find(`[name="uangmakanharian"]`).each((index, element) => {
                data.push({
                    name: 'uangmakanharian',
                    value: AutoNumeric.getNumber($(`#crudForm [name="uangmakanharian"]`)[index])
                })
            })
            $('#crudForm').find(`[name="berjenjanguangmakan"]`).each((index, element) => {
                data.push({
                    name: 'uangmakanberjenjang',
                    value: AutoNumeric.getNumber($(`#crudForm [name="berjenjanguangmakan"]`)[index])
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

            let selectedRowsPotSemua = $("#tablePotSemua").getGridParam("selectedRowIds");
            $.each(selectedRowsPotSemua, function(index, value) {
                dataPotSemua = $("#tablePotSemua").jqGrid("getLocalRow", value);
                let selectedSisaPS = dataPotSemua.pinjSemua_sisa
                let selectedNominalPS = (dataPotSemua.nominalPS == undefined) ? 0 : dataPotSemua.nominalPS;

                data.push({
                    name: 'nominalPS[]',
                    value: (isNaN(selectedNominalPS)) ? parseFloat(selectedNominalPS.replaceAll(',', '')) : selectedNominalPS
                })
                data.push({
                    name: 'pinjSemua_sisa[]',
                    value: selectedSisaPS
                })
                data.push({
                    name: 'pinjSemua_keterangan[]',
                    value: dataPotSemua.pinjSemua_keterangan
                })
                data.push({
                    name: 'pinjSemua_nobukti[]',
                    value: dataPotSemua.pinjSemua_nobukti
                })
                data.push({
                    name: 'pinjSemua[]',
                    value: dataPotSemua.id
                })
            });

            let selectedRowsPotPribadi = $("#tablePotPribadi").getGridParam("selectedRowIds");
            $.each(selectedRowsPotPribadi, function(index, value) {
                dataPotPribadi = $("#tablePotPribadi").jqGrid("getLocalRow", value);
                console.log(dataPotPribadi)
                let selectedSisaPP = dataPotPribadi.pinjPribadi_sisa
                let selectedNominalPP = (dataPotPribadi.nominalPP == undefined) ? 0 : dataPotPribadi.nominalPP;

                data.push({
                    name: 'nominalPP[]',
                    value: (isNaN(selectedNominalPP)) ? parseFloat(selectedNominalPP.replaceAll(',', '')) : selectedNominalPP
                })
                data.push({
                    name: 'pinjPribadi_sisa[]',
                    value: selectedSisaPP
                })
                data.push({
                    name: 'pinjPribadi_keterangan[]',
                    value: dataPotPribadi.pinjPribadi_keterangan
                })
                data.push({
                    name: 'pinjPribadi_nobukti[]',
                    value: dataPotPribadi.pinjPribadi_nobukti
                })
                data.push({
                    name: 'pinjPribadi[]',
                    value: dataPotPribadi.id
                })
            });

            data.push({
                name: 'statusjeniskendaraan',
                value: form.find(`[name="statusjeniskendaraan"]`).val()
            })
            data.push({
                name: 'button',
                value: button
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
                name: 'info',
                value: info
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
            data.push({
                name: 'aksi',
                value: action.toUpperCase()
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
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

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
                    clearSelectedRowsAbsensi()

                    if (button == 'btnSubmit') {
                        id = response.data.id
                        $('#crudModal').find('#crudForm').trigger('reset')
                        $('#crudModal').modal('hide')

                        $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
                        $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
                        $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page,
                            postData: {
                                proses: 'reload',
                                tgldari: dateFormat(response.data.tgldariheader),
                                tglsampai: dateFormat(response.data.tglsampaiheader)
                            }
                        }).trigger('reloadGrid');

                        if (id == 0) {
                            $('#detail').jqGrid().trigger('reloadGrid')
                        }
                        if (response.data.grp == 'FORMAT') {
                            updateFormat(response.data)
                        }
                    } else {

                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        showSuccessDialog(response.message, response.data.nobukti)
                        createGajiSupirHeader(true)
                        $('#crudForm').find('input[type="text"]').data('current-value', '')
                        $('#crudForm').find('[name=tglbukti]').val(dateFormat(response.data.tglbukti)).trigger('change');
                        $("#rekapRincian")[0].p.selectedRowIds = [];
                        $('#rekapRincian').jqGrid("clearGridData");
                        $("#rekapRincian")
                            .jqGrid("setGridParam", {
                                selectedRowIds: []
                            })
                            .trigger("reloadGrid");
                        $('#tableAbsensi').jqGrid("clearGridData");
                        initAutoNumeric($('.footrow').find(`td[aria-describedby="tableAbsensi_absensi_uangjalan"]`).text(0))
                        $("#tablePotPribadi")[0].p.selectedRowIds = [];
                        $('#tablePotPribadi').jqGrid("clearGridData");
                        $("#tablePotPribadi")
                            .jqGrid("setGridParam", {
                                selectedRowIds: []
                            })
                            .trigger("reloadGrid");
                        $("#tablePotSemua")[0].p.selectedRowIds = [];
                        $('#tablePotSemua').jqGrid("clearGridData");
                        $("#tablePotSemua")
                            .jqGrid("setGridParam", {
                                selectedRowIds: []
                            })
                            .trigger("reloadGrid");
                        let nominalDepoEl = `<input type="text" name="nomDeposito" class="form-control text-right">`
                        $('#crudForm').find(`[name="nomDeposito"]`).remove()
                        $('#contNomDepo').append(nominalDepoEl)
                        new AutoNumeric(`#crudForm [name="nomDeposito"]`)
                        let nominalBBMEl = `<input type="text" name="nomBBM" class="form-control text-right">`
                        $('#crudForm').find(`[name="nomBBM"]`).remove()
                        $('#contNomBbm').append(nominalBBMEl)
                        new AutoNumeric(`#crudForm [name="nomBBM"]`)
                        hitung()
                        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotPribadi_nominalPP"]`).text(0))
                        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotSemua_nominalPS"]`).text(0))


                    }
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        errors = error.responseJSON.errors
                        console.log(errors)
                        $(".ui-state-error").removeClass("ui-state-error");
                        $.each(errors, (index, error) => {
                            let indexes = index.split(".");
                            let angka = indexes[1]

                            let element;
                            if (indexes[0] == 'rincian') {
                                return showDialog(error);
                            } else if (indexes[0] == 'nominalPS') {
                                selectedRowsPotSemua = $("#tablePotSemua").getGridParam("selectedRowIds");


                                element = $(`#tablePotSemua tr#${parseInt(selectedRowsPotSemua[angka])}`).find(`td[aria-describedby="tablePotSemua_${indexes[0]}"]`)
                                $(element).addClass("ui-state-error");
                                $(element).attr("title", error[0].toLowerCase())

                            } else if (indexes[0] == 'nominalPP') {
                                selectedRowsPotPribadi = $("#tablePotPribadi").getGridParam("selectedRowIds");
                                console.log(selectedRowsPotPribadi)

                                element = $(`#tablePotPribadi tr#${parseInt(selectedRowsPotPribadi[angka])}`).find(`td[aria-describedby="tablePotPribadi_${indexes[0]}"]`)
                                $(element).addClass("ui-state-error");
                                $(element).attr("title", error[0].toLowerCase())

                            } else {

                                element = form.find(`[name="${indexes[0]}"]`)[0];

                                if ($(element).length > 0 && !$(element).is(":hidden")) {
                                    $(element).addClass("is-invalid");
                                    $(`
                                    <div class="invalid-feedback">
                                    ${error[0].toLowerCase()}
                                    </div>
                                    `).appendTo($(element).parent());
                                } else {
                                    return showDialog(error);
                                }
                            }
                        })
                    } else {
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        }
    })


    $(document).on("change", `[name=tglbukti]`, function(event) {
        $("#tablePotSemua")[0].p.selectedRowIds = [];
        $('#tablePotSemua').jqGrid("clearGridData");
        $("#tablePotSemua")
            .jqGrid("setGridParam", {
                selectedRowIds: []
            })
            .trigger("reloadGrid");
        getDataPotSemua().then((response) => {
            $("#tablePotSemua")[0].p.selectedRowIds = [];
            if ($('#crudForm').data('action') == 'add') {
                selectedRowId = [];
            } else {
                selectedRowId = response.selectedId;
            }
            // setTimeout(() => {

            $("#tablePotSemua")
                .jqGrid("setGridParam", {
                    datatype: "local",
                    data: response.data,
                    originalData: response.data,
                    rowNum: response.data.length,
                    selectedRowIds: selectedRowId
                })
                .trigger("reloadGrid");
            // }, 100);
            setTotalNominalPS()
            hitungSisa()
            setTotalSisaPotSemua()
        });

        if (supirId != '') {
            $("#tablePotPribadi")[0].p.selectedRowIds = [];
            $('#tablePotPribadi').jqGrid("clearGridData");
            $("#tablePotPribadi")
                .jqGrid("setGridParam", {
                    selectedRowIds: []
                })
                .trigger("reloadGrid");
            getDataPotPribadi(supirId).then((response) => {
                if ($('#crudForm').data('action') == 'add') {
                    selectedRowIdPP = [];
                } else {
                    selectedRowIdPP = response.selectedId;
                }
                // setTimeout(() => {

                $("#tablePotPribadi")
                    .jqGrid("setGridParam", {
                        datatype: "local",
                        data: response.data,
                        originalData: response.data,
                        rowNum: response.data.length,
                        selectedRowIds: selectedRowIdPP
                    })
                    .trigger("reloadGrid");
                // }, 100);

                setTotalNominalPP()
                hitungSisa()
                setTotalSisaPotPribadi()
            });
        }
    })
    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        $("#tabs").tabs()
        setFormBindKeys(form)
        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }

        activeGrid = null
        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }

        initSelect2(form.find('.select2bs4'), true)
        getMaxLength(form)
        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        removeEditingBy($('#crudForm').find('[name=id]').val())
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
        selectedRowsAbsensi = []
        selectedRowsAbsensiNobukti = [];
        selectedRowsAbsensiUangjalan = [];
        isReload = false
        $('#crudModal').find('.modal-body').html(modalBody)
        initDatepicker('datepickerIndex')
    })

    function removeEditingBy(id) {
        let formData = new FormData();


        formData.append('id', id);
        formData.append('aksi', 'BATAL');
        formData.append('table', 'gajisupirheader');

        fetch(`{{ config('app.api_url') }}removeedit`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                body: formData,
                keepalive: true

            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                $("#crudModal").modal("hide");
            })
            .catch(error => {
                // Handle error
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON);
                }
            })
    }

    function createGajiSupirHeader(isSaveAdd = false) {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)

        form.data('action', 'add')
        $('#crudModalTitle').text('Add Rincian Gaji Supir')

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#detailLainnya').html('')

        rekapRincian()
        detailLainnya()
        initDatepicker()
        setGajiSupir()
        form.find(`[name="subtotal"]`).addClass('disabled')
        if (!isSaveAdd) {
            initAutoNumeric($('#crudForm').find('[name=nomDeposito]'))
            initAutoNumeric($('#crudForm').find('[name=nomBBM]'))
        }
        initAutoNumeric($('#crudForm').find('[name=nomPinjaman]'))
        initAutoNumeric($('#crudForm').find('[name=uangmakanharian]'))
        initAutoNumeric($('#crudForm').find('[name=biayaextraheader]'))

        loadPotSemuaGrid()
        loadPotPribadiGrid()
        loadUangJalan()
        Promise
            .all([
                setStatusJenisKendaraanOptions(form),
                isTangki()
            ])
            .then(() => {
                showDefault(form)
                    .then(() => {
                        if (isJenisTangki != 'YA') {
                            $('.statusjeniskendaraan').hide()
                            $('.biayaextraheader').hide()
                            $('.keteranganextraheader').hide()
                        }
                        if (selectedRowsIndex.length > 0) {
                            clearSelectedRowsIndex()
                        }
                        if (jenisTambahan == 'RITASI') {
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nominal`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_keterangan`);
                        } else {
                            $("#rekapRincian").jqGrid("hideCol", `ritasi_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `upahritasi`);
                            $("#rekapRincian").jqGrid("hideCol", `statusritasi`);
                        }
                        $('#crudModal').modal('show')
                        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                        $('#crudForm').find('[name=tglbuktiDeposito]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                        $('#crudForm').find('[name=tglbuktiBBM]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                        $('#crudForm').find('[name=tglbuktiPinjaman]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
                        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

                    }).catch((error) => {
                        showDialog(error.responseJSON)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })

    }

    function editGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        $('#crudModalTitle').text('Edit Rincian Gaji Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusJenisKendaraanOptions(form),
                isTangki()
            ])
            .then(() => {
                showGajiSupir(form, Id, 'edit')
                    .then(() => {

                        if (selectedRowsIndex.length > 0) {
                            clearSelectedRowsIndex()
                        }
                        if (jenisTambahan == 'RITASI') {
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nominal`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_keterangan`);
                        } else {
                            $("#rekapRincian").jqGrid("hideCol", `ritasi_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `upahritasi`);
                            $("#rekapRincian").jqGrid("hideCol", `statusritasi`);
                        }
                        $('#crudModal').modal('show')
                        // form.find(`[name="tglbukti"]`).prop('readonly', true)
                        // form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                        if (isJenisTangki != 'YA') {
                            $('.statusjeniskendaraan').hide()
                            $('.biayaextraheader').hide()
                            $('.keteranganextraheader').hide()
                        }
                        form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
                        form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
                    }).catch((error) => {
                        showDialog(error.responseJSON)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })

    }

    function deleteGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        $('#crudModalTitle').text('Delete Rincian Gaji Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        form.find('#btnTampil').prop('disabled', true)
        Promise
            .all([
                setStatusJenisKendaraanOptions(form),
                isTangki()
            ])
            .then(() => {
                showGajiSupir(form, Id, 'delete')
                    .then(() => {
                        if (selectedRowsIndex.length > 0) {
                            clearSelectedRowsIndex()
                        }
                        if (jenisTambahan == 'RITASI') {
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nominal`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_keterangan`);
                        } else {
                            $("#rekapRincian").jqGrid("hideCol", `ritasi_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `upahritasi`);
                            $("#rekapRincian").jqGrid("hideCol", `statusritasi`);
                        }
                        if (isJenisTangki != 'YA') {
                            $('.statusjeniskendaraan').hide()
                            $('.biayaextraheader').hide()
                            $('.keteranganextraheader').hide()
                        }
                        $('#crudModal').modal('show')
                        form.find(`[name="tglbukti"]`).prop('readonly', true)
                        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                        form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
                        form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
                    })
                    .catch((error) => {
                        showDialog(error.responseJSON)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function viewGajiSupirHeader(Id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
          <i class="fa fa-save"></i>
          Save
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Rincian Gaji Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        form.find('#btnTampil').prop('disabled', true)
        Promise
            .all([
                setStatusJenisKendaraanOptions(form),
                isTangki()
            ])
            .then(() => {
                showGajiSupir(form, Id, 'delete')
                    .then(() => {

                        if (selectedRowsIndex.length > 0) {
                            clearSelectedRowsIndex()
                        }
                        if (jenisTambahan == 'RITASI') {
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_nominal`);
                            $("#rekapRincian").jqGrid("hideCol", `biayaextrasupir_keterangan`);
                        } else {
                            $("#rekapRincian").jqGrid("hideCol", `ritasi_nobukti`);
                            $("#rekapRincian").jqGrid("hideCol", `upahritasi`);
                            $("#rekapRincian").jqGrid("hideCol", `statusritasi`);
                        }
                        if (isJenisTangki != 'YA') {
                            $('.statusjeniskendaraan').hide()
                            $('.biayaextraheader').hide()
                            $('.keteranganextraheader').hide()
                        }
                        $('#crudModal').modal('show')
                        form.find(`[name="tglbukti"]`).prop('readonly', true)
                        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                        form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
                        form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
                    })
                    .catch((error) => {
                        showDialog(error.responseJSON)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })

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
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'PRINTER') {
                        window.open(`{{ route('gajisupirheader.report') }}?id=${Id}`)
                    } else {
                        cekValidasiAksi(Id, Aksi)
                    }
                }
            }
        })
    }

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}gajisupirheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        // let element = form.find(`[name="statusaktif"]`)

                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                    })
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusJenisKendaraanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusjeniskendaraan]').empty()
            relatedForm.find('[name=statusjeniskendaraan]').append(
                new Option('-- PILIH STATUS JENIS KENDARAAN --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS JENIS KENDARAAN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusJenisKendaraan => {
                        let option = new Option(statusJenisKendaraan.text, statusJenisKendaraan.id)
                        relatedForm.find('[name=statusjeniskendaraan]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function setGajiSupir() {
        let data = [];
        data.push({
            name: 'grp',
            value: 'PENDAPATAN SUPIR'
        })
        data.push({
            name: 'subgrp',
            value: 'GAJI KENEK'
        })
        $.ajax({
            url: `${apiUrl}parameter/getparamfirst`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {
                komisiGajiKenek = response.text
                console.log('reposn ', response)
            },
            error: error => {
                console.log('error ', error);
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            }
        })
    }
    const setTampilan = function(relatedForm) {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'PENDAPATAN SUPIR'
            })
            data.push({
                name: 'text',
                value: 'GAJI KENEK'
            })
            $.ajax({
                url: `${apiUrl}parameter/getparamfirst`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    memo = JSON.parse(response.memo)
                    memo = memo.INPUT
                    if (memo != '') {
                        input = memo.split(',');
                        input.forEach(field => {
                            field = $.trim(field.toLowerCase());
                            $(`.${field}`).hide()
                        });
                    }
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }
    const isTangki = function(relatedForm) {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'ABSENSI TANGKI'
            })
            data.push({
                name: 'subgrp',
                value: 'ABSENSI TANGKI'
            })
            $.ajax({
                url: `${apiUrl}parameter/getparamfirst`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    isJenisTangki = response.text
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
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
                var error = response.error
                if (error) {
                    showDialog(response)
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

    function loadPotSemuaGrid() {
        $("#tablePotSemua")
            .jqGrid({
                datatype: 'local',
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: "",
                        name: "",
                        width: 40,
                        formatter: 'checkbox',
                        search: false,
                        editable: false,
                        formatter: function(value, rowOptions, rowData) {
                            let disabled = '';
                            if ($('#crudForm').data('action') == 'delete') {
                                disabled = 'disabled'
                            }
                            return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxPotSemuaHandler(this, ${rowData.id})">`;
                        },
                    },
                    {
                        label: "id",
                        name: "id",
                        hidden: true,
                        search: false,
                    },
                    {
                        label: "SUPIR",
                        name: "pinjSemua_supir",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        sortable: true,
                    },
                    {
                        label: "no bukti pinjaman",
                        name: "pinjSemua_nobukti",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        sortable: true,
                    },
                    {
                        label: "tgl bukti pinjaman",
                        name: "pinjSemua_tglbukti",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        sortable: true,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: "SISA",
                        name: "pinjSemua_sisa",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        sortable: true,
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "NOMINAL",
                        name: "nominalPS",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: "right",
                        editable: true,
                        editoptions: {
                            dataInit: function(element, id) {
                                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
                            },
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {
                                    let originalGridDataPotSemua = $("#tablePotSemua")
                                        .jqGrid("getGridParam", "originalData")
                                        .find((row) => row.id == rowObject.rowId);

                                    let localRow = $("#tablePotSemua").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    let totalSisaPinjSemua
                                    localRow.nominalPS = event.target.value;
                                    let nominalPS = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                                    if ($('#crudForm').data('action') == 'edit') {
                                        totalSisaPinjSemua = (parseFloat(originalGridDataPotSemua.pinjSemua_sisa) + parseFloat(originalGridDataPotSemua.nominalPS)) - nominalPS
                                    } else {
                                        totalSisaPinjSemua = originalGridDataPotSemua.pinjSemua_sisa - nominalPS
                                    }

                                    $("#tablePotSemua").jqGrid(
                                        "setCell",
                                        rowObject.rowId,
                                        "pinjSemua_sisa",
                                        totalSisaPinjSemua
                                    );

                                    if (totalSisaPinjSemua < 0) {
                                        showDialog('sisa tidak boleh minus')
                                        $("#tablePotSemua").jqGrid(
                                            "setCell",
                                            rowObject.rowId,
                                            "nominalPS",
                                            0
                                        );
                                        if (originalGridDataPotSemua.pinjSemua_sisa == 0) {
                                            $("#tablePotSemua").jqGrid("setCell", rowObject.rowId, "pinjSemua_sisa", (parseFloat(originalGridDataPotSemua.pinjSemua_sisa) + parseFloat(originalGridDataPotSemua.nominalPS)));
                                        } else {
                                            $("#tablePotSemua").jqGrid("setCell", rowObject.rowId, "pinjSemua_sisa", originalGridDataPotSemua.pinjSemua_sisa);
                                        }
                                    }
                                    // nominalPSDetails = $(`#tablePotSemua tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePotSemua_nominalPS"]`)
                                    // ttlNominalPS = 0
                                    // $.each(nominalPSDetails, (index, nominalPSDetail) => {
                                    //     ttlNominalPSDetail = parseFloat($(nominalPSDetail).attr('title').replaceAll(',', ''))
                                    //     ttlNominalPSs = (isNaN(ttlNominalPSDetail)) ? 0 : ttlNominalPSDetail;
                                    //     ttlNominalPS += ttlNominalPSs
                                    // });
                                    // ttlNominalPS += nominalPS
                                    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotSemua_nominalPS"]`).text(ttlNominalPS))

                                    // initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjamansemua"]`).val(ttlNominalPS))
                                    setTotalNominalPS()
                                    hitungSisa()
                                    setTotalSisaPotSemua()
                                },
                            }, ],
                        },
                        sortable: false,
                        sorttype: "int",
                    },
                    {
                        label: "KETERANGAN",
                        name: "pinjSemua_keterangan",
                        width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
                        sortable: false,
                        editable: false,
                        width: 500
                    },
                    {
                        label: "empty",
                        name: "empty",
                        hidden: true,
                        search: false,
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 400,
                rownumbers: true,
                rownumWidth: 45,
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                pgbuttons: false,
                pginput: false,
                cellEdit: true,
                cellsubmit: "clientArray",
                editableColumns: ["nominalPS"],
                selectedRowIds: [],
                afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
                    let originalGridDataPotSemua = $("#tablePotSemua")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);

                    let localRow = $("#tablePotSemua").jqGrid("getLocalRow", rowId);

                    let getBayar = $("#tablePotSemua").jqGrid("getCell", rowId, "nominalPS")
                    let nominalPS = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

                    potSemuaSisa = 0
                    if ($('#crudForm').data('action') == 'edit') {
                        potSemuaSisa = (parseFloat(originalGridDataPotSemua.pinjSemua_sisa) + parseFloat(originalGridDataPotSemua.nominalPS)) - parseFloat(nominalPS)
                    } else {
                        potSemuaSisa = parseFloat(originalGridDataPotSemua.pinjSemua_sisa) - parseFloat(nominalPS)
                    }
                    if (indexColumn == 7) {

                        $("#tablePotSemua").jqGrid(
                            "setCell",
                            rowId,
                            "pinjSemua_sisa",
                            potSemuaSisa
                            // sisa - nominal - potongan
                        );
                    }
                    // setTotalNominal()
                    setTotalNominalPS()
                    setTotalSisaPotSemua()
                },
                isCellEditable: function(cellname, iRow, iCol) {
                    let rowData = $(this).jqGrid("getRowData")[iRow - 1];
                    if ($('#crudForm').data('action') != 'delete') {
                        return $(this)
                            .find(`tr input[value=${rowData.id}]`)
                            .is(":checked");
                    }
                },
                validationCell: function(cellobject, errormsg, iRow, iCol) {
                    console.log(cellobject);
                    console.log(errormsg);
                    console.log(iRow);
                    console.log(iCol);
                },
                loadComplete: function() {
                    setTimeout(() => {
                        $(this)
                            .getGridParam("selectedRowIds")
                            .forEach((selectedRowId) => {
                                $(this)
                                    .find(`tr input[value=${selectedRowId}]`)
                                    .prop("checked", true);
                                initAutoNumeric($(this).find(`td[aria-describedby="tablePotSemua_nominalPS"]`))
                            });
                    }, 100);
                    // setTotalNominal()
                    setTotalNominalPS()
                    setTotalSisaPotSemua()
                    setHighlight($(this))
                },
            })
            .jqGrid("setLabel", "rn", "No.")
            .jqGrid("navGrid", "#tablePager", {
                add: false,
                edit: false,
                del: false,
                refresh: false,
                search: false,
            })
            .jqGrid("filterToolbar", {
                searchOnEnter: false,
            })
            .jqGrid("excelLikeGrid", {
                beforeDeleteCell: function(rowId, iRow, iCol, event) {
                    let localRow = $("#tablePotSemua").jqGrid("getLocalRow", rowId);
                    let originalGridData = $("#tablePotSemua")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);
                    let totalSisa
                    if ($('#crudForm').data('action') == 'edit') {

                        totalSisa = (parseFloat(originalGridData.pinjSemua_sisa) + parseFloat(originalGridData.nominalPS))
                    } else {
                        totalSisa = parseFloat(originalGridData.pinjSemua_sisa)
                    }
                    $("#tablePotSemua").jqGrid(
                        "setCell",
                        rowId,
                        "pinjSemua_sisa",
                        totalSisa
                    );

                    return true;
                },
            });
        /* Append clear filter button */
        loadClearFilter($('#tablePotSemua'))

        /* Append global search */
        // loadGlobalSearch($('#tablePotSemua'))
    }

    function getDataPotSemua(id) {
        aksi = $('#crudForm').data('action')
        if (aksi == 'edit') {
            id = $(`#crudForm`).find(`[name="id"]`).val()

            urlPotSemua = `${apiUrl}gajisupirheader/${id}/edit/editpinjsemua`

        } else if (aksi == 'delete' || aksi == 'view') {
            urlPotSemua = `${apiUrl}gajisupirheader/${id}/delete/editpinjsemua`
            attribut = 'disabled'
            forCheckbox = 'disabled'
        } else if (aksi == 'add') {
            urlPotSemua = `${apiUrl}gajisupirheader/getpinjsemua`
        }
        return new Promise((resolve, reject) => {
            $.ajax({
                url: urlPotSemua,
                dataType: "JSON",
                data: {
                    tglbukti: $('#crudForm').find('[name=tglbukti]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    if (aksi != 'add') {
                        let selectedIdPS = []
                        let totalPS = 0

                        $.each(response.data, (index, value) => {
                            if (value.gajisupir_id != null) {
                                selectedIdPS.push(parseInt(value.id))
                                totalPS += parseFloat(value.nominalPS)

                            }
                        })
                        response.selectedId = selectedIdPS;
                        response.totalPS = totalPS;

                    }
                    resolve(response);
                },
                error: error => {
                    reject(error)
                }
            });
        });
    }

    function checkboxPotSemuaHandler(element, rowId) {

        let isChecked = $(element).is(":checked");
        let editableColumnsPotSemua = $("#tablePotSemua").getGridParam("editableColumns");
        let selectedRowIdsPotSemua = $("#tablePotSemua").getGridParam("selectedRowIds");
        console.log(selectedRowIdsPotSemua)
        let originalGridDataPotSemua = $("#tablePotSemua")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

        editableColumnsPotSemua.forEach((editableColumn) => {

            if (!isChecked) {
                for (var i = 0; i < selectedRowIdsPotSemua.length; i++) {
                    if (selectedRowIdsPotSemua[i] == rowId) {
                        selectedRowIdsPotSemua.splice(i, 1);
                    }
                }
                sisa = 0
                if ($('#crudForm').data('action') == 'edit') {
                    sisa = (parseFloat(originalGridDataPotSemua.pinjSemua_sisa) + parseFloat(originalGridDataPotSemua.nominalPS))
                } else {
                    sisa = originalGridDataPotSemua.pinjSemua_sisa
                }

                $("#tablePotSemua").jqGrid(
                    "setCell",
                    rowId,
                    "pinjSemua_sisa",
                    sisa
                );

                $("#tablePotSemua").jqGrid("setCell", rowId, "nominalPS", 0);
                setTotalNominalPS()
                setTotalSisaPotSemua()
            } else {
                selectedRowIdsPotSemua.push(rowId);

                let localRow = $("#tablePotSemua").jqGrid("getLocalRow", rowId);

                // if ($('#crudForm').data('action') == 'edit') {
                //     // if (originalGridDataPotSemua.sisa == 0) {

                //     //   let getnominalPS = $("#tablePotSemua").jqGrid("getCell", rowId, "nominalPS")
                //     //   localRow.nominalPS = (getnominalPS != '') ? parseFloat(getnominalPS.replaceAll(',', '')) : 0
                //     // } else {
                //     //   localRow.nominalPS = originalGridDataPotSemua.sisa
                //     // }
                //     localRow.nominalPS = (parseFloat(originalGridDataPotSemua.pinjSemua_sisa) + parseFloat(originalGridDataPotSemua.nominalPS))
                // }

                initAutoNumeric($(`#tablePotSemua tr#${rowId}`).find(`td[aria-describedby="tablePotSemua_nominalPS"]`))
                setTotalNominalPS()
                setTotalSisaPotSemua()
            }
        });

        $("#tablePotSemua").jqGrid("setGridParam", {
            selectedRowIds: selectedRowIdsPotSemua,
        });

    }

    $(document).on('click', '#resetdatafilter_tablePotSemua', function(event) {
        selectedRowsPengembalian = $("#tablePotSemua").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tablePotSemua').jqGrid('saveCell', value, 9); //emptycell
            $('#tablePotSemua').jqGrid('saveCell', value, 7); //nominal
        })

    });
    $(document).on('click', '#gbox_tablePotSemua .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
        selectedRowsPengembalian = $("#tablePotSemua").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tablePotSemua').jqGrid('saveCell', value, 9); //emptycell
            $('#tablePotSemua').jqGrid('saveCell', value, 7); //nominal
        })
    })

    function setTotalSisaPotSemua() {
        let pinjSemua_sisaDetails = $(`#tablePotSemua`).find(`td[aria-describedby="tablePotSemua_pinjSemua_sisa"]`)
        let pinjSemua_sisa = 0

        let originalData = $("#tablePotSemua").getGridParam("data");
        $.each(originalData, function(index, value) {
            sisas = value.pinjSemua_sisa;
            pinjSemua_sisas = (isNaN(sisas)) ? parseFloat(sisas.replaceAll(',', '')) : parseFloat(sisas)
            pinjSemua_sisa += pinjSemua_sisas

        })
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotSemua_pinjSemua_sisa"]`).text(pinjSemua_sisa))
    }

    function setTotalNominalPS() {
        let nominalPSDetails = $(`#tablePotSemua`).find(`td[aria-describedby="tablePotSemua_nominalPS"]`)
        let nominalPS = 0

        selectedRowsPinjaman = $("#tablePotSemua").getGridParam("selectedRowIds");
        $.each(selectedRowsPinjaman, function(index, value) {
            dataPinjaman = $("#tablePotSemua").jqGrid("getLocalRow", value);
            nominals = (dataPinjaman.nominalPS == undefined || dataPinjaman.nominalPS == '') ? 0 : dataPinjaman.nominalPS;
            getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
            nominalPS = nominalPS + getNominal
        })
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotSemua_nominalPS"]`).text(nominalPS))
        initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjamansemua"]`).val(nominalPS))
        hitungSisa()
    }

    function loadPotPribadiGrid() {
        $("#tablePotPribadi")
            .jqGrid({
                datatype: 'local',
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                colModel: [{
                        label: "",
                        name: "",
                        width: 40,
                        formatter: 'checkbox',
                        search: false,
                        editable: false,
                        formatter: function(value, rowOptions, rowData) {
                            let disabled = '';
                            if ($('#crudForm').data('action') == 'delete') {
                                disabled = 'disabled'
                            }
                            return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxPotPribadiHandler(this, ${rowData.id})">`;
                        },
                    },
                    {
                        label: "id",
                        name: "id",
                        hidden: true,
                        search: false,
                    },
                    {
                        label: "no bukti pinjaman",
                        name: "pinjPribadi_nobukti",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        sortable: true,
                    },
                    {
                        label: "tgl bukti pinjaman",
                        name: "pinjPribadi_tglbukti",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        sortable: true,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: "SISA",
                        name: "pinjPribadi_sisa",
                        sortable: true,
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "NOMINAL",
                        name: "nominalPP",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: "right",
                        editable: true,
                        editoptions: {
                            dataInit: function(element, id) {
                                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
                            },
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {
                                    let originalGridDataPotPribadi = $("#tablePotPribadi")
                                        .jqGrid("getGridParam", "originalData")
                                        .find((row) => row.id == rowObject.rowId);

                                    let localRow = $("#tablePotPribadi").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    let totalSisaPinjPribadi
                                    localRow.nominalPP = event.target.value;
                                    let nominalPP = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                                    if ($('#crudForm').data('action') == 'edit') {
                                        totalSisaPinjPribadi = (parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) + parseFloat(originalGridDataPotPribadi.nominalPP)) - nominalPP
                                    } else {
                                        totalSisaPinjPribadi = originalGridDataPotPribadi.pinjPribadi_sisa - nominalPP
                                    }

                                    $("#tablePotPribadi").jqGrid(
                                        "setCell",
                                        rowObject.rowId,
                                        "pinjPribadi_sisa",
                                        totalSisaPinjPribadi
                                    );

                                    if (totalSisaPinjPribadi < 0) {
                                        showDialog('sisa tidak boleh minus')
                                        $("#tablePotPribadi").jqGrid(
                                            "setCell",
                                            rowObject.rowId,
                                            "nominalPP",
                                            0
                                        );
                                        if (originalGridDataPotPribadi.pinjPribadi_sisa == 0) {
                                            $("#tablePotPribadi").jqGrid("setCell", rowObject.rowId, "pinjPribadi_sisa", (parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) + parseFloat(originalGridDataPotPribadi.nominalPP)));
                                        } else {
                                            $("#tablePotPribadi").jqGrid("setCell", rowObject.rowId, "pinjPribadi_sisa", originalGridDataPotPribadi.pinjPribadi_sisa);
                                        }
                                    }

                                    setTotalNominalPP()
                                    hitungSisa()
                                    setTotalSisaPotPribadi()
                                },
                            }, ],
                        },
                        sortable: false,
                        sorttype: "int",
                    },
                    {
                        label: "KETERANGAN",
                        name: "pinjPribadi_keterangan",
                        width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
                        sortable: false,
                        editable: false,
                        width: 500
                    },
                    {
                        label: "empty",
                        name: "empty",
                        hidden: true,
                        search: false,
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 400,
                rownumbers: true,
                rownumWidth: 45,
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                pgbuttons: false,
                pginput: false,
                cellEdit: true,
                cellsubmit: "clientArray",
                editableColumns: ["nominalPP"],
                selectedRowIds: [],
                afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
                    let originalGridDataPotPribadi = $("#tablePotPribadi")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);

                    let getBayarPP = $("#tablePotPribadi").jqGrid("getCell", rowId, "nominalPP")
                    let nominalPP = (getBayarPP != '') ? parseFloat(getBayarPP.replaceAll(',', '')) : 0

                    potPribadiSisa = 0
                    if ($('#crudForm').data('action') == 'edit') {
                        potPribadiSisa = (parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) + parseFloat(originalGridDataPotPribadi.nominalPP)) - nominalPP
                    } else {
                        potPribadiSisa = parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) - nominalPP
                    }
                    console.log(indexColumn)
                    if (indexColumn == 6) {

                        $("#tablePotPribadi").jqGrid(
                            "setCell",
                            rowId,
                            "pinjPribadi_sisa",
                            potPribadiSisa
                            // sisa - nominal - potongan
                        );
                    }
                    // setTotalNominal()
                    setTotalSisaPotPribadi()
                },
                isCellEditable: function(cellname, iRow, iCol) {
                    let rowData = $(this).jqGrid("getRowData")[iRow - 1];

                    return $(this)
                        .find(`tr input[value=${rowData.id}]`)
                        .is(":checked");
                },
                validationCell: function(cellobject, errormsg, iRow, iCol) {
                    console.log(cellobject);
                    console.log(errormsg);
                    console.log(iRow);
                    console.log(iCol);
                },
                loadComplete: function() {
                    setTimeout(() => {
                        $(this)
                            .getGridParam("selectedRowIds")
                            .forEach((selectedRowId) => {
                                $(this)
                                    .find(`tr input[value=${selectedRowId}]`)
                                    .prop("checked", true);
                                initAutoNumeric($(this).find(`td[aria-describedby="tablePotPribadi_nominalPP"]`))
                            });
                    }, 100);
                    setTotalNominalPP()
                    setTotalSisaPotPribadi()
                    setHighlight($(this))
                },
            })
            .jqGrid("setLabel", "rn", "No.")
            .jqGrid("navGrid", "#tablePager", {
                add: false,
                edit: false,
                del: false,
                refresh: false,
                search: false,
            })
            .jqGrid("filterToolbar", {
                searchOnEnter: false,
            })
            .jqGrid("excelLikeGrid", {
                beforeDeleteCell: function(rowId, iRow, iCol, event) {
                    let localRow = $("#tablePotPribadi").jqGrid("getLocalRow", rowId);

                    let originalGridData = $("#tablePotPribadi")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);
                    let totalSisa
                    if ($('#crudForm').data('action') == 'edit') {

                        totalSisa = (parseFloat(originalGridData.pinjPribadi_sisa) + parseFloat(originalGridData.nominalPP))
                    } else {
                        totalSisa = parseFloat(originalGridData.pinjPribadi_sisa)
                    }
                    $("#tablePotPribadi").jqGrid(
                        "setCell",
                        rowId,
                        "pinjPribadi_sisa",
                        totalSisa
                    );

                    return true;
                },
            });
        /* Append clear filter button */
        loadClearFilter($('#tablePotPribadi'))

        /* Append global search */
        // loadGlobalSearch($('#tablePotPribadi'))
    }

    function getDataPotPribadi(supirId, id) {
        aksi = $('#crudForm').data('action')
        if (aksi == 'edit') {
            id = $(`#crudForm`).find(`[name="id"]`).val()
            urlPotPribadi = `${apiUrl}gajisupirheader/${id}/${supirId}/edit/editpinjpribadi`

        } else if (aksi == 'delete' || aksi == 'view') {
            urlPotPribadi = `${apiUrl}gajisupirheader/${id}/${supirId}/delete/editpinjpribadi`
            attribut = 'disabled'
            forCheckbox = 'disabled'
        } else if (aksi == 'add') {
            urlPotPribadi = `${apiUrl}gajisupirheader/${supirId}/getpinjpribadi`
        }
        return new Promise((resolve, reject) => {
            $.ajax({
                url: urlPotPribadi,
                dataType: "JSON",
                data: {
                    tglbukti: $('#crudForm').find('[name=tglbukti]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    if (aksi != 'add') {
                        let selectedIdPP = []
                        let totalPP = 0

                        $.each(response.data, (index, value) => {
                            if (value.gajisupir_id != null) {
                                selectedIdPP.push(parseInt(value.id))
                                totalPP += parseFloat(value.nominalPP)

                            }
                        })
                        response.selectedId = selectedIdPP;
                        response.totalPP = totalPP;
                    }
                    resolve(response);
                },
                error: error => {
                    reject(error)
                }
            });
        });
    }

    function checkboxPotPribadiHandler(element, rowId) {

        let isChecked = $(element).is(":checked");
        let editableColumnsPotPribadi = $("#tablePotPribadi").getGridParam("editableColumns");
        let selectedRowIdsPotPribadi = $("#tablePotPribadi").getGridParam("selectedRowIds");
        let originalGridDataPotPribadi = $("#tablePotPribadi")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

        editableColumnsPotPribadi.forEach((editableColumn) => {

            if (!isChecked) {
                for (var i = 0; i < selectedRowIdsPotPribadi.length; i++) {
                    if (selectedRowIdsPotPribadi[i] == rowId) {
                        selectedRowIdsPotPribadi.splice(i, 1);
                    }
                }
                sisaPribadi = 0
                if ($('#crudForm').data('action') == 'edit') {
                    sisaPribadi = (parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) + parseFloat(originalGridDataPotPribadi.nominalPP))
                } else {
                    sisaPribadi = originalGridDataPotPribadi.pinjPribadi_sisa
                }

                $("#tablePotPribadi").jqGrid(
                    "setCell",
                    rowId,
                    "pinjPribadi_sisa",
                    sisaPribadi
                );

                $("#tablePotPribadi").jqGrid("setCell", rowId, "nominalPP", 0);
                setTotalNominalPP()
                setTotalSisaPotPribadi()
            } else {
                selectedRowIdsPotPribadi.push(rowId);

                let localRow = $("#tablePotPribadi").jqGrid("getLocalRow", rowId);

                // if ($('#crudForm').data('action') == 'edit') {
                //     // if (originalGridDataPotPribadi.sisa == 0) {

                //     //   let getnominalPP = $("#tablePotPribadi").jqGrid("getCell", rowId, "nominalPP")
                //     //   localRow.nominalPP = (getnominalPP != '') ? parseFloat(getnominalPP.replaceAll(',', '')) : 0
                //     // } else {
                //     //   localRow.nominalPP = originalGridDataPotPribadi.sisa
                //     // }
                //     localRow.nominalPP = (parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) + parseFloat(originalGridDataPotPribadi.nominalPP))
                // }

                initAutoNumeric($(`#tablePotPribadi tr#${rowId}`).find(`td[aria-describedby="tablePotPribadi_nominalPP"]`))
                setTotalNominalPP()
                setTotalSisaPotPribadi()
            }
        });

        $("#tablePotPribadi").jqGrid("setGridParam", {
            selectedRowIds: selectedRowIdsPotPribadi,
        });

    }

    $(document).on('click', '#resetdatafilter_tablePotPribadi', function(event) {
        selectedRowsPengembalian = $("#tablePotPribadi").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tablePotPribadi').jqGrid('saveCell', value, 7); //emptycell
            $('#tablePotPribadi').jqGrid('saveCell', value, 5); //nominal
        })

    });
    $(document).on('click', '#gbox_tablePotPribadi .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
        selectedRowsPengembalian = $("#tablePotPribadi").getGridParam("selectedRowIds");
        $.each(selectedRowsPengembalian, function(index, value) {
            $('#tablePotPribadi').jqGrid('saveCell', value, 7); //emptycell
            $('#tablePotPribadi').jqGrid('saveCell', value, 5); //nominal
        })
    })

    function setTotalSisaPotPribadi() {
        let pinjPribadi_sisaDetails = $(`#tablePotPribadi`).find(`td[aria-describedby="tablePotPribadi_pinjPribadi_sisa"]`)
        let pinjPribadi_sisa = 0
        let originalData = $("#tablePotPribadi").getGridParam("data");
        $.each(originalData, function(index, value) {
            pinjPribadi_sisas = value.pinjPribadi_sisa;
            pinjPribadi_sisas = (isNaN(pinjPribadi_sisas)) ? parseFloat(pinjPribadi_sisas.replaceAll(',', '')) : parseFloat(pinjPribadi_sisas)
            pinjPribadi_sisa += pinjPribadi_sisas

        })
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotPribadi_pinjPribadi_sisa"]`).text(pinjPribadi_sisa))
    }

    function setTotalNominalPP() {
        console.log('hitungtotalnominal');
        let nominalPPDetails = $(`#tablePotPribadi`).find(`td[aria-describedby="tablePotPribadi_nominalPP"]`)
        let nominalPP = 0
        selectedRowsPribadi = $("#tablePotPribadi").getGridParam("selectedRowIds");
        $.each(selectedRowsPribadi, function(index, value) {
            dataPinjaman = $("#tablePotPribadi").jqGrid("getLocalRow", value);
            console.log('dataPinjaman ', dataPinjaman)
            nominals = (dataPinjaman.nominalPP == undefined || dataPinjaman.nominalPP == '') ? 0 : dataPinjaman.nominalPP;
            getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
            nominalPP = nominalPP + getNominal
        })
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotPribadi_nominalPP"]`).text(nominalPP))
        initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjaman"]`).val(nominalPP))
        hitungSisa()
    }

    function loadUangJalan() {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }
        $("#tableAbsensi").jqGrid({
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
                colModel: [{
                        label: '',
                        name: '',
                        width: 40,
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
                                $(element).attr('id', 'gsUangjalan')
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                $(element).addClass('checkbox-selectall')
                                if (disabled == '') {
                                    $(element).on('click', function() {
                                        $(element).attr('disabled', true)
                                        if ($(this).is(':checked')) {
                                            selectAllRowsAbsensi(supirId, dari, sampai, aksi)
                                        } else {
                                            clearSelectedRowsAbsensi()
                                        }
                                    })
                                } else {
                                    $(element).attr('disabled', true)
                                }

                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" class="checkbox-jqgrid" name="absensiId[]" value="${rowData.absensi_id}" ${disabled} onchange="checkboxAbsensiHandler(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'absensi_id',
                        align: 'right',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'absensi_nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'absensi_tglbukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'UANG JALAN',
                        name: 'absensi_uangjalan',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'TRADO',
                        name: 'absensi_trado',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                    },
                    {
                        label: 'TRADO ID',
                        name: 'absensi_tradoid',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        hidden: true,
                        search: false
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
                sortname: sortnameAbsensi,
                sortorder: sortorderAbsensi,
                page: pageAbsensi,
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
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
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

                    /* Set global variables */
                    sortnameAbsensi = $(this).jqGrid("getGridParam", "sortname")
                    sortorderAbsensi = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordAbsensi = $(this).getGridParam("records")
                    limitAbsensi = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataAbsensi = $(this).jqGrid('getGridParam', 'postData')
                    triggerClickAbsensi = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowAbsensi > $(this).getDataIDs().length - 1) {
                        indexRowAbsensi = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    $.each(selectedRowsAbsensi, function(key, value) {
                        $(grid).find('tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).addClass('bg-light-blue')
                                $(this).find(`td input:checkbox`).prop('checked', true)

                                if ($('#crudForm').data('action') == 'edit') {
                                    if (isReload) {
                                        $(this).find(`td input:checkbox`).prop("disabled", false);
                                    } else {
                                        $(this).find(`td input:checkbox`).prop("disabled", true);
                                    }
                                }
                            }
                        })
                    });
                    if ($('#crudForm').data('action') == 'add') {
                        $('#gsUangjalan').attr('disabled', false)
                    }
                    if ($('#crudForm').data('action') == 'edit') {
                        if (isReload) {
                            $('#gsUangjalan').attr('disabled', false)
                        } else {
                            $('#gsUangjalan').attr('disabled', true)
                        }
                    }
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
                    clearGlobalSearch($('#tableAbsensi'))
                },
                afterSearch: function() {
                    console.log($(this).getGridParam())
                }
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#tableAbsensi'))

        /* Append global search */
        loadGlobalSearch($('#tableAbsensi'))
    }

    function hitungSisa() {
        // hitung sisa
        let subtotal = ($(`#crudForm [name="subtotal"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="subtotal"]`)[0]);
        let uangmakanharian = ($(`#crudForm [name="uangmakanharian"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="uangmakanharian"]`)[0]);
        let uangmakanjenjang = ($(`#crudForm [name="berjenjanguangmakan"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="berjenjanguangmakan"]`)[0]);
        let biayaextraheader = ($(`#crudForm [name="biayaextraheader"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="biayaextraheader"]`)[0]);
        let total = subtotal + uangmakanharian + uangmakanjenjang + biayaextraheader;


        let uangjalan = AutoNumeric.getNumber($(`#crudForm [name="uangjalan"]`)[0]);
        let deposito = ($(`#crudForm [name="deposito"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="deposito"]`)[0]);
        let bbm = ($(`#crudForm [name="bbm"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="bbm"]`)[0]);
        let potonganpinjaman = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjaman"]`)[0]);
        let potonganpinjamansemua = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjamansemua"]`)[0]);

        let sisa = total - (uangjalan + deposito + bbm + potonganpinjaman + potonganpinjamansemua)
        $(`#crudForm [name="sisa"]`).val(sisa)
        new AutoNumeric(`#crudForm [name="sisa"]`)
    }

    function showGajiSupir(form, gajiId, aksi) {
        return new Promise((resolve, reject) => {
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
                        } else if (element.is('select')) {
                            element.val(value).trigger('change')
                        }

                        if (index == 'supir') {
                            element.data('current-value', value).prop('readonly', true)
                        }


                    })

                    initAutoNumeric(form.find(`[name="subtotal"]`))
                    initAutoNumeric(form.find(`[name="uangjalan"]`))
                    initAutoNumeric(form.find(`[name="berjenjanguangmakan"]`))
                    initAutoNumeric(form.find(`[name="biayaextraheader"]`))
                    initAutoNumeric(form.find(`[name="uangmakanharian"]`))
                    initAutoNumeric(form.find(`[name="deposito"]`))
                    initAutoNumeric(form.find(`[name="potonganpinjaman"]`))
                    initAutoNumeric(form.find(`[name="potonganpinjamansemua"]`))
                    initAutoNumeric(form.find(`[name="bbm"]`))

                    rekapRincian()
                    // $.each(response.getTrip, (index, detail) => {

                    //     selectedRows.push(detail.id)
                    //     selectedNobukti.push(detail.nobuktitrip)
                    //     selectedGajiSupir.push(detail.gajisupir)
                    //     selectedGajiKenek.push(detail.gajikenek)
                    //     selectedKomisiSupir.push(detail.komisisupir)
                    //     selectedUpahRitasi.push(detail.upahritasi)
                    //     selectedStatusRitasi.push(detail.statusritasi)
                    //     selectedBiayaExtra.push(detail.biayaextra)
                    //     selectedKetBiaya.push(detail.keteranganbiaya)
                    //     selectedTolSupir.push(detail.tolsupir)
                    //     selectedRitasi.push(detail.ritasi_nobukti)

                    // })

                    // $('#rekapRincian').jqGrid("clearGridData");
                    // $('#rekapRincian').jqGrid('setGridParam', {
                    //     url: `${apiUrl}gajisupirheader/${gajiId}/getEditTrip`,
                    //     postData: {
                    //         limit: 0,
                    //         supir_id: $('#crudForm [name=supir_id]').val(),
                    //         supir: $('#crudForm [name=supir]').val(),
                    //         tgldari: $('#crudForm [name=tgldari]').val(),
                    //         tglsampai: $('#crudForm [name=tglsampai]').val(),
                    //         sortIndex: sortnameRincian,
                    //     },
                    //     datatype: "json"
                    // }).trigger('reloadGrid');
                    getAllTrip('show').then((response) => {

                        let selectedTrip = []
                        let totalBerjenjang = 0

                        $.each(response.data, (index, value) => {
                            selectedTrip.push(value.id)
                            totalBerjenjang += parseFloat(value.uangmakanberjenjang)
                        })
                        setTimeout(() => {

                            $("#rekapRincian")
                                .jqGrid("setGridParam", {
                                    datatype: "local",
                                    data: response.data,
                                    originalData: response.data,
                                    rowNum: response.data.length,
                                    selectedRowIds: selectedTrip
                                })
                                .trigger("reloadGrid");
                            hitung(selectedTrip)
                        }, 100);

                        initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_uangmakanberjenjang"]`).text(totalBerjenjang))

                    });
                    loadPotSemuaGrid()
                    getDataPotSemua(gajiId).then((response) => {

                        let selectedIdPS = []
                        let totalBayarPS = 0

                        $.each(response.data, (index, value) => {
                            if (value.gajisupir_id != null) {
                                selectedIdPS.push(value.id)
                                totalBayarPS += parseFloat(value.nominalPS)
                            }
                        })
                        $('#tablePotSemua').jqGrid("clearGridData");
                        setTimeout(() => {

                            $("#tablePotSemua")
                                .jqGrid("setGridParam", {
                                    datatype: "local",
                                    data: response.data,
                                    originalData: response.data,
                                    rowNum: response.data.length,
                                    selectedRowIds: selectedIdPS
                                })
                                .trigger("reloadGrid");
                        }, 100);

                        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotSemua_nominalPS"]`).text(totalBayarPS))

                    });

                    loadPotPribadiGrid()
                    getDataPotPribadi(response.data.supir_id, gajiId).then((response) => {

                        let selectedIdPP = []
                        let totalBayarPP = 0

                        $.each(response.data, (index, value) => {
                            if (value.gajisupir_id != null) {
                                selectedIdPP.push(value.id)
                                totalBayarPP += parseFloat(value.nominalPP)
                            }
                        })
                        $('#tablePotPribadi').jqGrid("clearGridData");
                        setTimeout(() => {

                            $("#tablePotPribadi")
                                .jqGrid("setGridParam", {
                                    datatype: "local",
                                    data: response.data,
                                    originalData: response.data,
                                    rowNum: response.data.length,
                                    selectedRowIds: selectedIdPP
                                })
                                .trigger("reloadGrid");
                        }, 100);

                        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotPribadi_nominalPP"]`).text(totalBayarPP))

                    });
                    let supir = form.find(`[name="supir"]`).val();


                    if (response.deposito != null) {
                        form.find(`[name="nobuktiDeposito"]`).val(response.deposito.nobukti)
                        form.find(`[name="tglbuktiDeposito"]`).val(response.data.tglbukti)
                        initAutoNumeric(form.find(`[name="nomDeposito"]`).val(response.deposito.nominal))
                        form.find(`[name="ketDeposito"]`).val(response.deposito.keterangan)
                    } else {
                        let defaultKetDeposito = "DEPOSITO SUPIR " + supir + " PERIODE " + form.find(`[name="tgldari"]`).val() + " S/D " + form.find(`[name="tglsampai"]`).val();
                        form.find(`[name="ketDeposito"]`).val(defaultKetDeposito);
                        initAutoNumeric(form.find(`[name="nomDeposito"]`))
                    }
                    if (response.bbm != null) {
                        form.find(`[name="nobuktiBBM"]`).val(response.bbm.nobukti)
                        form.find(`[name="tglbuktiBBM"]`).val(response.data.tglbukti)
                        initAutoNumeric(form.find(`[name="nomBBM"]`).val(response.bbm.nominal))
                        form.find(`[name="ketBBM"]`).val(response.bbm.keterangan)
                    } else {
                        initAutoNumeric(form.find(`[name="nomBBM"]`))
                        let defaultKetBBM = "HUTANG BBM SUPIR " + supir + " PERIODE " + form.find(`[name="tgldari"]`).val() + " S/D " + form.find(`[name="tglsampai"]`).val();
                        form.find(`[name="ketBBM"]`).val(defaultKetBBM);
                    }

                    loadUangJalan()
                    $.each(response.getUangjalan, (index, detail) => {

                        selectedRowsAbsensi.push(detail.absensi_id)
                        selectedRowsAbsensiNobukti.push(detail.absensi_nobukti)
                        selectedRowsAbsensiUangjalan.push(detail.absensi_uangjalan)
                        selectedRowsAbsensiTrado.push(detail.absensi_tradoid)
                    })

                    $('#tableAbsensi').jqGrid("clearGridData");
                    $('#tableAbsensi').jqGrid('setGridParam', {
                        url: `${apiUrl}gajisupirheader/${gajiId}/getEditAbsensi`,
                        postData: {
                            supir_id: $('#crudForm').find('[name=supir_id]').val(),
                            tgldari: $('#crudForm').find('[name=tgldari]').val(),
                            tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                        },
                        datatype: "json"
                    }).trigger('reloadGrid');

                    if (aksi == 'delete') {

                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }

                    hitung()
                    hitungUangJalan();

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function rekapRincian(url) {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }
        $("#rekapRincian").jqGrid({
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
                colModel: [{
                        label: "",
                        name: "",
                        width: 40,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        searchable: false,
                        searchoptions: {
                            type: 'checkbox',
                            clearSearch: false,
                            dataInit: function(element) {

                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                $(element).addClass('checkbox-selectall')
                                if (disabled == '') {
                                    $(element).on('click', function() {
                                        if ($(this).is(':checked')) {
                                            selectAllRows()
                                        } else {
                                            clearSelectedRows()
                                        }
                                    })
                                } else {
                                    $(element).attr('disabled', true)
                                }

                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" class="checkbox-jqgrid" name="rincianId[]" value="${rowData.id}" ${disabled} onchange="checkboxHandler(this, ${rowData.id})">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobuktitrip',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'tglbuktisp',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'SHIPPER',
                        name: 'pelanggan_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        align: 'left'
                    },
                    {
                        label: 'DARI',
                        name: 'dari_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'SAMPAI',
                        name: 'sampai_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'NO CONT',
                        name: 'nocont',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'NO SP',
                        name: 'nosp',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: "UANG MAKAN BERJENJANG",
                        name: "uangmakanberjenjang",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: "right",
                        editable: true,
                        editoptions: {
                            dataInit: function(element, id) {
                                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
                            },
                            dataEvents: [{
                                type: "keyup",
                                fn: function(event, rowObject) {
                                    let originalGridData = $("#rekapRincian")
                                        .jqGrid("getGridParam", "originalData")
                                        .find((row) => row.id == rowObject.rowId);
                                    let uangMakanBerjenjang = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                                    let localRow = $("#rekapRincian").jqGrid(
                                        "getLocalRow",
                                        rowObject.rowId
                                    );
                                    let total
                                    localRow.uangmakanberjenjang = event.target.value;
                                    uangMakanBerjenjangDetails = $(`#rekapRincian tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="rekapRincian_uangmakanberjenjang"]`)
                                    ttlUangMakanJenjang = 0
                                    $.each(uangMakanBerjenjangDetails, (index, uangMakanBerjenjangDetail) => {
                                        ttlUangMakanJenjangDetail = parseFloat($(uangMakanBerjenjangDetail).attr('title').replaceAll(',', ''))
                                        ttlUangMakanJenjangs = (isNaN(ttlUangMakanJenjangDetail)) ? 0 : ttlUangMakanJenjangDetail;
                                        ttlUangMakanJenjang += ttlUangMakanJenjangs
                                    });
                                    ttlUangMakanJenjang += uangMakanBerjenjang
                                    initAutoNumeric($('.footrow').find(`td[aria-describedby="rekapRincian_uangmakanberjenjang"]`).text(ttlUangMakanJenjang))

                                    $(`#crudForm [name="berjenjanguangmakan"]`).val(ttlUangMakanJenjang)
                                    new AutoNumeric(`#crudForm [name="berjenjanguangmakan"]`)
                                    hitungSisa()
                                },
                            }, ],
                        },
                        sortable: false,
                        sorttype: "int",
                    },
                    {
                        label: 'GAJI SUPIR',
                        name: 'gajisupir',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'GAJI KENEK',
                        name: 'gajikenek',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'KOMISI SUPIR',
                        name: 'komisisupir',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'TOL SUPIR',
                        name: 'tolsupir',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'NO BUKTI RITASI',
                        name: 'ritasi_nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'UPAH RITASI',
                        name: 'upahritasi',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'STATUS RITASI',
                        name: 'statusritasi',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'NO BUKTI B. EXT SUPIR',
                        name: 'biayaextrasupir_nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'NOMINAL B. EXT SUPIR',
                        name: 'biayaextrasupir_nominal',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'KET. B. EXT SUPIR',
                        name: 'biayaextrasupir_keterangan',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'BIAYA EXTRA',
                        name: 'biayaextra',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: currencyFormat,
                        align: "right",
                    },
                    {
                        label: 'KET. BIAYA EXTRA',
                        name: 'keteranganbiaya',
                        width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
                        align: 'left',
                    },
                    {
                        label: 'CONTAINER',
                        name: 'container',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left'
                    },
                    {
                        label: 'STATUS CONTAINER',
                        name: 'statuscontainer',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'CONTAINER',
                        name: 'container_id',
                        hidden: true,
                    },
                    {
                        label: 'STATUS CONTAINER',
                        name: 'statuscontainer_id',
                        hidden: true,
                    },
                    {
                        label: 'upah',
                        name: 'upah_id',
                        hidden: true,
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
                pgbuttons: false,
                pginput: false,
                cellEdit: true,
                cellsubmit: "clientArray",
                editableColumns: ["uangmakanberjenjang"],
                selectedRowIds: [],
                afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
                    let originalGridData = $("#rekapRincian")
                        .jqGrid("getGridParam", "originalData")
                        .find((row) => row.id == rowId);

                    let localRow = $("#rekapRincian").jqGrid("getLocalRow", rowId);

                    let uangMakanberjenjang = $("#rekapRincian").jqGrid("getCell", rowId, "uangmakanberjenjang")

                },
                isCellEditable: function(cellname, iRow, iCol) {
                    let rowData = $(this).jqGrid("getRowData")[iRow - 1];
                    if ($('#crudForm').data('action') != 'delete') {
                        return $(this)
                            .find(`tr input[value=${rowData.id}]`)
                            .is(":checked");
                    }
                },
                validationCell: function(cellobject, errormsg, iRow, iCol) {
                    console.log(cellobject);
                    console.log(errormsg);
                    console.log(iRow);
                    console.log(iCol);
                },
                loadComplete: function(data) {
                    setTimeout(() => {
                        $(this)
                            .getGridParam("selectedRowIds")
                            .forEach((selectedRowId) => {
                                $(this)
                                    .find(`tr input[value=${selectedRowId}]`)
                                    .prop("checked", true);

                                if ($('#crudForm').data('action') == 'edit') {
                                    if (isReload) {
                                        $(this).find(`tr input[value=${selectedRowId}]`).prop("disabled", false);
                                    } else {
                                        $(this).find(`tr input[value=${selectedRowId}]`).prop("disabled", true);
                                    }
                                }
                                initAutoNumeric($(this).find(`td[aria-describedby="rekapRincian_uangmakanberjenjang"]`))
                            });
                    }, 100);
                    $('#loaderGrid').addClass('d-none')
                    setHighlight($(this))
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid("navGrid", "#tablePager", {
                add: false,
                edit: false,
                del: false,
                refresh: false,
                search: false,
            })
            .jqGrid('filterToolbar', {
                searchOnEnter: false,
            })
            .jqGrid("excelLikeGrid", {
                beforeDeleteCell: function(rowId, iRow, iCol, event) {
                    let localRow = $("#rekapRincian").jqGrid("getLocalRow", rowId);

                    $("#rekapRincian").jqGrid(
                        "setCell",
                        rowId,
                        "sisa",
                        parseInt(localRow.sisa) + parseInt(localRow.bayar)
                    );

                    return true;
                },
            });




        /* Append clear filter button */
        loadClearFilter($('#rekapRincian'))

        /* Append global search */
        // loadGlobalSearch($('#rekapRincian'))
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
                    showDialog(error.responseJSON)
                }
            })
        }
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
            <div class="row form-group biayaextraheader">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   biaya extra
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="biayaextraheader" class="form-control text-right">
                </div>
            </div>
            <div class="row form-group keteranganextraheader">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   keterangan extra
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="keteranganextra" class="form-control">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-12 col-md-3">
                  <label class="col-form-label">
                   uang makan berjenjang
                  </label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" name="berjenjanguangmakan" class="form-control text-right autonumeric" readonly>
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
        $('.supir-lookup').lookupV3({
            title: 'Supir Lookup',
            fileName: 'supirV3',
            searching: ['namasupir'],
            labelColumn: false,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supir_id]').first().val(supir.id)
                element.val(supir.namaalias)
                element.data('currentValue', element.val())
                $("#tablePotPribadi")[0].p.selectedRowIds = [];
                $('#tablePotPribadi').jqGrid("clearGridData");
                $("#tablePotPribadi")
                    .jqGrid("setGridParam", {
                        selectedRowIds: []
                    })
                    .trigger("reloadGrid");
                getDataPotPribadi(supir.id).then((response) => {
                    $("#tablePotPribadi")[0].p.selectedRowIds = [];
                    if ($('#crudForm').data('action') == 'add') {
                        selectedRowIdPP = [];
                    } else {
                        selectedRowIdPP = response.selectedId;
                    }
                    // setTimeout(() => {

                    $("#tablePotPribadi")
                        .jqGrid("setGridParam", {
                            datatype: "local",
                            data: response.data,
                            originalData: response.data,
                            rowNum: response.data.length,
                            selectedRowIds: selectedRowIdPP
                        })
                        .trigger("reloadGrid");
                    // }, 100);

                });

                let getPotPribadi = AutoNumeric.getAutoNumericElement($(`#crudForm [name="potonganpinjaman"]`)[0]);
                getPotPribadi.set(0)

                let getUangMakan = AutoNumeric.getAutoNumericElement($(`#crudForm [name="uangmakanharian"]`)[0]);
                getUangMakan.set(0)
                let getUangMakanBerjenjang = AutoNumeric.getAutoNumericElement($(`#crudForm [name="berjenjanguangmakan"]`)[0]);
                getUangMakanBerjenjang.set(0)
                let getDeposito = AutoNumeric.getAutoNumericElement($(`#crudForm [name="deposito"]`)[0]);
                getDeposito.set(0)
                let getNomDeposito = AutoNumeric.getAutoNumericElement($(`#crudForm [name="nomDeposito"]`)[0]);
                getNomDeposito.set(0)
                let getBbm = AutoNumeric.getAutoNumericElement($(`#crudForm [name="bbm"]`)[0]);
                getBbm.set(0)
                let getNomBbm = AutoNumeric.getAutoNumericElement($(`#crudForm [name="nomBBM"]`)[0]);
                getNomBbm.set(0)

                hitungSisa()
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

    async function getEditAbsensi(gajiId) {
        return await $.ajax({
            url: `${apiUrl}gajisupirheader/${gajiId}/getEditAbsensi`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                supirId: $('#crudForm [name=supir_id]').val(),
                dari: dari,
                sampai: sampai,
                sortIndex: sortnameAbsensi,
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

    function clearSelectedRows(element = null) {
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
        $("#rekapRincian")[0].p.selectedRowIds = [];
        $('#rekapRincian').trigger('reloadGrid')
        hitung()
    }

    function getAllTrip(aksi, element = null) {
        if (aksi == 'edit' || aksi == 'show') {
            ricId = $(`#crudForm`).find(`[name="id"]`).val()
            url = `${ricId}/getEditTrip`
        } else {
            url = 'getTrip'
        }
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}gajisupirheader/${url}`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    limit: 0,
                    supir_id: $('#crudForm').find(`[name="supir_id"]`).val(),
                    supir: $('#crudForm').find(`[name="supir"]`).val(),
                    tgldari: $('#crudForm').find(`[name="tgldari"]`).val(),
                    tglsampai: $('#crudForm').find(`[name="tglsampai"]`).val(),
                    statusjeniskendaraan: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val(),
                    sortIndex: sortnameRincian,
                    aksi: aksi
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    response.url = url
                    resolve(response)
                },
                error: error => {
                    reject(error)
                }
            })
        });

    }

    function getAllAbsensi(supirId, dari, sampai, aksi, element = null) {
        if (aksi == 'edit') {
            ricId = $(`#crudForm`).find(`[name="id"]`).val()
            urlAbsensi = `${ricId}/getEditAbsensi`
        } else {
            urlAbsensi = 'getAbsensi'
        }
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}gajisupirheader/${urlAbsensi}`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    limit: 0,
                    supir_id: supirId,
                    tgldari: dari,
                    tglsampai: sampai,
                    statusjeniskendaraan: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val(),
                    sortIndex: sortnameAbsensi,
                    aksi: aksi
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
                    response.url = urlAbsensi
                    resolve(response)
                },
                error: error => {
                    reject(error)
                }
            })
        });

    }

    function selectAllRows() {
        let originalData = $("#rekapRincian").getGridParam("data");
        let getSelectedRows = originalData.map((data) => data.id);
        $("#rekapRincian")[0].p.selectedRowIds = [];

        setTimeout(() => {
            $("#rekapRincian")
                .jqGrid("setGridParam", {
                    selectedRowIds: getSelectedRows
                })
                .trigger("reloadGrid");

            hitung(getSelectedRows)
        })

    }

    function clearSelectedRowsAbsensi() {
        selectedRowsAbsensi = []
        selectedRowsAbsensiNobukti = [];
        selectedRowsAbsensiUangjalan = [];
        selectedRowsAbsensiTrado = [];
        $('#tableAbsensi').trigger('reloadGrid')
    }

    function selectAllRowsAbsensi(supirId, dari, sampai, aksi) {
        if (aksi == 'edit') {
            ricId = $(`#crudForm`).find(`[name="id"]`).val()
            urlAbsensi = `${ricId}/getEditAbsensi`
        } else {
            urlAbsensi = 'getAbsensi'
        }

        $.ajax({
            url: `${apiUrl}gajisupirheader/${urlAbsensi}`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0,
                supir_id: supirId,
                tgldari: dari,
                tglsampai: sampai,
                sortIndex: sortnameAbsensi, 
                statusjeniskendaraan: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val(),
                aksi: aksi
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: (response) => {
                selectedRowsAbsensi = response.data.map((data) => data.absensi_id)
                selectedRowsAbsensiNobukti = response.data.map((data) => data.absensi_nobukti)
                selectedRowsAbsensiUangjalan = response.data.map((data) => data.absensi_uangjalan)
                selectedRowsAbsensiTrado = response.data.map((data) => data.absensi_tradoid)

                $('#tableAbsensi').jqGrid('setGridParam', {
                    url: `${apiUrl}gajisupirheader/${urlAbsensi}`,
                    postData: {
                        supir_id: $('#crudForm').find('[name=supir_id]').val(),
                        tgldari: $('#crudForm').find('[name=tgldari]').val(),
                        tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                        statusjeniskendaraan: $('#crudForm').find(`[name="statusjeniskendaraan"]`).val(),
                        aksi: aksi
                    },
                    datatype: "json"
                }).trigger('reloadGrid');
                initAutoNumeric($('#crudForm').find(`[name="uangjalan"]`).val(response.attributes.uangjalan))
                hitungUangJalan()
            },
        })
    }
</script>
@endpush()
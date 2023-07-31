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
                                    <input type="text" name="supir" autocomplete="off" class="form-control supir-lookup">
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

    function checkboxAbsensiHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRowsAbsensi.push($(element).val())
            selectedRowsAbsensiNobukti.push($(element).parents('tr').find(`td[aria-describedby="tableAbsensi_absensi_nobukti"]`).text())
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
        console.log(subtotal)
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

            getAllTrip(supirId, dari, sampai, aksi)
                .then((response) => {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
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
                        url: `${apiUrl}gajisupirheader/${response.url}`,
                        postData: {
                            supir_id: $('#crudForm').find('[name=supir_id]').val(),
                            supir: $('#crudForm').find(`[name="supir"]`).val(),
                            tgldari: $('#crudForm').find('[name=tgldari]').val(),
                            tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                            aksi: aksi
                        },
                        datatype: "json"
                    }).trigger('reloadGrid');
                    hitungNominal()
                })
                .catch((error) => {
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

                        $('#tableAbsensi').jqGrid('setGridParam', {
                            url: `${apiUrl}gajisupirheader/${urlAbsensi}`,
                            postData: {
                                supir_id: $('#crudForm').find('[name=supir_id]').val(),
                                tgldari: $('#crudForm').find('[name=tgldari]').val(),
                                tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                                aksi: aksi
                            },
                            datatype: "json"
                        }).trigger('reloadGrid');
                    })
                    .catch((error) => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()
                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    })
            }
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

            $.each(selectedRowsAbsensiNobukti, function(index, item) {
                data.push({
                    name: 'absensi_nobukti[]',
                    value: item
                })
            });
            $.each(selectedRowsAbsensiUangjalan, function(index, item) {
                data.push({
                    name: 'absensi_uangjalan[]',
                    value: parseFloat(item.replaceAll(',', ''))
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
                    value: dataPotPribadi.pinjPribadi_id
                })
            });

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
                    clearSelectedRowsAbsensi()
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

        rekapRincian()
        detailLainnya()
        initDatepicker()

        form.find(`[name="subtotal"]`).addClass('disabled')
        initAutoNumeric($('#crudForm').find('[name=nomDeposito]'))
        initAutoNumeric($('#crudForm').find('[name=nomBBM]'))
        initAutoNumeric($('#crudForm').find('[name=nomPinjaman]'))
        initAutoNumeric($('#crudForm').find('[name=uangmakanharian]'))
        initAutoNumeric($('#crudForm').find('[name=uangjalantidakterhitung]'))

        loadPotSemuaGrid()
        getDataPotSemua().then((response) => {
            setTimeout(() => {

                $("#tablePotSemua")
                    .jqGrid("setGridParam", {
                        datatype: "local",
                        data: response.data,
                        originalData: response.data,
                        rowNum: response.data.length,
                        selectedRowIds: []
                    })
                    .trigger("reloadGrid");
            }, 100);

        });
        loadPotPribadiGrid()
        loadUangJalan()
    }

    function editGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        $('#crudModalTitle').text('Edit Rincian Gaji Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showGajiSupir(form, Id, 'edit')
            ])
            .then(() => {
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
    }

    function deleteGajiSupirHeader(Id) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)
        $('#crudModalTitle').text('Delete Rincian Gaji Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        form.find('#btnTampil').prop('disabled', true)
        Promise
            .all([
                showGajiSupir(form, Id, 'delete')
            ])
            .then(() => {
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
                    cekValidasiAksi(Id, Aksi)
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
                        width: 30,
                        formatter: 'checkbox',
                        search: false,
                        editable: false,
                        formatter: function(value, rowOptions, rowData) {
                            let disabled = '';
                            if ($('#crudForm').data('action') == 'delete') {
                                disabled = 'disabled'
                            }
                            return `<input type="checkbox" value="${rowData.id}" ${disabled} onChange="checkboxPotSemuaHandler(this, ${rowData.id})">`;
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
                        sortable: true,
                    },
                    {
                        label: "no bukti pinjaman",
                        name: "pinjSemua_nobukti",
                        sortable: true,
                    },
                    {
                        label: "tgl bukti pinjaman",
                        name: "pinjSemua_tglbukti",
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
                        sortable: true,
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "NOMINAL",
                        name: "nominalPS",
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
                                    nominalPSDetails = $(`#tablePotSemua tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePotSemua_nominalPS"]`)
                                    ttlNominalPS = 0
                                    $.each(nominalPSDetails, (index, nominalPSDetail) => {
                                        ttlNominalPSDetail = parseFloat($(nominalPSDetail).attr('title').replaceAll(',', ''))
                                        ttlNominalPSs = (isNaN(ttlNominalPSDetail)) ? 0 : ttlNominalPSDetail;
                                        ttlNominalPS += ttlNominalPSs
                                    });
                                    ttlNominalPS += nominalPS
                                    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotSemua_nominalPS"]`).text(ttlNominalPS))

                                    initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjamansemua"]`).val(ttlNominalPS))
                                    hitungSisa()
                                    // setAllTotal()
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
                        sortable: false,
                        editable: false,
                        width: 500
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
                        potSemuaSisa = (parseFloat(originalGridDataPotSemua.pinjSemua_sisa) + parseFloat(originalGridDataPotSemua.nominalPS)) - nominalPS
                    } else {
                        potSemuaSisa = originalGridDataPotSemua.pinjSemua_sisa
                    }
                    console.log(indexColumn)
                    if (indexColumn == 6) {

                        $("#tablePotSemua").jqGrid(
                            "setCell",
                            rowId,
                            "pinjSemua_sisa",
                            potSemuaSisa
                            // sisa - nominal - potongan
                        );
                    }
                    // setTotalNominal()
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

                    $("#tablePotSemua").jqGrid(
                        "setCell",
                        rowId,
                        "sisa",
                        parseInt(localRow.sisa) + parseInt(localRow.nominal)
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
            urlPotSemua = `${apiUrl}gajisupirheader/${id}/edit/editpinjsemua`

        } else if (aksi == 'delete') {
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
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
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

                if ($('#crudForm').data('action') == 'edit') {
                    // if (originalGridDataPotSemua.sisa == 0) {

                    //   let getnominalPS = $("#tablePotSemua").jqGrid("getCell", rowId, "nominalPS")
                    //   localRow.nominalPS = (getnominalPS != '') ? parseFloat(getnominalPS.replaceAll(',', '')) : 0
                    // } else {
                    //   localRow.nominalPS = originalGridDataPotSemua.sisa
                    // }
                    localRow.nominalPS = (parseFloat(originalGridDataPotSemua.pinjSemua_sisa) + parseFloat(originalGridDataPotSemua.nominalPS))
                }

                initAutoNumeric($(`#tablePotSemua tr#${rowId}`).find(`td[aria-describedby="tablePotSemua_nominalPS"]`))
                setTotalNominalPS()
                setTotalSisaPotSemua()
            }
        });

        $("#tablePotSemua").jqGrid("setGridParam", {
            selectedRowIds: selectedRowIdsPotSemua,
        });

    }

    function setTotalSisaPotSemua() {
        let pinjSemua_sisaDetails = $(`#tablePotSemua`).find(`td[aria-describedby="tablePotSemua_pinjSemua_sisa"]`)
        let pinjSemua_sisa = 0
        $.each(pinjSemua_sisaDetails, (index, pinjSemua_sisaDetail) => {
            pinjSemua_sisadetail = parseFloat($(pinjSemua_sisaDetail).text().replaceAll(',', ''))
            pinjSemua_sisas = (isNaN(pinjSemua_sisadetail)) ? 0 : pinjSemua_sisadetail;
            pinjSemua_sisa += pinjSemua_sisas
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotSemua_pinjSemua_sisa"]`).text(pinjSemua_sisa))
    }

    function setTotalNominalPS() {
        let nominalPSDetails = $(`#tablePotSemua`).find(`td[aria-describedby="tablePotSemua_nominalPS"]`)
        let nominalPS = 0
        $.each(nominalPSDetails, (index, nominalPSDetail) => {
            nominalPSdetail = parseFloat($(nominalPSDetail).text().replaceAll(',', ''))
            nominalPSs = (isNaN(nominalPSdetail)) ? 0 : nominalPSdetail;
            nominalPS += nominalPSs
        });
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
                        width: 30,
                        formatter: 'checkbox',
                        search: false,
                        editable: false,
                        formatter: function(value, rowOptions, rowData) {
                            let disabled = '';
                            if ($('#crudForm').data('action') == 'delete') {
                                disabled = 'disabled'
                            }
                            return `<input type="checkbox" value="${rowData.pinjPribadi_id}" ${disabled} onChange="checkboxPotPribadiHandler(this, ${rowData.pinjPribadi_id})">`;
                        },
                    },
                    {
                        label: "id",
                        name: "pinjPribadi_id",
                        hidden: true,
                        search: false,
                    },
                    {
                        label: "no bukti pinjaman",
                        name: "pinjPribadi_nobukti",
                        sortable: true,
                    },
                    {
                        label: "tgl bukti pinjaman",
                        name: "pinjPribadi_tglbukti",
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
                        align: "right",
                        formatter: currencyFormat,
                    },
                    {
                        label: "NOMINAL",
                        name: "nominalPP",
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
                                        .find((row) => row.pinjPribadi_id == rowObject.rowId);

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

                                    nominalPPDetails = $(`#tablePotPribadi tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePotPribadi_nominalPP"]`)
                                    ttlnominalPP = 0
                                    $.each(nominalPPDetails, (index, nominalPPDetail) => {
                                        ttlnominalPPDetail = parseFloat($(nominalPPDetail).attr('title').replaceAll(',', ''))
                                        ttlnominalPPs = (isNaN(ttlnominalPPDetail)) ? 0 : ttlnominalPPDetail;
                                        ttlnominalPP += ttlnominalPPs
                                    });
                                    ttlnominalPP += nominalPP
                                    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotPribadi_nominalPP"]`).text(ttlnominalPP))

                                    initAutoNumeric($('#detailLainnya').find(`[name="potonganpinjaman"]`).val(ttlnominalPP))
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
                        sortable: false,
                        editable: false,
                        width: 500
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
                        .find((row) => row.pinjPribadi_id == rowId);

                    let getBayarPP = $("#tablePotPribadi").jqGrid("getCell", rowId, "nominalPP")
                    let nominalPP = (getBayarPP != '') ? parseFloat(getBayarPP.replaceAll(',', '')) : 0

                    potPribadiSisa = 0
                    if ($('#crudForm').data('action') == 'edit') {
                        potPribadiSisa = (parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) + parseFloat(originalGridDataPotPribadi.nominalPP)) - nominalPP
                    } else {
                        potPribadiSisa = originalGridDataPotPribadi.pinjPribadi_sisa
                    }
                    console.log(indexColumn)
                    if (indexColumn == 5) {

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
                        .find(`tr input[value=${rowData.pinjPribadi_id}]`)
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
                    // setTotalNominal()
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

                    $("#tablePotPribadi").jqGrid(
                        "setCell",
                        rowId,
                        "sisa",
                        parseInt(localRow.sisa) + parseInt(localRow.nominal)
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
            urlPotPribadi = `${apiUrl}gajisupirheader/${id}/${supirId}/edit/editpinjpribadi`

        } else if (aksi == 'delete') {
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
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: (response) => {
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
            .find((row) => row.pinjPribadi_id == rowId);

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

                if ($('#crudForm').data('action') == 'edit') {
                    // if (originalGridDataPotPribadi.sisa == 0) {

                    //   let getnominalPP = $("#tablePotPribadi").jqGrid("getCell", rowId, "nominalPP")
                    //   localRow.nominalPP = (getnominalPP != '') ? parseFloat(getnominalPP.replaceAll(',', '')) : 0
                    // } else {
                    //   localRow.nominalPP = originalGridDataPotPribadi.sisa
                    // }
                    localRow.nominalPP = (parseFloat(originalGridDataPotPribadi.pinjPribadi_sisa) + parseFloat(originalGridDataPotPribadi.nominalPP))
                }

                initAutoNumeric($(`#tablePotPribadi tr#${rowId}`).find(`td[aria-describedby="tablePotPribadi_nominalPP"]`))
                setTotalNominalPP()
                setTotalSisaPotPribadi()
            }
        });

        $("#tablePotPribadi").jqGrid("setGridParam", {
            selectedRowIds: selectedRowIdsPotPribadi,
        });

    }

    function setTotalSisaPotPribadi() {
        let pinjPribadi_sisaDetails = $(`#tablePotPribadi`).find(`td[aria-describedby="tablePotPribadi_pinjPribadi_sisa"]`)
        let pinjPribadi_sisa = 0
        $.each(pinjPribadi_sisaDetails, (index, pinjPribadi_sisaDetail) => {
            pinjPribadi_sisadetail = parseFloat($(pinjPribadi_sisaDetail).text().replaceAll(',', ''))
            pinjPribadi_sisas = (isNaN(pinjPribadi_sisadetail)) ? 0 : pinjPribadi_sisadetail;
            pinjPribadi_sisa += pinjPribadi_sisas
        });
        initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePotPribadi_pinjPribadi_sisa"]`).text(pinjPribadi_sisa))
    }

    function setTotalNominalPP() {
        let nominalPPDetails = $(`#tablePotPribadi`).find(`td[aria-describedby="tablePotPribadi_nominalPP"]`)
        let nominalPP = 0
        $.each(nominalPPDetails, (index, nominalPPDetail) => {
            nominalPPdetail = parseFloat($(nominalPPDetail).text().replaceAll(',', ''))
            nominalPPs = (isNaN(nominalPPdetail)) ? 0 : nominalPPdetail;
            nominalPP += nominalPPs
        });
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
                                $(element).attr('id', 'gsUangjalan')
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
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
                            return `<input type="checkbox" name="absensiId[]" value="${rowData.absensi_id}" ${disabled} onchange="checkboxAbsensiHandler(this)">`
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
                        align: 'left',
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'absensi_tglbukti',
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
                        formatter: currencyFormat,
                        align: "right",
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
                            }
                        })
                    });

                    $('#gsUangjalan').attr('disabled', false)
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
                    }


                })

                initAutoNumeric(form.find(`[name="subtotal"]`))
                initAutoNumeric(form.find(`[name="uangjalan"]`))
                initAutoNumeric(form.find(`[name="uangjalantidakterhitung"]`))
                initAutoNumeric(form.find(`[name="uangmakanharian"]`))
                initAutoNumeric(form.find(`[name="deposito"]`))
                initAutoNumeric(form.find(`[name="potonganpinjaman"]`))
                initAutoNumeric(form.find(`[name="potonganpinjamansemua"]`))
                initAutoNumeric(form.find(`[name="bbm"]`))

                rekapRincian()
                $.each(response.getTrip, (index, detail) => {

                    selectedRows.push(detail.id)
                    selectedNobukti.push(detail.nobuktitrip)
                    selectedGajiSupir.push(detail.gajisupir)
                    selectedGajiKenek.push(detail.gajikenek)
                    selectedKomisiSupir.push(detail.komisisupir)
                    selectedUpahRitasi.push(detail.upahritasi)
                    selectedStatusRitasi.push(detail.statusritasi)
                    selectedBiayaExtra.push(detail.biayaextra)
                    selectedKetBiaya.push(detail.keteranganbiaya)
                    selectedTolSupir.push(detail.tolsupir)
                    selectedRitasi.push(detail.ritasi_nobukti)

                })

                $('#rekapRincian').jqGrid("clearGridData");
                $('#rekapRincian').jqGrid('setGridParam', {
                    url: `${apiUrl}gajisupirheader/${gajiId}/getEditTrip`,
                    postData: {
                        limit: 0,
                        supir_id: $('#crudForm [name=supir_id]').val(),
                        supir: $('#crudForm [name=supir]').val(),
                        tgldari: $('#crudForm [name=tgldari]').val(),
                        tglsampai: $('#crudForm [name=tglsampai]').val(),
                        sortIndex: sortnameRincian,
                    },
                    datatype: "json"
                }).trigger('reloadGrid');

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
                            selectedIdPP.push(value.pinjPribadi_id)
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

                loadUangJalan()
                $.each(response.getUangjalan, (index, detail) => {

                    selectedRowsAbsensi.push(detail.absensi_id)
                    selectedRowsAbsensiNobukti.push(detail.absensi_nobukti)
                    selectedRowsAbsensiUangjalan.push(detail.absensi_uangjalan)
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

                hitungNominal();
                hitungUangJalan();

            }
        })
    }

    function rekapRincian(url) {
        let disabled = '';
        if ($('#crudForm').data('action') == 'delete') {
            disabled = 'disabled'
        }
        $("#rekapRincian").jqGrid({
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
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
                                $(element).attr('id', 'gsRincian')
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                if (disabled == '') {
                                    $(element).on('click', function() {
                                        $(element).attr('disabled', true)

                                        if ($(this).is(':checked')) {
                                            selectAllRows(supirId, dari, sampai, aksi, element)
                                        } else {
                                            clearSelectedRows(element)
                                        }
                                    })
                                } else {
                                    $(element).attr('disabled', true)
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
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobuktitrip',
                        align: 'left',
                    },
                    {
                        label: 'TGL BUKTI',
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

                    $('#gsRincian').attr('disabled', false)
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
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
                getDataPotPribadi(supir.id).then((response) => {
                    setTimeout(() => {

                        $("#tablePotPribadi")
                            .jqGrid("setGridParam", {
                                datatype: "local",
                                data: response.data,
                                originalData: response.data,
                                rowNum: response.data.length,
                                selectedRowIds: []
                            })
                            .trigger("reloadGrid");
                    }, 100);

                });
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
        $('#rekapRincian').trigger('reloadGrid')
    }

    function getAllTrip(supirId, dari, sampai, aksi, element = null) {
        if (aksi == 'edit') {
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
                    supir_id: supirId,
                    supir: $('#crudForm').find(`[name="supir"]`).val(),
                    tgldari: dari,
                    tglsampai: sampai,
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

    function selectAllRows(supirId, dari, sampai, aksi, element = null) {
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
                supir_id: supirId,
                supir: $('#crudForm').find(`[name="supir"]`).val(),
                tgldari: dari,
                tglsampai: sampai,
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
                        supir_id: $('#crudForm').find('[name=supir_id]').val(),
                        supir: $('#crudForm').find(`[name="supir"]`).val(),
                        tgldari: $('#crudForm').find('[name=tgldari]').val(),
                        tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                        aksi: aksi
                    },
                    datatype: "json"
                }).trigger('reloadGrid');
                hitungNominal()
            }
        })

    }

    function clearSelectedRowsAbsensi() {
        selectedRowsAbsensi = []
        selectedRowsAbsensiNobukti = [];
        selectedRowsAbsensiUangjalan = [];
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
                aksi: aksi
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: (response) => {
                selectedRowsAbsensi = response.data.map((data) => data.absensi_id)
                selectedRowsAbsensiNobukti = response.data.map((data) => data.absensi_nobukti)
                selectedRowsAbsensiUangjalan = response.data.map((data) => data.absensi_uangjalan)

                $('#tableAbsensi').jqGrid('setGridParam', {
                    url: `${apiUrl}gajisupirheader/${urlAbsensi}`,
                    postData: {
                        supir_id: $('#crudForm').find('[name=supir_id]').val(),
                        tgldari: $('#crudForm').find('[name=tgldari]').val(),
                        tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
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
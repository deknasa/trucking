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
                                <div class="col-12 col-md-2 col-form-label">
                                    <label>
                                        NO BUKTI <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" name="nobukti" class="form-control" readonly>
                                </div>

                                <div class="col-12 col-md-2 col-form-label">
                                    <label>
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
                                <div class="col-12 col-md-2 col-form-label">
                                    <label>
                                        SUPIR <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="hidden" name="supir_id">
                                    <input type="text" name="supir" autocomplete="off" class="form-control supir-lookup">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2 col-form-label">
                                    <label>
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
                                <div class="col-12 col-md-2 col-form-label">
                                    <label>
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
                                    <button class="btn btn-secondary" type="button" id="btnTampil">TAMPIL</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div id="tabs" class="dejavu">
                                    <ul>
                                        <li><a href="#tabs-1">Rekap Rincian</a></li>
                                        <li><a href="#tabs-2">Pot. pinjaman (semua)</a></li>
                                        <li><a href="#tabs-3">Pot. pinjaman (pribadi)</a></li>
                                        <li><a href="#tabs-4">deposito</a></li>
                                        <li><a href="#tabs-5">bbm</a></li>
                                        <li><a href="#tabs-6">pinjaman pribadi</a></li>
                                    </ul>
                                    <div id="tabs-1">
                                        <table id="rekapRincian"></table>
                                    </div>

                                    <div id="tabs-2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mt-3" id="potonganSemua" style="width:1000px;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th width="1%">pilih</th>
                                                        <th width="12%">SUPIR</th>
                                                        <th width="24%">NOMINAL</th>
                                                        <th width="22%">NO PINJAMAN</th>
                                                        <th width="14%">SISA</th>
                                                        <th width="28%">KETERANGAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyPotSemua">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td>
                                                            <p id="nominalPotSemua" class="text-right font-weight-bold"></p>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            <p id="sisaPotSemua" class="text-right font-weight-bold"></p>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="tabs-3">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mt-3" id="pinjamanPribadi" style="width:800px;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th width="1%">pilih</th>
                                                        <th width="20%">NO PINJAMAN</th>
                                                        <th width="20%">SISA</th>
                                                        <th width="20%">NOMINAL</th>
                                                        <th width="30%">KETERANGAN</th>
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
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiDeposito" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiDeposito" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal Deposito</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomDeposito" class="form-control text-right">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan Deposito</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketDeposito" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tabs-5">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiBBM" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiBBM" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal BBM</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomBBM" class="form-control text-right">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan BBM</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketBBM" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div id="tabs-6">
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    NO BUKTI</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nobuktiPinjaman" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Tanggal Bukti</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="tglbuktiPinjaman" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Nominal Pinjaman</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="nomPinjaman" class="form-control text-right">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12 col-sm-3 col-md-2 col-form-label">
                                                <label>
                                                    Keterangan Pinjaman</label>
                                            </div>
                                            <div class="col-12 col-sm-9 col-md-10">
                                                <input type="text" name="ketPinjaman" class="form-control">
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

    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()
    let supirId = 0
    let dari = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    let sampai = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    let selectedRows = [];
    let subtotal = 0

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
        } else {
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                }
            }
        }
    }
    $(document).ready(function() {


        $(document).on('input', `#crudForm [name="uangmakanharian"]`, function(event) {
            let uangMakan = $(this).val()
            uangMakan = parseFloat(uangMakan.replaceAll(',', ''));

            let subTotal = ($(`#crudForm [name="subtotal"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="subtotal"]`)[0])

            let total = subTotal + uangMakan

            // hitung sisa

            let uangjalan = AutoNumeric.getNumber($(`#crudForm [name="uangjalan"]`)[0]);
            let deposito = ($(`#crudForm [name="deposito"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="deposito"]`)[0]);
            let bbm = ($(`#crudForm [name="bbm"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="bbm"]`)[0]);
            let potonganpinjaman = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjaman"]`)[0]);
            let potonganpinjamansemua = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjamansemua"]`)[0]);
            let gajiminus = ($(`#crudForm [name="gajiminus"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="gajiminus"]`)[0]);
            let pinjamanpribadi = ($(`#crudForm [name="pinjamanpribadi"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="pinjamanpribadi"]`)[0]);

            let sisa = total - (uangjalan + deposito + bbm + potonganpinjaman + potonganpinjamansemua + gajiminus + pinjamanpribadi)

            $(`#crudForm [name="sisa"]`).val(sisa)
            $(`#crudForm [name="total"]`).val(total)

            new AutoNumeric(`#crudForm [name="sisa"]`)
            new AutoNumeric(`#crudForm [name="total"]`)
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

        $(document).on('input', `#crudForm [name="nomPinjaman"]`, function(event) {
            let nomPinjaman = AutoNumeric.getNumber($(this)[0]);
            $(`#crudForm [name="pinjamanpribadi"]`).val(nomPinjaman)
            new AutoNumeric(`#crudForm [name="pinjamanpribadi"]`)
            hitungSisa()
        })

        $(document).on('input', `#crudForm [name="gajiminus"]`, function(event) {

            hitungSisa()

        })
        $(document).on('click', '#btnTampil', function(event) {
            event.preventDefault()
            let form = $('#crudForm')

            supirId = form.find(`[name="supir_id"]`).val()
            dari = form.find(`[name="tgldari"]`).val()
            sampai = form.find(`[name="tglsampai"]`).val()
            tglbukti = form.find(`[name="tglbukti"]`).val()
            let action = form.data('action')
            $('#tripList tbody').html('')
            $('#gajiSupir').html('')
            $('#gajiKenek').html('')
            $('#rekapRincian').jqGrid('setGridParam', {
                postData: {
                    supirId: $('#crudForm').find('[name=supir_id]').val(),
                    dari: $('#crudForm').find('[name=tgldari]').val(),
                    sampai: $('#crudForm').find('[name=tglsampai]').val(),
                    aksi: action
                },
            }).trigger('reloadGrid');

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
            $('#crudForm').find(`[name="uangmakanharian"]`).each((index, element) => {
                data.push({
                    name: 'uangmakanharian',
                    value: AutoNumeric.getNumber($(`#crudForm [name="uangmakanharian"]`)[index])
                })
            })
            $('#crudForm').find(`[name="deposito"]`).each((index, element) => {
                data.push({
                    name: 'deposito',
                    value: AutoNumeric.getNumber($(`#crudForm [name="deposito"]`)[index])
                })
            })
            $('#crudForm').find(`[name="pinjamanpribadi"]`).each((index, element) => {
                data.push({
                    name: 'pinjamanpribadi',
                    value: AutoNumeric.getNumber($(`#crudForm [name="pinjamanpribadi"]`)[index])
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

            $('#crudForm').find(`[name="gajiminus"]`).each((index, element) => {
                data.push({
                    name: 'gajiminus',
                    value: AutoNumeric.getNumber($(`#crudForm [name="gajiminus"]`)[index])
                })
            })
            $('#crudForm').find(`[name="total"]`).each((index, element) => {
                data.push({
                    name: 'total',
                    value: AutoNumeric.getNumber($(`#crudForm [name="total"]`)[index])
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
            $('#crudForm').find(`[name="nomPinjaman"]`).each((index, element) => {
                data.push({
                    name: 'nomPinjaman',
                    value: AutoNumeric.getNumber($(`#crudForm [name="nomPinjaman"]`)[index])
                })
            })
            data.push({
                name: 'ketPinjaman',
                value: form.find(`[name="ketPinjaman"]`).val()
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
                    url = `${apiUrl}gajisupirheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}gajisupirheader`
                    break;
            }
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
                    if (id == 0) {
                        $('#detail').jqGrid().trigger('reloadGrid')
                    }
                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
                    }
                },
                error: error => {
                    console.log(error)
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        setErrorMessages(form, error.responseJSON.errors);
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
        detailLainnya()
        initDatepicker()
        form.find(`[name="subtotal"]`).addClass('disabled')
        initAutoNumeric($('#crudForm').find('[name=nomDeposito]'))
        initAutoNumeric($('#crudForm').find('[name=nomBBM]'))
        initAutoNumeric($('#crudForm').find('[name=nomPinjaman]'))
        initAutoNumeric($('#crudForm').find('[name=uangmakanharian]'))
        initAutoNumeric($('#crudForm').find('[name=gajiminus]'))
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
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        showGajiSupir(form, Id, 'edit')
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
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        showGajiSupir(form, Id, 'delete')

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
        let total = AutoNumeric.getNumber($(`#crudForm [name="total"]`)[0]);
        let uangjalan = AutoNumeric.getNumber($(`#crudForm [name="uangjalan"]`)[0]);
        let deposito = ($(`#crudForm [name="deposito"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="deposito"]`)[0]);
        let bbm = ($(`#crudForm [name="bbm"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="bbm"]`)[0]);
        let potonganpinjaman = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjaman"]`)[0]);
        let potonganpinjamansemua = AutoNumeric.getNumber($(`#crudForm [name="potonganpinjamansemua"]`)[0]);
        let gajiminus = ($(`#crudForm [name="gajiminus"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="gajiminus"]`)[0]);
        let pinjamanpribadi = ($(`#crudForm [name="pinjamanpribadi"]`).val() == '') ? 0 : AutoNumeric.getNumber($(`#crudForm [name="pinjamanpribadi"]`)[0]);

        let sisa = total - (uangjalan + deposito + bbm + potonganpinjaman + potonganpinjamansemua + gajiminus + pinjamanpribadi)
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

                })
                console.log(response.data.supir_id)

                initAutoNumeric(form.find(`[name="subtotal"]`))
                initAutoNumeric(form.find(`[name="uangmakanharian"]`))
                initAutoNumeric(form.find(`[name="deposito"]`))
                initAutoNumeric(form.find(`[name="pinjamanpribadi"]`))
                initAutoNumeric(form.find(`[name="potonganpinjaman"]`))
                initAutoNumeric(form.find(`[name="potonganpinjamansemua"]`))
                initAutoNumeric(form.find(`[name="bbm"]`))
                initAutoNumeric(form.find(`[name="gajiminus"]`))
                initAutoNumeric(form.find(`[name="total"]`))
                url = `${gajiId}/getEditTrip`
                rekapRincian(url)

                $('#rekapRincian').jqGrid('setGridParam', {
                    postData: {
                        supirId: response.data.supir_id,
                        dari: response.data.tgldari,
                        sampai: response.data.tglsampai,
                    },
                }).trigger('reloadGrid');

                if (response.pinjamanpribadi != null) {

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
                        <td><input name='pinjPribadi[]' type="checkbox" id="checkItem" value="${detail.id}" ${checked}></td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPP autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${detail.sisaawal}">
                        </td>
                        <td id=${detail.id}>
                            <input type="text" name="nominalPP[]" class="form-control bayar text-right" ${disabled} value="${nominal}">
                        </td>
                        <td>${detail.keterangan}</td>
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

                    initAutoNumeric(form.find(`[name="saldopinjaman"]`).val(saldoAwal))
                    initAutoNumeric(form.find(`[name="sisapinjaman"]`).val(totalSisa))
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
                        <td><input name='pinjSemua[]' type="checkbox" id="checkItem" value="${detail.id}" ${checked}></td>
                        <td>SEMUA</td>
                        <td id=${detail.id}>
                            <input type="text" name="nominalPS[]" value="${nominal}" ${disabled} class="form-control text-right">
                        </td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPS autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPS[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPS[]" class="autonumeric" value="${detail.sisaawal}">
                        </td>
                        <td>${detail.keterangan}</td>
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
                    initAutoNumeric(form.find(`[name="saldopinjamansemua"]`).val(saldoAwal))
                    initAutoNumeric(form.find(`[name="sisapinjamansemua"]`).val(totalSisa))
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

                if (response.pribadi != null) {
                    form.find(`[name="nobuktiPinjaman"]`).val(response.pribadi.nobukti)
                    form.find(`[name="tglbuktiPinjaman"]`).val(response.data.tglbukti)
                    initAutoNumeric(form.find(`[name="nomPinjaman"]`).val(response.pribadi.nominal))
                    form.find(`[name="ketPinjaman"]`).val(response.pribadi.keterangan)
                } else {
                    initAutoNumeric(form.find(`[name="nomPinjaman"]`))
                }

                if (aksi == 'delete') {

                    form.find('[name]').addClass('disabled')
                    initDisabled()
                }
            }
        })
    }



    function getEditTrip(gajiId, aksi) {
        $('#gajiSupir').html('')
        $('#gajiKenek').html('')
        $.ajax({
            url: `${apiUrl}gajisupirheader/${gajiId}/getEditTrip`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

                let gajiSupir = 0
                let gajiKenek = 0
                $.each(response.data, (index, detail) => {
                    gajiSupir = parseFloat(gajiSupir) + parseFloat(detail.gajisupir)
                    gajiKenek = parseFloat(gajiKenek) + parseFloat(detail.gajikenek)

                    let detailRow = $(`
                        <tr >
                            <td><input name='sp_id[]' type="checkbox" id="checkItem" value="${detail.id}" checked disabled></td>
                            <td>${detail.nobukti}</td>
                            <td>${detail.tglbukti}</td>
                            <td>${detail.trado}</td>
                            <td>${detail.dari}</td>
                            <td>${detail.sampai}</td>
                            <td>${detail.nocont}</td>
                            <td>${detail.nosp}</td>
                            <td class="gajiSupir text-right">${detail.gajisupir}</td>
                            <td class="gajiKenek text-right">${detail.gajikenek}</td>
                        </tr>
                    `)

                    $('#tripList tbody').append(detailRow)
                    initAutoNumeric(detailRow.find('.gajiSupir'))
                    initAutoNumeric(detailRow.find('.gajiKenek'))
                })
                $('#gajiSupir').append(`${gajiSupir}`)
                $('#gajiKenek').append(`${gajiKenek}`)

                let subTotal = gajiSupir + gajiKenek
                $('#crudForm').find(`[name="subtotal"]`).val(subTotal)
                initAutoNumeric($('#crudForm').find(`[name="subtotal"]`))

                initAutoNumeric($('#tripList tfoot').find('#gajiSupir'))
                initAutoNumeric($('#tripList tfoot').find('#gajiKenek'))

            }
        })
    }

    function rekapRincian(url) {
        $("#rekapRincian").jqGrid({
                url: `${apiUrl}gajisupirheader/${url}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'Pilih',
                        name: 'id',
                        index: 'Pilih',
                        formatter: (value) => {
                            return `<input type="checkbox" value="${value}" onchange="checkboxHandler(this)">`
                        },
                        editable: true,
                        edittype: 'checkbox',
                        search: false,
                        width: 60,
                        align: 'center',
                        formatoptions: {
                            disabled: false
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
                        align: 'left'
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
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortname,
                sortorder: sortorder,
                page: page,
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
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))


                },
                loadComplete: function(data) {
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
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').limit
                    postData = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }

                    setTimeout(function() {

                        if (triggerClick) {
                            if (id != '') {
                                indexRow = parseInt($('#rekapRincian').jqGrid('getInd', id)) - 1
                                $(`#rekapRincian [id="${$('#rekapRincian').getDataIDs()[indexRow]}"]`).click()
                                id = ''
                            } else if (indexRow != undefined) {
                                $(`#rekapRincian [id="${$('#rekapRincian').getDataIDs()[indexRow]}"]`).click()
                            }

                            if ($('#rekapRincian').getDataIDs()[indexRow] == undefined) {
                                $(`#rekapRincian [id="` + $('#rekapRincian').getDataIDs()[0] + `"]`).click()
                            }

                            triggerClick = false
                        } else {
                            $('#rekapRincian').setSelection($('#rekapRincian').getDataIDs()[indexRow])
                        }
                    }, 100)


                    setHighlight($(this))

                    if (data.attributes) {

                        $('#rekapRincian tbody tr').find(`td input:checkbox`).prop('checked',false);
                        selectedRows = [];
                        $('#rekapRincian tbody tr').each(function(row, tr) {
                            $(this).find(`td input:checkbox`).click()
                        })
                        subtotal = parseFloat(data.attributes.totalGajiSupir) + parseFloat(data.attributes.totalGajiKenek) + parseFloat(data.attributes.totalKomisiSupir)
                        initAutoNumeric($('#crudForm').find(`[name="subtotal"]`).val(subtotal))
                        initAutoNumeric($('#crudForm').find(`[name="total"]`).val(subtotal))
                        $(this).jqGrid('footerData', 'set', {
                            gajisupir: data.attributes.totalGajiSupir,
                            gajikenek: data.attributes.totalGajiKenek,
                            komisisupir: data.attributes.totalKomisiSupir,
                        }, true)
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
                    clearGlobalSearch($('#rekapRincian'))
                },
            })

            .customPager({})



        /* Append clear filter button */
        loadClearFilter($('#rekapRincian'))

        /* Append global search */
        loadGlobalSearch($('#rekapRincian'))
    }

    $(document).on('click', `#tripList tbody [name="sp_id[]"]`, function() {
        let gajiSupir = $(this).closest('tr').find('td.gajiSupir').text()
        gajiSupir = parseFloat(gajiSupir.replaceAll(',', ''));

        let totalSupir = $('#gajiSupir').text()
        totalSupir = parseFloat(totalSupir.replaceAll(',', ''));

        let gajiKenek = $(this).closest('tr').find('td.gajiKenek').text()
        gajiKenek = parseFloat(gajiKenek.replaceAll(',', ''));

        let totalKenek = $('#gajiKenek').text()
        totalKenek = parseFloat(totalKenek.replaceAll(',', ''));

        let total = 0
        let subTotal = 0
        let uangMakan = $('#crudForm').find(`[name="uangmakanharian"]`).val()
        uangMakan = parseFloat(uangMakan.replaceAll(',', ''));

        let finalSupir = 0
        let finalKenek = 0

        if ($(this).prop("checked") == true) {
            finalSupir = totalSupir + gajiSupir;
            finalKenek = totalKenek + gajiKenek;
            $('#gajiSupir').html('')
            $('#gajiSupir').append(`${finalSupir}`)
            $('#gajiKenek').html('')
            $('#gajiKenek').append(`${finalKenek}`)


            subTotal = finalSupir + finalKenek
            if (uangMakan) {
                total = subTotal + uangMakan
            } else {
                total = subTotal
            }
        } else {
            finalSupir = totalSupir - gajiSupir;
            finalKenek = totalKenek - gajiKenek;

            $('#gajiSupir').html('')
            $('#gajiSupir').append(`${finalSupir}`)
            $('#gajiKenek').html('')
            $('#gajiKenek').append(`${finalKenek}`)

            subTotal = finalSupir + finalKenek
            if (uangMakan) {
                total = subTotal + uangMakan
            } else {
                total = subTotal
            }

        }

        initAutoNumeric($('#tripList tfoot').find('#gajiSupir'))
        initAutoNumeric($('#tripList tfoot').find('#gajiKenek'))

        $('#crudForm').find(`[name="subtotal"]`).val(subTotal)
        initAutoNumeric($('#crudForm').find(`[name="subtotal"]`))

        $('#crudForm').find(`[name="total"]`).val(total)
        initAutoNumeric($('#crudForm').find(`[name="total"]`))
    })



    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(2)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
        console.log($('#crudForm input:checkbox').find(`[name="sp_id[]"]`).val())
    });

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
                        <tr >
                        <td><input name='pinjSemua[]' type="checkbox" id="checkItem" value="${id}"></td>
                        <td>${supir}</td>
                        <td id=${id}>
                            <input type="text" name="nominalPS[]" disabled class="form-control bayar text-right">
                        </td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPS autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPS[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPS[]" class="autonumeric" value="${sisa}">
                        </td>
                        <td>${detail.keterangan}</td>
                        </tr>
                    `)

                    initAutoNumeric(detailRow.find(`[name="sisaPS[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisaAwalPS[]"]`))
                    initAutoNumeric(detailRow.find(`.sisaPS`))

                    $('#potonganSemua tbody').append(detailRow)
                    setTotalPS()

                })

                $('#sisaPotSemua').append(`${totalSisa}`)
                initAutoNumeric($('#detailLainnya').find(`[name="saldopinjamansemua"]`).val(totalSisa))
                initAutoNumeric($('#detailLainnya').find(`[name="sisapinjamansemua"]`).val(totalSisa))
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
                        <td><input name='pinjPribadi[]' type="checkbox" id="checkItem" value="${id}"></td>
                        <td>${detail.nobukti}</td>
                        <td>
                            <p class="text-right sisaPP autonumeric">${sisa}</p>
                            <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                            <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${sisa}">
                        </td>
                        <td id=${id}>
                            <input type="text" name="nominalPP[]" disabled class="form-control bayar text-right">
                        </td>
                        <td>${detail.keterangan}</td>
                        </tr>
                    `)

                    initAutoNumeric(detailRow.find(`[name="sisaPP[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisaAwalPP[]"]`))
                    initAutoNumeric(detailRow.find(`.sisaPP`))

                    $('#pinjamanPribadi tbody').append(detailRow)
                    setTotalPP()
                    setSisaPP()
                })

                // $('#sisaPinjPribadi').set(`${totalSisa}`)

                $(`#pinjamanPribadi tfoot`).show()
                initAutoNumeric($('#detailLainnya').find(`[name="saldopinjaman"]`).val(totalSisa))
                initAutoNumeric($('#detailLainnya').find(`[name="sisapinjaman"]`).val(totalSisa))
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
            initAutoNumeric($(this).closest('tr').find(`td [name="nominalPP[]"]`).val(sisa))
            let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominalPP[]"]`)[0])
            let totalSisa = sisa - bayar

            $(this).closest("tr").find(".sisaPP").html(totalSisa)
            $(this).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)
            initAutoNumeric($(this).closest("tr").find(".sisaPP"))

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
        <div class="row" >
            <div class="col-md-2">
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Sub Total</label>
                  <div class="col-sm-12">
                    <input type="text" name="subtotal" class="form-control autonumeric" disabled>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">U. Jalan All </label>
                  <div class="col-sm-12">
                    <input type="text" name="uangjalan" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">U. BBM </label>
                  <div class="col-sm-12">
                    <input type="text" name="bbm" class="form-control autonumeric" readonly>
                  </div>
                </div>
            </div>
            
            <div class="col-md-2">
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">U. Makan Harian </label>
                  <div class="col-sm-12">
                    <input type="text" name="uangmakanharian" class="form-control text-right">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Pinj. Pribadi</label>
                  <div class="col-sm-12">
                    <input type="text" name="pinjamanpribadi" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">GAJI MINUS </label>
                  <div class="col-sm-12">
                    <input type="text" name="gajiminus" class="form-control text-right" >
                  </div>
                </div>

            </div>
            
            <div class="col-md-2">
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Saldo Pinjaman </label>
                  <div class="col-sm-12">
                    <input type="text" name="saldopinjaman" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Pot. Pinjaman </label>
                  <div class="col-sm-12">
                    <input type="text" name="potonganpinjaman" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Sisa Pinjaman </label>
                  <div class="col-sm-12">
                    <input type="text" name="sisapinjaman" class="form-control autonumeric" readonly>
                  </div>
                </div>

            </div>
            <div class="col-md-2">
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Saldo pinj. (Semua)</label>
                  <div class="col-sm-12 col-md-12">
                    <input type="text" name="saldopinjamansemua" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Pot. pinj. (Semua)</label>
                  <div class="col-sm-12">
                    <input type="text" name="potonganpinjamansemua" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Sisa pinj. (Semua)</label>
                  <div class="col-sm-12">
                    <input type="text" name="sisapinjamansemua" class="form-control autonumeric" readonly>
                  </div>
                </div>
            </div>
            
            <div class="col-md-2">
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Deposito</label>
                  <div class="col-sm-12">
                    <input type="text" name="deposito" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">Sisa</label>
                  <div class="col-sm-12">
                    <input type="text" name="sisa" class="form-control autonumeric" readonly>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label" style="font-size:12.5px">u. Jln tdk Terhitung</label>
                  <div class="col-sm-12">
                    <input type="text" name="uangjalantidakterhitung" class="form-control autonumeric" readonly>
                  </div>
                </div>

            </div>
            <div class="col-md-2">
                <div class="form-group ">
                    <label class="col-sm-12 col-form-label" style="font-size:12.5px">(Sub + U. Makan)</label>
                    <div class="col-sm-12">
                        <input type="text" name="total" class="form-control autonumeric" readonly>
                    </div>
                </div>
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
</script>
@endpush()
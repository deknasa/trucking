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
                                        ABSENSI SUPIR <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="absensisupir" class="form-control absensisupir-lookup">
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
                                    <input type="text" name="supir" class="form-control supir-lookup">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2">
                                    <label class="col-form-label">
                                        NO. POL <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="hidden" name="trado_id">
                                    <input type="text" name="trado" class="form-control trado-lookup">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div id="tabs" class="dejavu" style="font-size:12px">
                                    <ul>
                                        <li><a href="#tabs-1">List Transfer</a></li>
                                        <li><a href="#tabs-2">List Adjust Transfer</a></li>
                                        <li><a href="#tabs-3">List Deposit</a></li>
                                        <li><a href="#tabs-4">List Pengembalian Pinjaman</a></li>
                                    </ul>

                                    <div id="tabs-1">
                                        <div class="table-scroll table-responsive">
                                            <table class="table table-bordered table-bindkeys" id="detailTransfer" style="width:1450px;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="10%">Tanggal</th>
                                                        <th width="20%">Keterangan Transfer</th>
                                                        <th width="15%">Nilai Transfer</th>
                                                        <th width="20%">Posting ke Kas/Bank</th>
                                                        <th width="15%">No Bukti Kas/Bank</th>
                                                        <th width="5%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyTransfer" class="form-group">
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p class="text-right font-weight-bold">TOTAL :</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold autonumeric" id="totalTransfer"></p>
                                                        </td>
                                                        <td colspan="2"></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm my-2" id="addRowTransfer">TAMBAH</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                    <div id="tabs-2">
                                        <div class="row form-group mt-3">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    TGL ADJUST TRANSFER
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="tgladjust" class="form-control datepicker">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    NILAI ADJUST TRANSFER
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nilaiadjust" readonly class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    KETERANGAN ADJUST TRANSFER
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="keteranganadjust" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border p-3 mt-3">
                                            <h6>Posting ke Kas/Bank Masuk</h6>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        POSTING
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="hidden" name="bank_idadjust">
                                                    <input type="text" name="bankadjust" class="form-control bankadjust-lookup">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        NO BUKTI BARU
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" name="penerimaan_nobukti" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="tabs-3">

                                        <div class="row form-group mt-3">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    NO BUKTI
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nobuktideposit" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    TANGGAL
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="tgldeposit" class="form-control datepicker">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    NILAI DEPOSIT
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nilaideposit" class="form-control text-right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2">
                                                <label class="col-form-label">
                                                    KETERANGAN
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="keterangandeposit" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border p-3 mt-3">
                                            <h6>Posting ke Kas/Bank Masuk</h6>

                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        POSTING
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="hidden" name="bank_iddeposit">
                                                    <input type="text" name="bankdeposit" class="form-control bankdeposit-lookup">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-2">
                                                    <label class="col-form-label">
                                                        NO BUKTI BARU
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" name="penerimaandeposit_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tabs-4">
                                        <div class="row form-group mt-3">
                                            <div class="col-12 col-md-2">
                                                <label class="col-form-label">
                                                    POSTING
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="hidden" name="bank_idpengembalian">
                                                <input type="text" name="bankpengembalian" class="form-control bankpengembalian-lookup">
                                            </div>
                                        </div>
                                        <div class="table-scroll table-responsive">
                                            <table class="table table-bordered table-bindkeys" id="detailPengembalian" style="width:1450px;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Pilih</th>
                                                        <th width="15%">No Bukti</th>
                                                        <th width="10%">Tanggal</th>
                                                        <th width="10%">Supir</th>
                                                        <th width="10%">Jlh Pinjaman</th>
                                                        <th width="10%">Total Bayar</th>
                                                        <th width="10%">Sisa</th>
                                                        <th width="10%">Nom Bayar</th>
                                                        <th width="10%">Sisa Pinjaman</th>
                                                        <th width="10%">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyPengembalian" class="form-group">
                                                </tbody>
                                                <tfoot id="tfootPengembalian">
                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="jlhPinjaman"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="ttlBayar"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="sisa"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold" id="nomBayar"></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold autonumeric" id="sisaPinjaman"></p>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="transfer-tab" data-toggle="tab" data-target="#transfer" type="button" role="tab" aria-controls="transfer" aria-selected="true">List Transfer</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="adjust-tab" data-toggle="tab" data-target="#adjust" type="button" role="tab" aria-controls="adjust" aria-selected="false">List Adjust Transfer</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="deposit-tab" data-toggle="tab" data-target="#deposit" type="button" role="tab" aria-controls="deposit" aria-selected="false">List Deposit</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pengembalian-tab" data-toggle="tab" data-target="#pengembalian" type="button" role="tab" aria-controls="pengembalian" aria-selected="false">List Pengembalian Pinjaman</button>
                                    </li>
                                </ul> -->
                                <!-- <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">

                                    </div>
                                    <div class="tab-pane fade" id="adjust" role="tabpanel" aria-labelledby="adjust-tab">

                                    </div>
                                    <div class="tab-pane fade" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">

                                    </div>
                                    <div class="tab-pane fade" id="pengembalian" role="tabpanel" aria-labelledby="pengembalian-tab">

                                    </div>
                                </div> -->
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-secondary" data-dismiss="modal">
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
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()

    $(document).ready(function() {

        $('#addRowTransfer').hide()
        $('#crudForm').autocomplete({
            disabled: true
        });

        $(document).on('click', "#addRowTransfer", function() {
            addRowTransfer()
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#detailTransfer #tbodyTransfer [name="nilaitransfer[]"]`, function(event) {
            setTotalTransfer()
        })
        $(document).on('input', `#detailPengembalian #tbodyPengembalian [name="nombayar[]"]`, function(event) {

            let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisa[]"]`)[0])

            let bayar = $(this).val()
            bayar = parseFloat(bayar.replaceAll(',', ''));
            bayar = Number.isNaN(bayar) ? 0 : bayar
            console.log(sisa)
            if (sisa == 0) {
                let jlhPinjaman = $(this).closest("tr").find(`[name="jlhpinjaman[]"]`).val()
                jlhPinjaman = parseFloat(jlhPinjaman.replaceAll(',', ''));
                let totalSisa = jlhPinjaman - bayar

                $(this).closest("tr").find(`[name="sisapinjaman[]"]`).val(totalSisa)
            } else {
                let totalSisa = sisa - bayar
                initAutoNumeric($(this).closest("tr").find(`[name="sisapinjaman[]"]`).val(totalSisa))
            }


            // initAutoNumeric($(this).closest("tr").find(".sisa"))

            // let Sisa = $(`#table_body .sisa`)
            // let total = 0

            // $.each(Sisa, (index, SISA) => {
            //     total += AutoNumeric.getNumber(SISA)
            // });

            // new AutoNumeric('#sisaPiutang').set(total)
            setNomBayar()
            setSisaPinjaman()
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            if (action == 'add') {
                $('#crudForm').find(`[name="nilaitransfer[]"]`).each((index, element) => {
                    data.filter((row) => row.name === 'nilaitransfer[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nilaitransfer[]"]`)[index])
                })
                data.filter((row) => row.name === 'nilaiadjust')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nilaiadjust"]`)[0])
                data.filter((row) => row.name === 'nilaideposit')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nilaideposit"]`)[0])
                $('#tbodyPengembalian tr').each(function(index, tr) {


                    if ($(this).find(`[name="pjt_id[]"]`).is(':checked')) {

                        data.filter((row) => row.name === 'keteranganpinjaman[]')[index].value = $(this).find(`[name="keteranganpinjaman[]"]`).val()
                        data.filter((row) => row.name === 'pjt_id[]')[index].value = $(this).find(`[name="pjt_id[]"]`).val()
                        data.filter((row) => row.name === 'nombayar[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nombayar[]"]`)[index])
                        data.filter((row) => row.name === 'pengeluarantruckingheader_nobukti[]')[index].value = $(this).find(`[name="pengeluarantruckingheader_nobukti[]"]`).val()


                    }
                })


            }

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
                    url = `${apiUrl}prosesuangjalansupirheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}prosesuangjalansupirheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}prosesuangjalansupirheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}prosesuangjalansupirheader`
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

                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON.message)
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

        setFormBindKeys(form)

        activeGrid = null

        $("#tabs").tabs();
        getMaxLength(form)
        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    // function setTotal() {
    //     let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    //     let total = 0

    //     $.each(nominalDetails, (index, nominalDetail) => {
    //         total += AutoNumeric.getNumber(nominalDetail)
    //     });

    //     new AutoNumeric('#total').set(total)
    // }

    function setTotalTransfer() {
        let nominalDetails = $(`#detailTransfer #tbodyTransfer [name="nilaitransfer[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#totalTransfer').set(total)
    }

    function setNomBayar() {
        let nominalDetails = $(`#detailPengembalian #tbodyPengembalian [name="nombayar[]"]:not([disabled])`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#nomBayar').set(total)
    }

    function setNomBayars() {
        let nominalDetails = $(`#detailPengembalian #tbodyPengembalian [name="nombayar[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#nomBayar').set(total)
    }

    function setSisaPinjaman() {
        let nominalDetails = $(`#detailPengembalian #tbodyPengembalian [name="sisapinjaman[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#sisaPinjaman').set(total)
    }

    function createProsesUangJalanSupir() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Create Proses Uang Jalan')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#table_body').html('')
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgladjust]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldeposit]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        addRowTransfer()
        $('#addRowTransfer').show()
        initAutoNumeric(form.find(`[name="nilaideposit"]`))

    }

    function editProsesUangJalanSupir(userId) {
        let form = $('#crudForm')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Proses Uang Jalan')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#detailTransfer').find("th").last().hide()
        $('#detailTransfer tfoot').find("td").last().hide()
        showProsesUangJalanSupir(form, userId)

    }

    function deleteProsesUangJalanSupir(userId) {
        let form = $('#crudForm')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Proses Uang Jalan')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        showProsesUangJalanSupir(form, userId)
    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}prosesuangjalansupirheader/${Id}/cekvalidasi`,
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
                        if (Aksi == 'EDIT') {
                            editProsesUangJalanSupir(Id)
                        }
                        if (Aksi == 'DELETE') {
                            deleteProsesUangJalanSupir(Id)
                        }
                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    function showProsesUangJalanSupir(form, userId) {
        $('#detailList tbody').html('')

        $.ajax({
            url: `${apiUrl}prosesuangjalansupirheader/${userId}`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
                $.each(response.data, (index, value) => {
                    let element = form.find(`[name="${index}"]`)
                    if (element.is('select')) {
                        element.val(value).trigger('change')
                    } else {
                        element.val(value)
                    }

                    if (index != 'id') {
                        element.prop('disabled', true)
                    }
                })

                form.find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
                form.find(`[name="supir"]`).val(response.data.supir)
                form.find(`[name="supir"]`).data('currentValue', response.data.supir)
                form.find(`[name="trado"]`).val(response.data.trado)
                form.find(`[name="trado"]`).data('currentValue', response.data.trado)

                $.each(response.detail.transfer, (index, detail) => {
                    let detailRow = $(`
                    <tr>
                        <td></td>
                        <td>
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <div class="input-group">
                                        <input type="text" name="tgltransfer[]" disabled class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <input type="text" name="keterangantransfer[]" class="form-control">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <input type="text" name="nilaitransfer[]" disabled class="form-control autonumeric">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <input type="hidden" name="bank_idtransfer[]">
                                    <input type="text" name="banktransfer[]" disabled class="form-control bank-lookup">
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div class="row form-group">
                                <div class="col-12 col-md-12">
                                    <input type="text" name="nobukti_kasbank[]" disabled class="form-control">
                                </div>
                            </div>
                        </td>
                    </tr>
                    `)

                    detailRow.find(`[name="tgltransfer[]"]`).val(dateFormat(detail.pengeluarantrucking_tglbukti))
                    detailRow.find(`[name="keterangantransfer[]"]`).val(detail.keterangan)
                    detailRow.find(`[name="nilaitransfer[]"]`).val(detail.nominal)
                    detailRow.find(`[name="banktransfer[]"]`).val(detail.bank)
                    detailRow.find(`[name="bank_idtransfer[]"]`).val(detail.pengeluarantrucking_bank_id)
                    detailRow.find(`[name="nobukti_kasbank[]"]`).val(detail.pengeluarantrucking_nobukti)

                    initAutoNumeric(detailRow.find(`[name="nilaitransfer[]"]`))
                    $('#detailTransfer #tbodyTransfer').append(detailRow)
                    initDatepicker()
                    setTotalTransfer()

                    $('.bank-lookup').last().lookup({
                        title: 'Bank Lookup',
                        fileName: 'bank',
                        beforeProcess: function(test) {
                            this.postData = {
                                Aktif: 'AKTIF',
                            }
                        },
                        onSelectRow: (bank, element) => {
                            element.parents('td').find(`[name="bank_idtransfer[]"]`).val(bank.id)
                            element.val(bank.namabank)
                            element.data('currentValue', element.val())
                        },
                        onCancel: (element) => {
                            element.val(element.data('currentValue'))
                        },
                        onClear: (element) => {
                            element.parents('td').find(`[name="bank_idtransfer[]"]`).val('')
                            element.val('')
                            element.data('currentValue', element.val())
                        }
                    })

                })

                setRowNumbers('#detailTransfer #tbodyTransfer')

                $.each(response.detail.adjust, (index, value) => {
                    let element = form.find(`[name="${index}"]`)
                    if (element.is('select')) {
                        element.val(value).trigger('change')
                    } else {
                        element.val(value)
                    }
                    if (index == 'keteranganadjust') {
                        element.prop('disabled', false)
                    } else {
                        element.prop('disabled', true)
                    }
                })

                if (response.detail.deposito == null) {
                    form.find('#deposit [name]').prop('disabled', true)
                } else {

                    $.each(response.detail.deposito, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }

                        if (index == 'keterangandeposit') {
                            element.prop('disabled', false)
                        } else {
                            element.prop('disabled', true)
                        }
                    })

                    initAutoNumeric(form.find(`[name="nilaideposit"]`))
                    form.find(`[name="tgldeposit"]`).val(dateFormat(response.detail.deposito.tgldeposit))
                    form.find(`[name="bankdeposit"]`).data('currentValue', response.detail.deposito.bankdeposit)
                }

                let totaljlhPinjaman = 0
                let totalttlBayar = 0
                let totalSisa = 0
                $.each(response.detail.pengembalian.detail, (index, detail) => {
                    totaljlhPinjaman = parseFloat(totaljlhPinjaman) + parseFloat(detail.jlhpinjaman)
                    totalttlBayar = parseFloat(totalttlBayar) + parseFloat(detail.totalbayar)
                    totalSisa = parseFloat(totalSisa) + parseFloat(detail.sisa)
                    let jlhpinjaman = new Intl.NumberFormat('en-US').format(detail.jlhpinjaman);
                    let totalbayar = new Intl.NumberFormat('en-US').format(detail.totalbayar);
                    let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
                    let checked
                    let disabled
                    // if (detail.pengeluarantruckingheader_nobukti != null) {
                    //     checked = 'checked'
                    // } else {
                    //     disabled = 'disabled'
                    // }

                    let detailRow = $(`
                    <tr >
                        <td><input name='pjt_id[]' type="checkbox" id="checkItem" value="${detail.id}" checked disabled></td>
                    
                        <td>${detail.nobukti}</td>
                        <td>${detail.tglbukti}</td>
                        <td>${detail.namasupir}</td>
                        <td>
                            <p class="text-right">${jlhpinjaman}</p>
                            <input type="hidden" name="jlhpinjaman[]" class="autonumeric" value="${detail.jlhpinjaman}">
                        </td>
                        <td>
                            <p class="text-right">${totalbayar}</p>
                            <input type="hidden" name="totalbayar[]" class="autonumeric" value="${totalbayar}">
                        </td>
                        <td>
                            <p class="text-right sisa autonumeric">${sisa}</p>
                            <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
                        </td>
                        <td>
                            <input type="hidden" name="pengeluarantruckingheader_nobukti[]" value="${detail.nobukti}">
                            <input type="text" name="nombayar[]" disabled class="form-control text-right" value="${detail.nominal}">
                        </td>
                        <td>
                            <input type="text" name="sisapinjaman[]" disabled class="form-control text-right" value="${detail.sisa}">
                        </td>
                        <td>
                            <textarea name="keteranganpinjaman[]" rows="1" disabled class="form-control">${(detail.keterangan == null) ? '' : detail.keterangan}</textarea>
                        </td>
                    </tr>
                    `)

                    initAutoNumeric(detailRow.find(`[name="jlhpinjaman[]"]`))
                    initAutoNumeric(detailRow.find(`[name="totalbayar[]"]`))
                    initAutoNumeric(detailRow.find(`[name="nombayar[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisapinjaman[]"]`))
                    initAutoNumeric(detailRow.find('.sisa'))
                    initAutoNumeric(detailRow.find('.totalbayar'))
                    initAutoNumeric(detailRow.find('.jlhpinjaman'))

                    $('#detailPengembalian #tbodyPengembalian').append(detailRow)

                    setNomBayars()
                    setSisaPinjaman()
                })


                $('#jlhPinjaman').append(`${totaljlhPinjaman}`)
                initAutoNumeric($('#detailPengembalian tfoot').find('#jlhPinjaman'))
                $('#ttlBayar').append(`${totalttlBayar}`)
                initAutoNumeric($('#detailPengembalian tfoot').find('#ttlBayar'))
                $('#sisa').append(`${totalSisa}`)
                initAutoNumeric($('#detailPengembalian tfoot').find('#sisa'))
                initAutoNumeric(form.find(`[name="nilaiadjust"]`))
                form.find(`[name="tgladjust"]`).val(dateFormat(response.detail.adjust.tgladjust))
                form.find(`[name="bankadjust"]`).data('currentValue', response.detail.adjust.bankadjust)

                if (response.detail.pengembalian.bank != null) {
                    form.find(`[name="bank_idpengembalian"]`).val(response.detail.pengembalian.bank.bank_idpengembalian)
                    form.find(`[name="bankpengembalian"]`).val(response.detail.pengembalian.bank.bankpengembalian).prop('disabled', true)
                    form.find(`[name="bankpengembalian"]`).data('currentValue', response.detail.pengembalian.bank.bankpengembalian)

                } else {
                    form.find('#pengembalian [name]').prop('disabled', true)
                }



                if (form.data('action') === 'delete') {
                    form.find('[name]').addClass('disabled')
                    initDisabled()
                }
            }
        })
    }

    function addRowTransfer() {
        let detailRow = $(`
        <tr>
            <td></td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <div class="input-group">
                            <input type="text" name="tgltransfer[]" class="form-control datepicker">
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="text" name="keterangantransfer[]" class="form-control">
                    </div>
                </div>
            </td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="text" name="nilaitransfer[]" class="form-control autonumeric">
                    </div>
                </div>
            </td>
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="hidden" name="bank_idtransfer[]">
                        <input type="text" name="banktransfer[]" class="form-control bank-lookup">
                    </div>
                </div>
            </td>
            
            <td>
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <input type="text" name="nobukti_kasbank[]" readonly class="form-control">
                    </div>
                </div>
            </td>
            <td>
                <div class="btn btn-danger btn-sm delete-row">HAPUS</div>
            </td>
        </tr>
        `)


        $('#detailTransfer #tbodyTransfer').append(detailRow)
        $('.bank-lookup').last().lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $(`#crudForm [name="bank_idtransfer[]"]`).last().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $(`#crudForm [name="bank_idtransfer[]"]`).last().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('#crudForm').find(`[name="tgltransfer[]"]`).val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        initDatepicker();
        initAutoNumeric(detailRow.find('.autonumeric'))
        setTotalTransfer()
        setRowNumbers('#detailTransfer #tbodyTransfer')
    }

    function getPinjaman(supirId) {
        $('#detailPengembalian #tbodyPengembalian').html('')
        $('#detailPengembalian #tfootPengembalian #jlhPinjaman').html('')
        $('#detailPengembalian #tfootPengembalian #ttlBayar').html('')
        $('#detailPengembalian #tfootPengembalian #sisa').html('')

        $.ajax({
            url: `${apiUrl}prosesuangjalansupirheader/${supirId}/getPinjaman`,
            method: 'GET',
            dataType: 'JSON',
            data: {
                limit: 0
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

                let totaljlhPinjaman = 0
                let totalttlBayar = 0
                let totalSisa = 0
                $.each(response.data, (index, detail) => {

                    let ttlbyr = (detail.totalbayar != null) ? parseFloat(detail.totalbayar) : 0;
                    let sisabyr = (detail.sisa != null) ? parseFloat(detail.sisa) : 0;
                    totaljlhPinjaman = parseFloat(totaljlhPinjaman) + parseFloat(detail.jlhpinjaman)
                    totalttlBayar = parseFloat(totalttlBayar) + ttlbyr;
                    totalSisa = parseFloat(totalSisa) + sisabyr

                    let jlhpinjaman = new Intl.NumberFormat('en-US').format(detail.jlhpinjaman);
                    let totalbayar = new Intl.NumberFormat('en-US').format(detail.totalbayar);
                    let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

                    let detailRow = $(`
                    <tr >
                    <td><input name='pjt_id[]' type="checkbox" id="checkItem" value="${detail.id}"></td>
                    
                    <td>${detail.nobukti}</td>
                    <td>${detail.tglbukti}</td>
                    <td>${detail.namasupir}</td>
                    <td>
                        <p class="text-right">${jlhpinjaman}</p>
                        <input type="hidden" name="jlhpinjaman[]" class="autonumeric" value="${jlhpinjaman}">
                    </td>
                    <td>
                        <p class="text-right">${totalbayar}</p>
                        <input type="hidden" name="totalbayar[]" class="autonumeric" value="${totalbayar}">
                    </td>
                    <td>
                        <p class="text-right sisa autonumeric">${sisa}</p>
                        <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
                    </td>
                    <td id='${detail.id}'>
                        <input type="hidden" name="pengeluarantruckingheader_nobukti[]" value="${detail.nobukti}">
                        <input type="text" name="nombayar[]" disabled class="form-control text-right">
                    </td>
                    <td>
                        <input type="text" name="sisapinjaman[]" disabled class="form-control text-right" value="${sisa}">
                    </td>
                    <td>
                        <textarea name="keteranganpinjaman[]" rows="1" disabled class="form-control"></textarea>
                    </td>
                    </tr>
                `)

                    initAutoNumeric(detailRow.find(`[name="jlhpinjaman[]"]`))
                    initAutoNumeric(detailRow.find(`[name="totalbayar[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
                    initAutoNumeric(detailRow.find(`[name="sisapinjaman[]"]`))
                    initAutoNumeric(detailRow.find('.sisa'))
                    initAutoNumeric(detailRow.find('.totalbayar'))
                    initAutoNumeric(detailRow.find('.jlhpinjaman'))

                    $('#detailPengembalian #tbodyPengembalian').append(detailRow)

                    setNomBayar()
                    setSisaPinjaman()
                })

                $('#jlhPinjaman').append(`${totaljlhPinjaman}`)
                initAutoNumeric($('#detailPengembalian tfoot').find('#jlhPinjaman'))
                $('#ttlBayar').append(`${totalttlBayar}`)
                console.log(totalttlBayar)
                console.log(totalSisa)
                initAutoNumeric($('#detailPengembalian tfoot').find('#ttlBayar'))
                $('#sisa').append(`${totalSisa}`)
                initAutoNumeric($('#detailPengembalian tfoot').find('#sisa'))
            }
        })


    }
    $(document).on('click', `#detailPengembalian #tbodyPengembalian [name="pjt_id[]"]`, function() {

        if ($(this).prop("checked") == true) {

            id = $(this).val()
            $(this).closest('tr').find(`td [name="nombayar[]"]`).prop('disabled', false)
            // $(this).closest('tr').find(`td [name="sisapinjaman[]"]`).prop('disabled', false)
            $(this).closest('tr').find(`td [name="keteranganpinjaman[]"]`).prop('disabled', false)

            let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisa[]"]`)[0])
            initAutoNumeric($(this).closest('tr').find(`td [name="nombayar[]"]`).val(sisa))
            let sisapinjaman = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisapinjaman[]"]`)[0])

            setNomBayar()
            setSisaPinjaman()
        } else {

            let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisa[]"]`)[0])
            initAutoNumeric($(this).closest('tr').find(`td [name="sisapinjaman[]"]`).val(sisa))
            let id = $(this).val()

            $(this).closest('tr').find(`td [name="keteranganpinjaman[]"]`).prop('disabled', true)
            $(this).closest('tr').find(`td [name="nombayar[]"]`).remove();
            let newNomBayarElement = `<input type="text" name="nombayar[]" disabled class="form-control text-right">`;
            $(this).closest('tr').find(`#${id}`).append(newNomBayarElement)
            // $(this).closest('tr').find(`td [name="nombayar[]"]`).removeData('autonumeric');
            setNomBayar()
            setSisaPinjaman()
        }
    })

    function deleteRow(row) {
        row.remove()

        setRowNumbers()
        // setTotal()
        setTotalTransfer()
    }

    function setRowNumbers(attr) {
        let elements = $(`${attr} tr td:nth-child(1)`)

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}piutangheader/field_length`,
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

    function initLookup() {
        $('.absensisupir-lookup').lookup({
            title: 'Abensi Supir Lookup',
            fileName: 'absensisupir',

            onSelectRow: (absensisupir, element) => {
                element.val(absensisupir.nobukti)

                $('#crudForm [name=nilaiadjust]').first().val(absensisupir.nominal)
                initAutoNumeric($('#crudForm [name=nilaiadjust]'))
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.supir-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supir_id]').first().val(supir.id)
                getPinjaman(supir.id)
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

        $('.bankadjust-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idadjust]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_idadjust"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })

        $('.bankdeposit-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_iddeposit]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_iddeposit"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bankpengembalian-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_idpengembalian]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_idpengembalian"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
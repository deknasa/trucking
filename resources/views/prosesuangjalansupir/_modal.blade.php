<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="crudModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                                        ABSENSI SUPIR <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="absensisupir" class="form-control absensisupir-lookup">
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
                                    <input type="text" name="supir" class="form-control supir-lookup">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-12 col-md-2 col-form-label">
                                    <label>
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
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
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
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
                                        <div class="table-responsive">
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
                                                            <p class="text-right font-weight-bold autonumeric" id="total"></p>
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
                                    <div class="tab-pane fade" id="adjust" role="tabpanel" aria-labelledby="adjust-tab">
                                        <div class="row form-group mt-3">
                                            <div class="col-md-2 col-form-label">
                                                <label>
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
                                            <div class="col-md-2 col-form-label">
                                                <label>
                                                    NILAI ADJUST TRANSFER
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nilaiadjust" class="form-control autonumeric">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 col-form-label">
                                                <label>
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
                                                <div class="col-12 col-md-2 col-form-label">
                                                    <label>
                                                        POSTING
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="hidden" name="bank_idadjust">
                                                    <input type="text" name="bankadjust" class="form-control bankadjust-lookup">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-2 col-form-label">
                                                    <label>
                                                        NO BUKTI BARU
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">

                                        <div class="row form-group mt-3">
                                            <div class="col-md-2 col-form-label">
                                                <label>
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
                                            <div class="col-md-2 col-form-label">
                                                <label>
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
                                            <div class="col-md-2 col-form-label">
                                                <label>
                                                    NILAI DEPOSIT
                                                </label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <input type="text" name="nilaideposit" class="form-control autonumeric">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-2 col-form-label">
                                                <label>
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
                                                <div class="col-12 col-md-2 col-form-label">
                                                    <label>
                                                        POSTING
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="hidden" name="bank_iddeposit">
                                                    <input type="text" name="bankdeposit" class="form-control bankdeposit-lookup">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-12 col-md-2 col-form-label">
                                                    <label>
                                                        NO BUKTI BARU
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pengembalian" role="tabpanel" aria-labelledby="pengembalian-tab">
                                        <!-- <div class="row form-group mt-3">
                                            <div class="col-12 col-md-2 col-form-label">
                                                <label>
                                                    POSTING
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="hidden" name="bank_idpengembalian">
                                                <input type="text" name="bankpengembalian" class="form-control bankpengembalian-lookup">
                                            </div>
                                        </div> 
                                        <div class="row form-group">
                                            <div class="col-12 col-md-2 col-form-label">
                                                <label>
                                                    KETERANGAN
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="text" name="keteranganpengembalian" class="form-control">
                                            </div>
                                        </div> -->
                                        <!-- <div class="table-responsive">
                                            <table class="table table-bordered table-bindkeys" id="detailPengembalian" style="width:1450px;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="15%">No Bukti</th>
                                                        <th width="10%">Tgl Bukti</th>
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
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <p class="text-right font-weight-bold">TOTAL :</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right font-weight-bold autonumeric" id="total"></p>
                                                        </td>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div> -->
                                    </div>
                                </div>
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

        $('#crudForm').autocomplete({
            disabled: true
        });

        $(document).on('click', "#addRowTransfer", function() {
            addRowTransfer()
        });
        $(document).on('click', "#addRow", function() {
            addRow()
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
            setTotal()
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            $('#crudForm').find(`[name="nilaitransfer[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'nilaitransfer[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nilaitransfer[]"]`)[index])
            })
            data.filter((row) => row.name === 'nilaiadjust')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nilaiadjust"]`)[0])
            data.filter((row) => row.name === 'nilaideposit')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nilaideposit"]`)[0])
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
                    url = `${apiUrl}prosesuangjalansupirheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}prosesuangjalansupirheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}prosesuangjalansupirheader/${Id}`
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

    function setTotal() {
        let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#total').set(total)
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
        setTotal()
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
            url: `{{ config('app.api_url') }}piutangheader/${Id}/cekvalidasi`,
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
            url: `${apiUrl}piutangheader/${userId}`,
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

                })

                form.find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
                form.find(`[name="agen"]`).val(response.data.agen.namaagen)
                form.find(`[name="agen"]`).data('currentValue', response.data.agen.namaagen)

                $.each(response.data.piutang_details, (index, detail) => {
                    let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <input type="text" name="keterangan_detail[]" class="form-control">
              </td>
              <td>
                <input type="text" name="nominal_detail[]" class="form-control nominal autonumeric">
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">HAPUS</button>
              </td>
            </tr>
          `)

                    detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                    detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)

                    initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
                    $('#detailList tbody').append(detailRow)
                    setTotal()
                })

                setRowNumbers()

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

        setRowNumbers('#detailTransfer #tbodyTransfer')
    }

    
    function deleteRow(row) {
        row.remove()

        setRowNumbers()
        setTotal()
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
                element.val(trado.keterangan)
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
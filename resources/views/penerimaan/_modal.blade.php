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
                        <input type="hidden" name="id">

                        <div class="row form-group">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    NO BUKTI <span class="text-danger"></span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="text" name="nobukti" class="form-control" readonly>
                            </div>

                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL BUKTI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    PELANGGAN <span class="text-danger"></span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="pelanggan_id">
                                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    DITERIMA DARI
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="diterimadari" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    TGL LUNAS <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgllunas" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        {{--<div class="row form-group">
                             <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    CABANG <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="cabang_id">
                                <input type="text" name="cabang" class="form-control cabang-lookup">
                            </div>
                        </div>--}}

                        {{-- <div class="row form-group">
                         <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS KAS <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="statuskas" class="form-select select2bs4" style="width: 100%;">
                                    <option value="">-- PILIH STATUS KAS --</option>
                                </select>
                            </div>
                        </div>--}}


                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    BANK <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="bank_id">
                                <input type="text" name="bank" class="form-control bank-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    No Bukti Penerimaan Giro</label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="penerimaangiro_nobukti" class="form-control penerimaangiro-lookup">
                            </div>
                        </div>

                        {{-- <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    NO RESI
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="noresi" class="form-control">
                            </div>
                        </div>--}}

                        <div class="table-responsive table-scroll">
                            <table class="table table-bordered table-bindkeys" id="detailList" style="width:2010px;">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="5%">Nama Perkiraan</th>
                                        <th width="4%">Tgl jatuh tempo</th>
                                        <th width="4%">No warkat</th>
                                        <th width="7%">Bank Pelanggan</th>
                                        <th width="10%">Keterangan</th>
                                        <th width="6%">Nominal</th>
                                        <th width="1%" class="aksiGiro">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body" class="form-group">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <p class="text-right font-weight-bold">TOTAL :</p>
                                        </td>
                                        <td>
                                            <p class="text-right font-weight-bold autonumeric" id="total"></p>
                                        </td>
                                        <td class="aksiGiro">
                                            <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
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
    let type
    let penerimaanGiro = ''
    $(document).ready(function() {

        $("#crudForm [name]").attr("autocomplete", "off");
        $(document).on('change', '[name=statuskas]', function() {
            if ($(this).val() == 116) {
                type = 'kas'
            } else if ($(this).val() == 117) {
                type = 'bank'
            } else {
                type = null
            }
        })
        $(document).on('click', "#addRow", function() {
            addRow()
        });
        $(document).on('change', `#crudForm [name="tgllunas"]`, function() {
            $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($(this).val()).trigger('change');
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
            $('#crudForm').find(`[name="nominal_detail[]"`).each((index, element) => {
                data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
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

            data.push({
                name: 'bankheader',
                value: data.find(item => item.name === "bank_id").value
            })
            let tgldariheader = $('#tgldariheader').val();
            let tglsampaiheader = $('#tglsampaiheader').val()
            let bankheader = data.find(item => item.name === "bank_id").value

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}penerimaanheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}penerimaanheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}penerimaanheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&bankheader=${bankheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}penerimaanheader`
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
                    $('#crudModal').modal('hide')
                    $('#crudModal').find('#crudForm').trigger('reset')
                    penerimaanGiro = ''

                    $('#bankheader').val(response.data.bank_id).trigger('change')

                    $('.select2').select2({
                        width: 'resolve',
                        theme: "bootstrap4"
                    });
                    $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
                    $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            bank: response.data.bank_id,
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
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        setErrorMessages(form, error.responseJSON.errors);
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
        setFormBindKeys(form)
        activeGrid = null
        getMaxLength(form)
        initLookup()
        initSelect2(form.find('.select2bs4'), true)
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

    function select(element) {
        alert(element)
    }

    function createPenerimaan() {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        penerimaanGiro = ''
        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Penerimaan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgllunas]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#table_body').html('')
        addRow();
        initAutoNumeric(form.find('.nominal'))

        Promise
            .all([
                setStatusKasOptions(form)
            ])
            .then(() => {
                showDefault(form)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
                    .catch((error) => {
                        showDialog(error.responseJSON)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
        setTotal()
    }


    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}penerimaanheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    bank_id: $('#bankheader').val(),
                },
                success: response => {
                    bankId = response.data.bank_id

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

    function editPenerimaan(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        form.data('action', 'edit')
        penerimaanGiro = ''
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        $('#crudModalTitle').text('Edit Penerimaan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                setStatusKasOptions(form)
            ])
            .then(() => {
                showPenerimaan(form, id)
                    .then(() => {
                        clearSelectedRows()
                        $('#gs_').prop('checked', false)
                        $('#crudModal').modal('show')

                        $('#crudForm [name=tgllunas]').attr('readonly', true)
                        $('#crudForm [name=tgllunas]').siblings('.input-group-append').remove()
                        $('#crudForm [name=bank]').parent('.input-group').find('.button-clear').remove()
                        $('#crudForm [name=bank]').parent('.input-group').find('.input-group-append').remove()
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function deletePenerimaan(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        form.data('action', 'delete')
        penerimaanGiro = ''
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        $('#crudModalTitle').text('Delete Penerimaan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                setStatusKasOptions(form)
            ])
            .then(() => {
                showPenerimaan(form, id)
                    .then(() => {
                        clearSelectedRows()
                        $('#gs_').prop('checked', false)
                        $('#crudModal').modal('show')
                        $('#crudForm [name=tglbukti]').attr('readonly', true)
                        $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
                        $('#crudForm [name=tgllunas]').attr('readonly', true)
                        $('#crudForm [name=tgllunas]').siblings('.input-group-append').remove()
                        $('#crudForm [name=bank]').parent('.input-group').find('.button-clear').remove()
                        $('#crudForm [name=bank]').parent('.input-group').find('.input-group-append').remove()
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}penerimaanheader/${Id}/cekvalidasi`,
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
            url: `{{ config('app.api_url') }}penerimaanheader/${Id}/cekValidasiAksi`,
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
                        editPenerimaan(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deletePenerimaan(Id)
                    }
                }

            }
        })
    }

    const setStatusKasOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statuskas]').empty()
            relatedForm.find('[name=statuskas]').append(
                new Option('-- PILIH STATUS KAS --', '', false, true)
            ).trigger('change')
            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    limit: 0,
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS KAS"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusKas => {
                        let option = new Option(statusKas.text, statusKas.id)
                        relatedForm.find('[name=statuskas]').append(option).trigger('change')
                    });
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function showPenerimaan(form, id) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')


            $.ajax({
                url: `${apiUrl}penerimaanheader/${id}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    let tgl = response.data.tglbukti
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }
                        if (index == 'pelanggan') {
                            element.data('current-value', value)
                        }
                        if (index == 'cabang') {
                            element.data('current-value', value)
                        }
                        if (index == 'bank') {
                            element.data('current-value', value).prop('readonly', true)
                        }
                        if (index == 'penerimaangiro_nobukti') {
                            element.data('current-value', value)
                        }
                    })
                    if (response.data.penerimaangiro_nobukti == '') {
                        $('#detailList tbody').html('')
                        $.each(response.detail, (index, detail) => {
                            let readOnly = (detail.pelunasanpiutang_nobukti != '-') ? 'readonly' : '';
                            let detailRow = $(`
                        <tr class="${detail.pelunasanpiutang_nobukti}">
                            <td></td>
                            <td>
                                <input type="hidden" name="coakredit[]">
                                <input type="text" name="ketcoakredit[]" data-current-value="${detail.ketcoakredit}" class="form-control akunpusat-lookup">
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
                                </div>
                            </td>
                            <td>
                                <input type="text" name="nowarkat[]"  class="form-control">
                            </td>
                            <td>
                                <input type="hidden" name="bankpelanggan_id[]">
                                <input type="text" name="bankpelanggan[]" data-current-value="${detail.bankpelanggan}" class="form-control bankpelanggan-lookup">
                            </td>
                            <td>
                                <input type="text" name="keterangan_detail[]"  class="form-control" ${readOnly}>
                            </td>
                            <td>
                                <input type="text" name="nominal_detail[]" class="form-control autonumeric"  ${readOnly}> 
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                            </td>
                        </tr>
                        `)

                            detailRow.find(`[name="coakredit[]"]`).val(detail.coakredit)
                            detailRow.find(`[name="ketcoakredit[]"]`).val(detail.ketcoakredit)
                            detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
                            detailRow.find(`[name="bankpelanggan_id[]"]`).val(detail.bankpelanggan_id)
                            detailRow.find(`[name="bankpelanggan[]"]`).val(detail.bankpelanggan)
                            detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                            detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
                            initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
                            detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                            detailRow.find(`[name="bulanbeban[]"]`).val(dateFormat(detail.bulanbeban))
                            $('#detailList tbody').append(detailRow)
                            setTotal();
                            $('.akunpusat-lookup').last().lookup({
                                title: 'Kode Perk. Lookup',
                                fileName: 'akunpusat',
                                beforeProcess: function(test) {
                                    // var levelcoa = $(`#levelcoa`).val();
                                    this.postData = {
                                        levelCoa: '3',
                                        Aktif: 'AKTIF',
                                    }
                                },
                                onSelectRow: (akunpusat, element) => {
                                    element.parents('td').find(`[name="coakredit[]"]`).val(akunpusat.coa)
                                    element.val(akunpusat.keterangancoa)
                                    element.data('currentValue', element.val())
                                },
                                onCancel: (element) => {
                                    element.val(element.data('currentValue'))
                                },
                                onClear: (element) => {

                                    element.parents('td').find(`[name="coakredit[]"]`).val('')
                                    element.val('')
                                    element.data('currentValue', element.val())
                                }
                            })
                            $('.bankpelanggan-lookup').last().lookup({
                                title: 'Bank Pelanggan Lookup',
                                fileName: 'bankpelanggan',
                                beforeProcess: function(test) {
                                    this.postData = {
                                        Aktif: 'AKTIF',
                                    }
                                },
                                onSelectRow: (bankpelanggan, element) => {
                                    element.parents('td').find(`[name="bankpelanggan_id[]"]`).val(bankpelanggan.id)
                                    element.val(bankpelanggan.namabank)
                                    element.data('currentValue', element.val())
                                },
                                onCancel: (element) => {
                                    element.val(element.data('currentValue'))
                                },
                                onClear: (element) => {
                                    element.parents('td').find(`[name="bankpelanggan_id[]"]`).val('')
                                    element.val('')
                                    element.data('currentValue', element.val())
                                }
                            })
                        })
                    } else {
                        penerimaanGiro = response.data.penerimaangiro_nobukti;
                        $('.aksiGiro').hide()
                        $('#detailList tbody').html('')
                        $.each(response.detail, (index, detail) => {

                            let detailRow = $(`
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="hidden" name="coakredit[]">
                                        <input type="text" name="ketcoakredit[]" data-current-value="${detail.ketcoakredit}" class="form-control akunpusat-lookup" readonly>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" name="tgljatuhtempo[]" class="form-control" readonly>   
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="nowarkat[]"  class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="hidden" name="bankpelanggan_id[]">
                                        <input type="text" name="bankpelanggan[]" data-current-value="${detail.bankpelanggan}" class="form-control bankpelanggan-lookup" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="keterangan_detail[]"  class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="nominal_detail[]" class="form-control autonumeric"  readonly> 
                                    </td>
                                </tr>
                                `)

                            detailRow.find(`[name="coakredit[]"]`).val(detail.coakredit)
                            detailRow.find(`[name="ketcoakredit[]"]`).val(detail.ketcoakredit)
                            detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
                            detailRow.find(`[name="bankpelanggan_id[]"]`).val(detail.bankpelanggan_id)
                            detailRow.find(`[name="bankpelanggan[]"]`).val(detail.bankpelanggan)
                            detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                            detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
                            initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
                            detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                            detailRow.find(`[name="bulanbeban[]"]`).val(dateFormat(detail.bulanbeban))
                            $('#detailList tbody').append(detailRow)
                            setTotal();

                        })
                    }

                    setRowNumbers()
                    initDatepicker()
                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function addRow() {
        let detailRow = $(`
      <tr>
        <td></td>
        <td>
            <input type="hidden" name="coakredit[]">
          <input type="text" name="ketcoakredit[]"  class="form-control akunpusat-lookup">
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
          </div>
        </td>
        <td>
          <input type="text" name="nowarkat[]"  class="form-control">
        </td>
        <td>
            <input type="hidden" name="bankpelanggan_id[]">
            <input type="text" name="bankpelanggan[]"  class="form-control bankpelanggan-lookup">
        </td>
        <td>
          <input type="text" name="keterangan_detail[]"  class="form-control">
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control autonumeric"> 
        </td>
        <td class="aksiGiro">
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)
        $('#detailList tbody').append(detailRow)
        $('.akunpusat-lookup').last().lookup({
            title: 'Kode Perkiraan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                    levelCoa: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (akunpusat, element) => {
                element.parents('td').find(`[name="coakredit[]"]`).val(akunpusat.coa)
                element.val(akunpusat.keterangancoa)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.parents('td').find(`[name="coakredit[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bankpelanggan-lookup').last().lookup({
            title: 'Bank Pelanggan Lookup',
            fileName: 'bankpelanggan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bankpelanggan, element) => {
                $(`#crudForm [name="bankpelanggan_id[]"]`).last().val(bankpelanggan.id)
                element.val(bankpelanggan.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $(`#crudForm [name="bankpelanggan_id[]"]`).last().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        initAutoNumeric(detailRow.find('.autonumeric'))
        tgllunas = $('#crudForm').find(`[name="tgllunas"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tgllunas).trigger('change');
        initDatepicker()
        setRowNumbers()
    }

    function deleteRow(row) {
        row.remove()
        setRowNumbers()
        setTotal()
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')
        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function approve() {

        event.preventDefault()

        let form = $('#crudForm')
        $(this).attr('disabled', '')
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}penerimaanheader/approval`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                penerimaanId: selectedRows
            },
            success: response => {
                $('#crudForm').trigger('reset')
                penerimaanGiro = ''

                $('#crudModal').modal('hide')

                $('#jqGrid').jqGrid().trigger('reloadGrid');
                selectedRows = []
                $('#gs_').prop('checked', false)
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
            $('#processingLoader').addClass('d-none')
            $(this).removeAttr('disabled')
        })

    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}pengeluaranheader/field_length`,
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
        $('.pelanggan-lookup').lookup({
            title: 'Pelanggan Lookup',
            fileName: 'pelanggan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (pelanggan, element) => {
                $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
                element.val(pelanggan.namapelanggan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="pelanggan_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.cabang-lookup').lookup({
            title: 'Cabang Lookup',
            fileName: 'cabang',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (cabang, element) => {
                $('#crudForm [name=cabang_id]').first().val(cabang.id)
                element.val(cabang.namacabang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="cabang_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.bank-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "tipe",
                            "op": "cn",
                            "data": type
                        }]
                    }),
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_id]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="bank_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.penerimaangiro-lookup').lookup({
            title: 'Penerimaan Giro Lookup',
            fileName: 'penerimaangiro',
            beforeProcess: function(test) {
                this.postData = {
                    nobukti: penerimaanGiro,
                }
            },
            onSelectRow: (penerimaanGiro, element) => {
                $('#table_body').html('')
                $('.aksiGiro').hide()
                element.val(penerimaanGiro.nobukti)
                getPenerimaanGiro(penerimaanGiro.id)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('.aksiGiro').show()
                $('#table_body').html('')
                addRow();
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function getPenerimaanGiro(giroId) {
        $.ajax({
            url: `${apiUrl}penerimaangirodetail/getDetail`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            },
            data: {
                penerimaangiro_id: giroId
            },
            success: response => {
                $.each(response.data, (index, detail) => {

                    let detailRow = $(`
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" name="coakredit[]">
                                <input type="text" name="ketcoakredit[]" data-current-value="${detail.ketcoakredit}" class="form-control akunpusat-lookup" readonly>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="tgljatuhtempo[]" class="form-control" readonly>   
                                </div>
                            </td>
                            <td>
                                <input type="text" name="nowarkat[]"  class="form-control" readonly>
                            </td>
                            <td>
                                <input type="hidden" name="bankpelanggan_id[]">
                                <input type="text" name="bankpelanggan[]" data-current-value="${detail.bankpelanggan}" class="form-control bankpelanggan-lookup" readonly>
                            </td>
                            <td>
                                <input type="text" name="keterangan_detail[]"  class="form-control" readonly>
                            </td>
                            <td>
                                <input type="text" name="nominal_detail[]" class="form-control autonumeric"  readonly> 
                            </td>
                        </tr>
                        `)

                    detailRow.find(`[name="coakredit[]"]`).val(detail.coakredit)
                    detailRow.find(`[name="ketcoakredit[]"]`).val(detail.ketcoakredit)
                    detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
                    detailRow.find(`[name="bankpelanggan_id[]"]`).val(detail.bankpelanggan_id)
                    detailRow.find(`[name="bankpelanggan[]"]`).val(detail.bankpelanggan)
                    detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                    detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
                    initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
                    detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                    detailRow.find(`[name="bulanbeban[]"]`).val(dateFormat(detail.bulanbeban))
                    $('#detailList tbody').append(detailRow)
                    setTotal();

                })
                setRowNumbers()
            },
            error: error => {
                showDialog(error.statusText)
            }
        })
    }
</script>
@endpush()
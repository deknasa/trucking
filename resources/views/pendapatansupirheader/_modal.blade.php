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
                                    TGL DARI <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgldari" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    TGL SAMPAI <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglsampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    PERIODE <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive table-scroll">
                            <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1200px;">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="40%">SUPIR</th>
                                        <th width="40%">KETERANGAN</th>
                                        <th width="18%">NOMINAL</th>
                                        <th width="1%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body" class="form-group">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <p class="text-right font-weight-bold">TOTAL :</p>
                                        </td>
                                        <td>
                                            <p class="text-right font-weight-bold autonumeric" id="total"></p>
                                        </td>
                                        <td>
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

    $(document).ready(function() {

        $('#crudForm').autocomplete({
            disabled: true
        });

        $(document).on('click', "#addRow", function() {
            addRow()
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
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

            $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
                data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
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
                    url = `${apiUrl}pendapatansupirheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}pendapatansupirheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}pendapatansupirheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}pendapatansupirheader`
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
                        if (error.responseJSON.errors) {
                            showDialog(error.statusText, error.responseJSON.errors.join('<hr>'))
                        } else if (error.responseJSON.message) {
                            showDialog(error.statusText, error.responseJSON.message)
                        } else {
                            showDialog(error.statusText, error.statusText)
                        }
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
        initDatepicker()
        initLookup()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function setTotal() {
        let nominalDetails = $(`#table_body [name="nominal[]"]`)
        let total = 0

        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        new AutoNumeric('#total').set(total)
    }

    function createPendapatanSupir() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')

        $('#crudModalTitle').text('Add Pendapatan Supir')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()


        $('#table_body').html('')
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        addRow()
        setTotal()
    }

    function editPendapatanSupir(pendapatanId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        $('#crudModalTitle').text('Edit Pendapatan Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPendapatanSupir(form, pendapatanId)
            ])
            .then(() => {
                clearSelectedRows()
                $('#gs_').prop('checked', false)
                $('#crudModal').modal('show')
                form.find('[name=tglbukti]').attr('readonly', true)
                form.find('[name=tglbukti]').siblings('.input-group-append').remove()
                form.find('[name=tgldari]').attr('readonly', true)
                form.find('[name=tgldari]').siblings('.input-group-append').remove()
                form.find('[name=tglsampai]').attr('readonly', true)
                form.find('[name=tglsampai]').siblings('.input-group-append').remove()
                form.find('[name=periode]').attr('readonly', true)
                form.find('[name=periode]').siblings('.input-group-append').remove()
                form.find('[name=bank]').attr('readonly', true)
                form.find('[name=bank]').siblings('.input-group-append').remove()
                form.find('[name=bank]').siblings('.button-clear').remove()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deletePendapatanSupir(pendapatanId) {

        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        $('#crudModalTitle').text('Delete Pendapatan Supir')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPendapatanSupir(form, pendapatanId)
            ])
            .then(() => {
                clearSelectedRows()
                $('#gs_').prop('checked', false)
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }


    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}pendapatansupirheader/${Id}/cekvalidasi`,
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
                            editPendapatanSupir(Id)
                        }
                        if (Aksi == 'DELETE') {
                            deletePendapatanSupir(Id)
                        }
                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    function showPendapatanSupir(form, pendapatanId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

            $.ajax({
            url: `${apiUrl}pendapatansupirheader/${pendapatanId}`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
            Authorization: `Bearer ${accessToken}`
            },
            success: response => {
            $.each(response.data, (index, value) => {
                let element = form.find(`[name="${index}"]`)

                if (element.hasClass('datepicker')) {
                    element.val(dateFormat(value))
                } else {
                    element.val(value)
                }
            })
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
                let detailRow = $(`
                    <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="supir_id[]">
                        <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                    </td>
                    <td>
                        <input type="text" name="keterangan_detail[]" class="form-control">   
                    </td>
                    <td>
                        <input type="text" name="nominal[]"  style="text-align:right" class="form-control autonumeric nominal" > 
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                    </td>
                    </tr>
                `)

                detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
                detailRow.find(`[name="supir[]"]`).val(detail.supir)
                detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
                detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

                initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
                $('#detailList tbody').append(detailRow)
                setTotal();

                $('.supir-lookup').last().lookup({
                    title: 'Supir Lookup',
                    fileName: 'supir',
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                        }
                    },
                    onSelectRow: (supir, element) => {
                        element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
                        element.val(supir.namasupir)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        element.parents('td').find(`[name="supir_id[]"]`).val('')
                        element.val('')
                        element.data('currentValue', element.val())
                    }
                })

            })

            setRowNumbers()
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
            <input type="hidden" name="supir_id[]">
            <input type="text" name="supir[]" class="form-control supir-lookup">
        </td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">   
        </td><td>
          <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

        $('#detailList tbody').append(detailRow)


        $('.supir-lookup').last().lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },

            onSelectRow: (supir, element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        initAutoNumeric(detailRow.find('.autonumeric'))

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
            url: `${apiUrl}pendapatansupirheader/approval`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                pendapatanId: selectedRows
            },
            success: response => {
                $('#crudForm').trigger('reset')
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
                url: `${apiUrl}jurnalumumheader/field_length`,
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
        $('.bank-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            beforeProcess: function(test) {
                this.postData = {
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
    }
</script>
@endpush()
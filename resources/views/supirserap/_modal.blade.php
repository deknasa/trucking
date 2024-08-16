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
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TGL ABSENSI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglabsensi" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TRADO <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="trado_id">
                                <input type="text" name="trado" class="form-control trado-lookup">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    SUPIR
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supir_id">
                                <input type="text" name="supir" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    SUPIR SERAP <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supirserap_id">
                                <input type="text" name="supirserap" class="form-control supirserap-lookup">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    KETERANGAN <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
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
                        <button class="btn btn-secondary" data-dismiss="modal">
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
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()
    let isEditTgl

    $(document).ready(function() {

        $("#crudForm [name]").attr("autocomplete", "off");


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
            let data = $('#crudForm').serializeArray()

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

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}supirserap`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}supirserap/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}supirserap/${Id}?indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}supirserap`
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
                    if (button == 'btnSubmit') {
                        id = response.data.id

                        $('#crudModal').find('#crudForm').trigger('reset')
                        $('#crudModal').modal('hide')
                        $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page,
                        }).trigger('reloadGrid');

                        if (response.data.grp == 'FORMAT') {
                            updateFormat(response.data)
                        }
                    } else {

                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        // showSuccessDialog(response.message)
                        createSupirSerap()
                        $('#crudForm').find('input[type="text"]').data('current-value', '')

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
        }
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)
        activeGrid = null
        getMaxLength(form)
        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }
        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function createSupirSerap() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Supir Serap')
        if (selectedRows.length > 0) {
            clearSelectedRows()
        }
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        $('#crudForm').find('[name=tglabsensi]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    }

    function editSupirSerap(serapId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Supir Serap')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showSupirSerap(form, serapId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deleteSupirSerap(serapId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Supir Serap')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showSupirSerap(form, serapId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function viewSupirSerap(serapId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
        $('#crudModalTitle').text('View Supir Serap')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showSupirSerap(form, serapId)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
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
            url: `{{ config('app.api_url') }}piutangheader/${Id}/cekvalidasi`,
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
                    if (Aksi == 'PRINTER BESAR') {
                        window.open(`{{ route('piutangheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
                    } else if (Aksi == 'PRINTER KECIL') {
                        window.open(`{{ route('piutangheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
                    } else {
                        cekValidasiAksi(Id, Aksi)
                    }
                }
            }
        })
    }

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}piutangheader/${Id}/cekValidasiAksi`,
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
                        editPiutangHeader(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deletePiutangHeader(Id)
                    }
                }

            }
        })
    }

    function showSupirSerap(form, serapId) {

        return new Promise((resolve, reject) => {

            $.ajax({
                url: `${apiUrl}supirserap/${serapId}`,
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
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }
                        if (index == 'trado') {
                            element.data('current-value', value)
                        }
                        if (index == 'supir') {
                            element.data('current-value', value)
                        }
                        if (index == 'supirserap') {
                            element.data('current-value', value)
                        }

                    })
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

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}supirserap/field_length`,
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

    function initLookup() {
        $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            beforeProcess: function(test) {
                console.log($('#crudForm').find('[name=tglabsensi]').val());
                this.postData = {
                    Aktif: 'AKTIF',
                    supirserap: true,
                    tglabsensi: $('#crudForm').find('[name=tglabsensi]').val(),
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                $('#crudForm [name=supir]').first().val(trado.supir_id)
                $('#crudForm [name=supir_id]').first().val(trado.supirid)
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

                $('#crudForm [name=supir]').first().val('')
                $('#crudForm [name=supir_id]').first().val('')
                $('#crudForm [name=supir]').data('currentValue', '')
            }
        })
        $('.supirserap-lookup').lookup({
            title: 'Supir Serap Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    fromSupirSerap: true,
                    tgltrip: $('#crudForm').find('[name=tglabsensi]').val()
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supirserap_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supirserap_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}supirserap/${Id}/cekvalidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            data: {
                aksi: Aksi
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'EDIT') {
                        editSupirSerap(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteSupirSerap(Id)
                    }
                }
            }
        })
    }

    function approve() {

        event.preventDefault()

        let form = $('#crudForm')
        $(this).attr('disabled', '')
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}supirserap/approval`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                serapId: selectedRows
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
                    showDialog(error.responseJSON)
                }
            },
        }).always(() => {
            $('#processingLoader').addClass('d-none')
            $(this).removeAttr('disabled')
        })
    }
</script>
@endpush()
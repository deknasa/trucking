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
                                    TRADO <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="hidden" name="trado_id">
                                <input type="text" name="trado" class="form-control trado-lookup">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL KELUAR <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglkeluar" class="form-control datepicker">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="card" style="max-height:500px; overflow-y: scroll;">
                                    <div class="card-body">

                                        <div class="table-responsive table-scroll ">
                                            <table class="table table-bordered table-bindkeys" id="detailList">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%; max-width: 25px;min-width: 15px">No</th>
                                                        <th style="width:40%;">No bukti Service in</th>
                                                        <th style="width:40%;">Keterangan</th>
                                                        <th style="width:5%; max-width: 25px;min-width: 15px">Aksi</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
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

        $(document).on('click', "#addRow", function() {
            addRow()
        });
        $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
            $('#crudForm').find(`[name="tglkeluar"]`).val($(this).val()).trigger('change');
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

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

            let tgldariheader = $('#tgldariheader').val();
            let tglsampaiheader = $('#tglsampaiheader').val()

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}serviceoutheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}serviceoutheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}serviceoutheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}serviceoutheader`
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
                    console.log(id)
                    $('#crudModal').modal('hide')
                    $('#crudModal').find('#crudForm').trigger('reset')

                    $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
                    $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
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
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function createServiceOut() {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Service Out')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#table_body').html('')

        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglkeluar]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        addRow()
    }

    function editServiceOut(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        $('#crudModalTitle').text('Edit Service Out ')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showServiceOut(form, id)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                // $('#crudForm [name=tglbukti]').attr('readonly', true)
                // $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function deleteServiceOut(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Service Out')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showServiceOut(form, id)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                $('#crudForm [name=tglbukti]').attr('readonly', true)
                $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function showServiceOut(form, id) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $.ajax({
                url: `${apiUrl}serviceoutheader/${id}`,
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
                    })
                    $('#detailList tbody').html('')
                    $.each(response.detail, (index, detail) => {
                        let detailRow = $(`
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" name="servicein_nobukti[]" data-current-value="${detail.servicein_nobukti}" class="form-control serviceinheader-lookup">
                            </td>
                            <td>
                                <input type="text" name="keterangan_detail[]" class="form-control">
                            </td>
                            <td>
                            <div class='btn btn-danger btn-sm delete-row '>Hapus</div>
                        </td>
                        </tr>`)

                        detailRow.find(`[name="servicein_nobukti[]"]`).val(detail.servicein_nobukti)

                        detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

                        $('#detailList tbody').append(detailRow)


                        $('.serviceinheader-lookup').last().lookup({
                            title: 'servicein Lookup',
                            fileName: 'serviceinheader',

                            onSelectRow: (servicein, element) => {
                                element.val(servicein.nobukti)
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
        let detailRow = (`
        <tr>
        <td></td>
        <td>
            <input type="text" name="servicein_nobukti[]" class="form-control serviceinheader-lookup">
        </td>
        <td>
            <input type="text" name="keterangan_detail[]" class="form-control">
        </td>
        <td>
        <div class='btn btn-danger btn-sm delete-row '>Hapus</div>
        </td>
    </tr>`)

        $('#detailList tbody').append(detailRow)

        $('.serviceinheader-lookup').last().lookup({
            title: 'servicein Lookup',
            fileName: 'serviceinheader',
            onSelectRow: (servicein, element) => {
                element.val(servicein.nobukti)
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
        setRowNumbers()
    }

    function deleteRow(row) {
        row.remove()

        setRowNumbers()
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}serviceoutheader/${Id}/cekvalidasi`,
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
                            editServiceOut(Id)
                        }
                        if (Aksi == 'DELETE') {
                            deleteServiceOut(Id)
                        }
                    }

                } else {
                    showDialog(response.message['keterangan'])
                }
            }
        })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}serviceoutheader/field_length`,
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

        $('.trado-lookup').lookup({
            title: 'trado Lookup',
            fileName: 'trado',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="type"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })

    }
</script>
@endpush()
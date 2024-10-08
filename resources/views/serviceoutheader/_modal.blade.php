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
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TRADO <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="hidden" name="trado_id">
                                <input type="text" name="trado" id="trado" class="form-control trado-lookup">
                            </div>
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL & JAM KELUAR <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="datetime-local" name="tglkeluar" class="form-control inputmask-time">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="card" style="max-height:500px; overflow-y: scroll;">
                                    <div class="card-body">

                                        <div class="table-responsive table-scroll ">
                                            <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1000px;">
                                                <thead>
                                                    <tr>
                                                        <th width="2%" class="tbl_aksi">Aksi</th>
                                                        <th width="2%">No</th>
                                                        <th width="48%">No bukti Service in</th>
                                                        <th width="48%">Keterangan</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="tbl_aksi">
                                                        <div type="button" class="my-1" id="addRow"><span><i class="far fa-plus-square"></i></span></div>
                                                        </td>
                                                        <td colspan="3"></td>
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

        $(document).on('click', "#addRow", function() {
            event.preventDefault()
            let method = `POST`
            let url = `${apiUrl}serviceoutheader/addrow`
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()
            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    addRow()
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
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
        });
        $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
            $('#crudForm').find(`[name="tglkeluar"]`).val($(this).val()).trigger('change');
        });

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
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
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            data.push({
                name: 'tgldariheader',
                value: $('#tgldariheader').val()
            })
            data.push({
                name: 'tglsampaiheader',
                value: $('#tglsampaiheader').val()
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
                name: 'button',
                value: button
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

                    $('#crudModal').find('#crudForm').trigger('reset')
                    if (button == 'btnSubmit') {
                        id = response.data.id
                        $('#crudModal').modal('hide')
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
                    } else {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        $('#crudForm').find('input[type="text"]').data('current-value', '')
                        showSuccessDialog(response.message, response.data.nobukti)
                        $('#crudForm').find('[name=tglbukti]').val(dateFormat(response.data.tglbukti)).trigger('change');
                        createServiceOut()
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
        initLookup()
        initDatepicker()
        Inputmask("datetime", {
            inputFormat: "HH:MM",
            max: 24
        }).mask(".inputmask-time");
        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        removeEditingBy($('#crudForm').find('[name=id]').val())
        $('#crudModal').find('.modal-body').html(modalBody)
        initDatepicker('datepickerIndex')
    })

    function removeEditingBy(id) {
        let formData = new FormData();


        formData.append('id', id);
        formData.append('aksi', 'BATAL');
        formData.append('table', 'serviceoutheader');

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

    function createServiceOut() {
        let form = $('#crudForm')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Service Out')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#table_body').html('')

        if (selectedRows.length > 0) {
            clearSelectedRows()
        }
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
            Save
        `)
        $('#crudModalTitle').text('Edit Service Out ')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setTglBukti(form),
                showServiceOut(form, id)
            ])
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                if (isEditTgl == 'TIDAK') {
                    form.find(`[name="tglbukti"]`).prop('readonly', true)
                    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                }
            })
            .catch((error) => {
                showDialog(error.responseJSON)
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
            <i class="fa fa-trash"></i>
            Delete
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
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                $('#crudForm [name=tglbukti]').attr('readonly', true)
                $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function viewServiceOut(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
          <i class="fa fa-save"></i>
          Save
        `)
        form.find('#btnSubmit').prop('disabled', true)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Service Out')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showServiceOut(form, id)
            ])
            .then(id => {
                setFormBindKeys(form)
                form.find('[name]').removeAttr('disabled')

                form.find('select').each((index, select) => {
                    let element = $(select)

                    if (element.data('select2')) {
                        element.select2('destroy')
                    }
                })
                form.find('[name]').attr('disabled', 'disabled').css({
                    background: '#fff'
                })
                form.find('[name=id]').prop('disabled', false);
            })
            .then(() => {
                if (selectedRows.length > 0) {
                    clearSelectedRows()
                }
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
                let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
                name.attr('disabled', true)
                name.find('.lookup-toggler').remove()
                nameFind.find('button.button-clear').remove()
                $('.tbl_aksi').hide()
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
                            <td class="tbl_aksi">
                                <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
                            </td>
                            <td></td>
                            <td>
                                <input type="text" name="servicein_nobukti[]" data-current-value="${detail.servicein_nobukti}" class="form-control serviceinheader-lookup">
                            </td>
                            <td>
                                <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
                            </td>
                        </tr>`)

                        detailRow.find(`[name="servicein_nobukti[]"]`).val(detail.servicein_nobukti)

                        detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

                        $('#detailList tbody').append(detailRow)


                        $('.serviceinheader-lookup').last().lookup({
                            title: 'servicein Lookup',
                            fileName: 'serviceinheader',
                            beforeProcess: function(test) {
                                this.postData = {
                                    serviceout: true,
                                    trado_id: $('#crudForm').find(`[name="trado_id"] `).val(),
                                    nobukti: $('#crudForm').find(`[name="nobukti"] `).val()
                                }
                            },
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
        <td>
            <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
        </td>
        <td></td>
        <td>
            <input type="text" name="servicein_nobukti[]" class="form-control serviceinheader-lookup">
        </td>
        <td>
            <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
        </td>
    </tr>`)

        $('#detailList tbody').append(detailRow)

        $('.serviceinheader-lookup').last().lookup({
            title: 'servicein Lookup',
            fileName: 'serviceinheader',
            beforeProcess: function(test) {
                this.postData = {
                    serviceout: true,
                    trado_id: $('#crudForm').find(`[name="trado_id"] `).val(),
                    nobukti: $('#crudForm').find(`[name="nobukti"] `).val()
                }
            },
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
        let countRow = $('.delete-row').parents('tr').length
        row.remove()
        if (countRow <= 1) {
            addRow()
        }


        setRowNumbers()
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(2)')

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
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'PRINTER BESAR') {
                        window.open(`{{ route('serviceoutheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
                    } else if (Aksi == 'PRINTER KECIL') {
                        window.open(`{{ route('serviceoutheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
                    }
                    if (Aksi == 'EDIT') {
                        editServiceOut(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteServiceOut(Id)
                    }
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
                    showDialog(error.responseJSON)
                }
            })
        }
    }

    function initLookup() {

        $('.trado-lookup').lookupV3({
            title: 'trado Lookup',
            fileName: 'tradoV3',
            searching: ['kodetrado','kmakhirgantioli','merek','norangka','nomesin','nostnk' ],
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            filterToolbar: true,
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
                $('#crudForm [name=trado_id]').first().val('')
                $(`#crudForm [name="type"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })

    }
    const setTglBukti = function(form) {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'EDIT TANGGAL BUKTI'
            })
            data.push({
                name: 'subgrp',
                value: 'SERVICE OUT'
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
                    isEditTgl = $.trim(response.text);
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }
</script>
@endpush()
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
                                <input type="text" id="trado" name="trado" class="form-control trado-lookup">
                            </div>
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TGL & JAM MASUK <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="datetime-local" name="tglmasuk" class="form-control inputmask-time">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Status Service Out <span class="text-danger">*</span>
                                </label>
                            </div>


                            <div class="col-12 col-sm-4 col-md-4">
                                <input type="hidden" name="statusserviceout">
                                <input type="text" name="statusserviceoutnama" id="statusserviceoutnama" class="form-control lg-form status-lookup">
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
                                                        <th width="2%">No</th>
                                                        <th width="48%">Mekanik</th>
                                                        <th width="48%">Keterangan</th>
                                                        <th width="2%" class="tbl_aksi">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_body">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td class="tbl_aksi">
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
            let url = `${apiUrl}serviceinheader/addrow`
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
            $('#crudForm').find(`[name="tglmasuk"]`).val($(this).val()).trigger('change');
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
                    url = `${apiUrl}serviceinheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}serviceinheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}serviceinheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}serviceinheader`
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
                        // showSuccessDialog(response.message, response.data.nobukti)
                        createServicein()
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

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        if (form.data('action') == 'add') {
            form.find('#btnSaveAdd').show()
        } else {
            form.find('#btnSaveAdd').hide()
        }

        getMaxLength(form)
        initLookup()
        initDatepicker()
        Inputmask("datetime", {
            inputFormat: "HH:MM",
            max: 24
        }).mask(".inputmask-time");
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
        formData.append('table', 'serviceinheader');

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

    function createServicein() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Save
        `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add Service in')

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglmasuk]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        if (selectedRows.length > 0) {
            clearSelectedRows()
        }

        Promise
            .all([
                showDefault(form),
            ])
            .then(() => {
                $('#crudModal').modal('show')
                $('#table_body').html('')
                addRow()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })


    }

    function editServicein(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
        `)
        $('#crudModalTitle').text('Edit Service In ')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setTglBukti(form),
                showServicein(form, id)
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

    function deleteServicein(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-trash"></i>
            Delete
        `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Service in')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showServicein(form, id)
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

    function viewServicein(id) {
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
        $('#crudModalTitle').text('View Service in')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showServicein(form, id)
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

    function showServicein(form, id) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $.ajax({
                url: `${apiUrl}serviceinheader/${id}`,
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
                                <input type="hidden" name="karyawan_id[]" class="form-control">
                                <input type="text" name="karyawan[]"  id="karyawan"data-current-value="${detail.karyawan}" class="form-control karyawan-lookup">
                            </td>

                            <td>
                                <input type="text" name="keterangan_detail[]" class="form-control">
                            </td>

                            <td class="tbl_aksi">
                                <div class='btn btn-danger btn-sm delete-row'>Delete</div>
                            </td>
                        </tr>`)

                        detailRow.find(`[name="karyawan[]"]`).val(detail.karyawan)
                        detailRow.find(`[name="karyawan_id[]"]`).val(detail.karyawan_id)

                        detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

                        $('#detailList tbody').append(detailRow)

                        $('.karyawan-lookup').last().lookup({
                            title: 'Karyawan Lookup',
                            fileName: 'karyawan',
                            beforeProcess: function(test) {
                                // var levelcoa = $(`#levelcoa`).val();
                                this.postData = {

                                    Aktif: 'AKTIF',
                                    staff: 'MEKANIK'
                                }
                            },
                            onSelectRow: (karyawan, element) => {
                                element.parents('td').find(`[name="karyawan_id[]"]`).val(karyawan.id)
                                element.val(karyawan.namakaryawan)
                                element.data('currentValue', element.val())
                            },
                            onCancel: (element) => {
                                element.val(element.data('currentValue'))
                            },
                            onClear: (element) => {
                                element.parents('td').find(`[name="karyawan_id[]"]`).val('')
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

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}serviceinheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        console.log(value)
                        let element = form.find(`[name="${index}"]`)

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


    function addRow() {
        let detailRow = (`
        <tr>
            <td></td>
            <td>
                <input type="hidden" name="karyawan_id[]" class="form-control">
                <input type="text" name="karyawan[]" id="karyawan" class="form-control karyawan-lookup">
            </td>

            <td>
                <input type="text" name="keterangan_detail[]" class="form-control">
            </td>

            <td class="tbl_aksi">
                <div class='btn btn-danger btn-sm delete-row'>Delete</div>
            </td>
        </tr>`)

        $('#detailList tbody').append(detailRow)

        $('.karyawan-lookup').last().lookup({
            title: 'karyawan Lookup',
            fileName: 'karyawan',
            beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                    Aktif: 'AKTIF',
                    staff: 'MEKANIK'
                }
            },
            onSelectRow: (karyawan, element) => {
                $(`#crudForm [name="karyawan_id[]"]`).last().val(karyawan.id)
                element.val(karyawan.namakaryawan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $(`#crudForm [name="karyawan_id[]"]`).last().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        setRowNumbers()
    }

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}serviceinheader/${Id}/cekvalidasi`,
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
                        window.open(`{{ route('serviceinheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
                    } else if (Aksi == 'PRINTER KECIL') {
                        window.open(`{{ route('serviceinheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
                    }

                    cekValidasiAksi(Id, Aksi)
                }

            }
        })
    }

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}serviceinheader/${Id}/cekValidasiAksi`,
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
                        editServicein(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteServicein(Id)
                    }
                }
            }
        })
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
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}serviceinheader/field_length`,
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
                $('#crudForm [name=trado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        // $('.trado-lookup').lookupMaster({
        //     title: 'trado Lookup',
        //     fileName: 'tradoMaster',
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function(test) {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: 'trado_id',
        //             searchText: 'trado-lookup',
        //             title: 'Trado',
        //             typeSearch: 'ALL',
        //         }
        //     },
        //     onSelectRow: (trado, element) => {
        //         $('#crudForm [name=trado_id]').first().val(trado.id)
        //         element.val(trado.kodetrado)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=trado_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })

        $(`.status-lookup`).lookupMaster({
            title: 'STATUS SERVICE OUT Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'STATUS SERVICE OUT',
                    subgrp: 'STATUS SERVICE OUT',
                    searching: 1,
                    valueName: `statusserviceout`,
                    searchText: `status-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'STATUS SERVICE OUT'
                };
            },
            onSelectRow: (status, element) => {
                $('#crudForm [name=statusserviceout]').first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                $('#crudForm [name=statusserviceout]').first().val('')
                element.val('');
                element.data('currentValue', element.val());
            },
        });

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
                value: 'SERVICE IN'
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
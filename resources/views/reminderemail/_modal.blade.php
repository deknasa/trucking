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
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    keterangan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS AKTIF <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                                    <option value="">-- PILIH STATUS AKTIF --</option>
                                </select>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save
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
    var data_id 
    

    $(document).ready(function() {

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
                name: 'info',
                value: info
            })
            data.push({
                name: 'accessTokenTnl',
                value: accessTokenTnl
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
                    url = `${apiUrl}reminderemail`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}reminderemail/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}reminderemail/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}reminderemail`
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
        data_id = $('#crudForm').find('[name=id]').val();

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        initSelect2(form.find('.select2bs4'), true)

    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        clearSelectedRows()
        removeEditingBy(data_id)
        $('#crudModal').find('.modal-body').html(modalBody)
    })


    function removeEditingBy(id) {
        $.ajax({
            url: `{{ config('app.api_url') }}bataledit`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                id: id,
                aksi: 'BATAL',
                table: 'reminderemail'
                
            },
            success: response => {
                $("#crudModal").modal("hide")
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
        })
    }

    function createReminderEmail() {
        let form = $('#crudForm')

        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
      `)
        form.data('action', 'add')
        $('#crudModalTitle').text('Add reminder email')
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusAktifOptions(form),
            ])
            .then(() => {
                $('#crudModal').modal('show')
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function editReminderEmail(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
          <i class="fa fa-save"></i>
          Save
      `)
        $('#crudModalTitle').text('Edit reminder email ')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusAktifOptions(form),

            ])
            .then(() => {
                showReminderEmail(form, id)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deleteReminderEmail(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
          <i class="fa fa-trash"></i>
          Delete
      `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete reminder email')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([

                setStatusAktifOptions(form),

            ])
            .then(() => {
                showReminderEmail(form, id)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function viewReminderEmail(id) {
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
        $('#crudModalTitle').text('View reminder email')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showReminderEmail(form, id)
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

    function showReminderEmail(form, id) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')

            $.ajax({
                url: `${apiUrl}reminderemail/${id}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            console.log(index, value);
                            element.val(value).trigger('change')
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'reminderemail') {
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

    function cekValidasi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}reminderemail/${Id}/cekValidasi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            data:{
                aksi: Aksi,
            },
            success: response => {
                var error = response.error
                if (error == true) {
                    showDialog(response.message)
                } else {
                    if (Aksi == 'EDIT') {
                        editReminderEmail(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteReminderEmail(Id)
                    }
                }
            }
        })
    }

    const setStatusAktifOptions = function(relatedForm) {

        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusaktif]').empty()
            relatedForm.find('[name=statusaktif]').append(
                new Option('-- PILIH STATUS AKTIF --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS AKTIF"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusAktif => {
                        let option = new Option(statusAktif.text, statusAktif.id)
                        relatedForm.find('[name=statusaktif]').append(option).trigger('change')
                    });
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
                url: `${apiUrl}reminderemail/field_length`,
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
</script>
@endpush()
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

                        {{-- <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">ID</label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="id" class="form-control" readonly>
                            </div>
                        </div> --}}
                        <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    KODE TRADO <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="kodetrado" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TGL BATAS <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglbatas" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS APPROVAL <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="statusapproval" class="form-select select2bs4" style="width: 100%;">
                                    <option value="">-- PILIH STATUS APPROVAL --</option>
                                </select>
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
        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let approvalTradoId = form.find('[name=id]').val()
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

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}approvaltradoketerangan`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}approvaltradoketerangan/${approvalTradoId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}approvaltradoketerangan/${approvalTradoId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}approvaltradoketerangan`
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
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    id = response.data.id

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page
                    }).trigger('reloadGrid');

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
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        // getMaxLength(form)
        initDatepicker()
        initSelect2(form.find('.select2bs4'), true)
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModal').find('.modal-body').html(modalBody)
    })

    function createApprovalTradoKeterangan() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        form.data('action', 'add')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Approval Trado Keterangan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusApprovalOptions(form),
            ])
            .then(() => {
                $('#crudModal').modal('show')
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function editApprovalTradoKeterangan(Id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        form.data('action', 'edit')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Edit Approval Trado Keterangan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusApprovalOptions(form),
            ]).then(() => {
                showApprovalTradoKeterangan(form, Id)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })

    }

    function deleteApprovalTradoKeterangan(Id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)
        form.data('action', 'delete')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Delete Approval Trado Keterangan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusApprovalOptions(form),
            ]).then(() => {
                showApprovalTradoKeterangan(form, Id)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })

    }

    function showApprovalTradoKeterangan(form, Id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}approvaltradoketerangan/${Id}`,
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
                        if(index == 'kodetrado'){
                            element.prop('readonly', true)
                        }
                    })

                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }
                    resolve()
                }
            })
        })

    }
    const setStatusApprovalOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusapproval]').empty()
            relatedForm.find('[name=statusapproval]').append(
                new Option('-- PILIH STATUS APPROVAL --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    grp: 'STATUS APPROVAL',
                    subgrp: 'STATUS APPROVAL'
                },
                success: response => {
                    response.data.forEach(statusApproval => {
                        let option = new Option(statusApproval.text, statusApproval.id)

                        relatedForm.find('[name=statusapproval]').append(option).trigger('change')
                    });

                    resolve()
                }
            })
        })
    }

</script>
@endpush()
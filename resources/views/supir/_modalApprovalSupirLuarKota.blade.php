<div class="modal modal-fullscreen approvalSupirLuarKota-modal" id="crudModalApprovalLuarKota" tabindex="-1" aria-labelledby="crudModalApprovalLuarKotaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudFormApprovalLuarKota">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalApprovalLuarKotaTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <form action="" method="post">
                    <div class="modal-body">
                        <input type="text" name="id" class="form-control" hidden readonly>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    nama supir
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="supir_id" readonly hidden>
                                    <input type="text" name="namasupir" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    No KTP
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="noktp" id="noktp" maxlength="16" class="form-control numbernoseparate">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl batas tidak boleh luar kota
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglbatas" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS LUAR KOTA <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="statusluarkota" class="form-select select2bs4" style="width: 100%;">
                                    <option value="">-- PILIH STATUS LUAR KOTA --</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    keterangan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmitApprovalLuarKota" class="btn btn-primary">
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
    let modalBodyApprovalLuarKota = $('#crudModalApprovalLuarKota').find('.modal-body').html()

    $(document).ready(function() {
        $('#btnSubmitApprovalLuarKota').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudFormApprovalLuarKota')
            let approvalSupirLuarKotaId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudFormApprovalLuarKota').serializeArray()


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

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}supir/approvalluarkota`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    $('#crudFormApprovalLuarKota').trigger('reset')
                    $('#crudModalApprovalLuarKota').modal('hide')

                    $('#jqGrid').trigger('reloadGrid');
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
        })
    })

    $('#crudModalApprovalLuarKota').on('shown.bs.modal', () => {
        let form = $('#crudFormApprovalLuarKota')

        setFormBindKeys(form)

        activeGrid = null
        initDatepicker()
        initSelect2(form.find('.select2bs4'), true)
    })

    $('#crudModalApprovalLuarKota').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModalApprovalLuarKota').find('.modal-body').html(modalBodyApprovalLuarKota)
    })

    function approvalLuarKota(id) {
        let form = $('#crudFormApprovalLuarKota')
        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmitApprovalLuarKota').html(`<i class="fa fa-save"></i> Save`)

        form.find(`.sometimes`).show()
        $('#crudModalApprovalLuarKotaTitle').text('APPROVAL/UN Supir Luar Kota')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise.all([
                setStatusApprovalLuarKota(form),
            ])
            .then(() => {
                showApprovalLuarKota(form, id)
                    .then((response) => {
                        $('#crudModalApprovalLuarKota').modal('show')
                    })
                    .catch((error) => {
                        console.log(error);
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function showApprovalLuarKota(form, Id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}supir/approvalluarkota`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    supir_id: Id
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else if (element.hasClass('datepicker')) {
                            if (value) {
                                element.val(dateFormat(value))
                            }
                        } else {
                            element.val(value)
                        }
                        if (index == 'namasupir') {
                            element.prop('readonly', true)
                        }
                        if (index == 'noktp') {
                            element.prop('readonly', true)
                        }
                    })

                    resolve(response.data)
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusApprovalLuarKota = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statusluarkota]').empty()
            relatedForm.find('[name=statusluarkota]').append(
                new Option('-- PILIH STATUS LUAR KOTA --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    grp: 'STATUS LUAR KOTA',
                    subgrp: 'STATUS LUAR KOTA'
                },
                success: response => {
                    response.data.forEach(statusApproval => {
                        let option = new Option(statusApproval.text, statusApproval.id)
                        relatedForm.find('[name=statusluarkota]').append(option).trigger('change')
                    });
                    resolve()


                }
            })
        })
    }
</script>
@endpush()
<div class="modal modal-fullscreen approval-modal" id="crudModalApprovalGambar" tabindex="-1" aria-labelledby="crudModalApprovalGambarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudFormApprovalGambar">
            <div class="modal-content">

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
                        <button id="btnSubmitApprovalGambar" class="btn btn-primary">
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
    let modalBodyApprovalGambar = $('#crudModalApprovalGambar').find('.modal-body').html()

    $(document).ready(function() {
        $('#btnSubmitApprovalGambar').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudFormApprovalGambar')
            let approvalTradoId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudFormApprovalGambar').serializeArray()



            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}approvaltradogambar`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}approvaltradogambar/${approvalTradoId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}approvaltradogambar/${approvalTradoId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}approvaltradogambar`
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
                    $('#crudFormApprovalGambar').trigger('reset')
                    $('#crudModalApprovalGambar').modal('hide')



                    $('#jqGrid').trigger('reloadGrid');


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

    $('#crudModalApprovalGambar').on('shown.bs.modal', () => {
        let form = $('#crudFormApprovalGambar')

        setFormBindKeys(form)

        activeGrid = null

        // getMaxLength(form)
        initDatepicker()
        initSelect2(form.find('.select2bs4'), true)
    })

    $('#crudModalApprovalGambar').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModalApprovalGambar').find('.modal-body').html(modalBodyApprovalGambar)
    })


    function approvalTradoGambar(trado_id) {
        let form = $('#crudFormApprovalGambar')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`<i class="fa fa-save"></i> Save`)

        form.find(`.sometimes`).show()
        $('#crudModalApprovalGambarTitle').text('Approval Trado Gambar')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusApprovalOptions(form)
            ])
            .then(() => {
                console.log('here')
                showApprovalTradoGambar(form, trado_id)
                    .then((response) => {
                        let approvalGambar = response;
                        $('#crudModalApprovalGambar').modal('show')
                        form.data('action', 'add')
                        if (approvalGambar.id) {
                            form.data('action', 'edit')
                        }
                    })
                    .catch((error) => {
                        showDialog(error.responseJSON)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }


    function showApprovalTradoGambar(form, Id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}approvaltradogambar`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    trado_id: Id
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    // console.log(response);
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
                        if (index == 'kodetrado') {
                            element.prop('readonly', true)
                        }
                    })

                    // if (form.data('action') === 'delete') {
                    //     form.find('[name]').addClass('disabled')
                    //     initDisabled()
                    // }
                    resolve(response.data)
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
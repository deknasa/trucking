<div class="modal modal-fullscreen approval-modal" id="crudModalApprovalKetrangan" tabindex="-1" aria-labelledby="crudModalApprovalKetranganLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudFormApprovalKetrangan">
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
                        <button id="btnSubmitApprovalKetrangan" class="btn btn-primary">
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
    let modalBodyApprovalKetrangan = $('#crudModalApprovalKetrangan').find('.modal-body').html()

    $(document).ready(function() {
        $('#btnSubmitApprovalKetrangan').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudFormApprovalKetrangan')
            let approvalTradoId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudFormApprovalKetrangan').serializeArray()

           

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
                    $('#crudFormApprovalKetrangan').trigger('reset')
                    $('#crudModalApprovalKetrangan').modal('hide')

                   

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

    $('#crudModalApprovalKetrangan').on('shown.bs.modal', () => {
        let form = $('#crudFormApprovalKetrangan')

        setFormBindKeys(form)

        activeGrid = null

        // getMaxLength(form)
        initDatepicker()
        initSelect2(form.find('.select2bs4'), true)
    })

    $('#crudModalApprovalKetrangan').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'

        $('#crudModalApprovalKetrangan').find('.modal-body').html(modalBodyApprovalKetrangan)
    })


    function approvalTradoKeterangan(Id) {
        let form = $('#crudFormApprovalKetrangan')

        $('.modal-loader').removeClass('d-none')
        
        form.trigger('reset')
        form.find('#btnSubmitApprovalKetrangan').html(`<i class="fa fa-save"></i> Save`)
        
        form.find(`.sometimes`).show()
        $('#crudModalApprovalKetranganTitle').text('Approval Trado Keterangan')
       $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
        .all([
            setStatusApprovalOptions(form),
            showApprovalTradoKeterangan(form, Id)
        ]).then((response) => {
            let approvalKeterangan = response[1];
            $('#crudModalApprovalKetrangan').modal('show')
            form.data('action', 'add')
            if (approvalKeterangan.id){
                form.data('action', 'edit')
            }
        })
        .finally(() => {
            $('.modal-loader').addClass('d-none')
        })    

    }

    function showApprovalTradoKeterangan(form, Id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}approvaltradoketerangan`,
                method: 'GET',
                dataType: 'JSON',
                data:{trado_id:Id},
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
                        if(index == 'kodetrado'){
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
    

</script>
@endpush()
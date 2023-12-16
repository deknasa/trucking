@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                    <h5 class="card-title" id="crudModalTitle" style="color: #0e2d5f;font-weight: 700;"> {{$title}} </h5>

                </div>
                <form action="#" id="crudForm">
                    <div class=" ">

                        <form action="" method="post">
                            <div class="card-body">
                                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                <div class="form-group ">
                                    <label class="col-sm-4 col-form-label">PASSWORD BARU <span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control password">
                                            <div class="input-group-append">
                                                <div class="input-group-text focusPass">
                                                    <span class="fas fa-eye toggle-password" toggle=".password"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer justify-content-start">
                                <button id="btnSubmit" class="btn btn-primary">
                                    <i class="fa fa-save"></i>
                                    Save
                                </button>

                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
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
                name: 'info',
                value: info
            })
            method = 'POST'
            url = `${apiUrl}ubahpassword`

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
                    showSuccessDialog(response.message)
                    form.find(`[name="password"]`).val('')
                },
                error: error => {
                    console.log('postdata ', error)
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

        let form = $('#crudForm')
        setFormBindKeys(form)

        activeGrid = null
        // getMaxLength(form)
    })
</script>

@endpush

@endsection
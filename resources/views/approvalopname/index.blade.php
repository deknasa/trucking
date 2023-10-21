@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">status opname terakhir <span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="statusterakhir" class="form-control" readonly disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    STATUS OPNAME <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <select name="statusopname" id="statusopname" class="form-select select2bs4" style="width: 100%;">
                                    {{-- <option value=""> </option> --}}
                                    @foreach ($status as $statusppname)
                                    <option value="{{$statusppname['id']}}"> {{$statusppname['text']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnSubmit" class="btn btn-primary mr-2 ">
                                    <i class="fas fa-save"></i>
                                    Simpan
                                </a>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let form = $('#crudForm')
        initDatepicker()
        initSelect2($(`#statusopname`), false)
        statusterakhir()
        function statusterakhir() {
            $.ajax({
                url: `${apiUrl}approvalopname`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#crudForm').find('[name=statusterakhir]').val(response.terakhir).trigger('change');
                    $('#crudForm').find('[name=statusopname]').val(response.status).trigger('change');

                },
                error: error => {
                    if (error.status === 422) {
                        showDialog(error.statusText)
                    }
                },
            })
        }
        $('#crudForm').find('[name=statusopname]').trigger('change');
    })


    // const setStatusOpnameOptions = function(relatedForm) {
    //     return new Promise((resolve, reject) => {
    //         relatedForm.find('[name=statusopname]').empty()
    //         relatedForm.find('[name=statusopname]').append(
    //             new Option('-- PILIH STATUS OPNAME --', '', false, true)
    //         ).trigger('change')

    //         $.ajax({
    //             url: `${apiUrl}parameter`,
    //             method: 'GET',
    //             dataType: 'JSON',
    //             headers: {
    //                 Authorization: `Bearer ${accessToken}`
    //             },
    //             data: {
    //                 filters: JSON.stringify({
    //                     "groupOp": "AND",
    //                     "rules": [{
    //                         "field": "grp",
    //                         "op": "cn",
    //                         "data": "STATUS APPROVAL"
    //                     }]
    //                 })
    //             },
    //             success: response => {
    //                 response.data.forEach(statusOpname => {
    //                     let option = new Option(statusOpname.text, statusOpname.id)

    //                     relatedForm.find('[name=statusopname]').append(option).trigger('change')
    //                 });

    //                 resolve()
    //             },
    //             error: error => {
    //                 reject(error)
    //             }
    //         })
    //     })
    // }

    $(document).on('click', `#btnSubmit`, function(event) {
        let statusterakhir = $('#crudForm').find('[name=statusterakhir]').val()
        let statusopname = $('#crudForm').find('[name=statusopname]').val()
        let form = $('#crudForm')
        let data = $('#crudForm').serializeArray()
        $.ajax({
            url: `${apiUrl}approvalopname`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()
                showDialog(response.message)

                $('#crudForm').find('[name=statusterakhir]').val(response.text).trigger('change');
                $('#crudForm').find('[name=statusopname]').val(response.statusapproval).trigger('change');

            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    setErrorMessages(form, error.responseJSON.errors);
                } else if (error.status === 423) {
                    // console.log(error);
                    showDialog(error.responseJSON.statusText)

                } else {
                    showDialog(error.statusText)
                }
            },
        })

    })
</script>
@endpush()
@endsection
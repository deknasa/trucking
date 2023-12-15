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
                            <label class="col-12 col-sm-2 col-form-label mt-2">tgl terakhir tutup buku <span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tglterakhir" class="form-control datepicker" readonly disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">tgl tutup buku <span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tgltutupbuku" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="row text-danger">nb :</div>
                                <div class="row">
                                    <ul>
                                        <li class="text-danger">Setelah Proses tutup buku maka seluruh transaksi yang terjadi sebelum tanggal untuk pilihan tutup buku berikut ini tidak dapat dirubah kembali.</li>
                                        <li class="text-danger">Sebelum Proses ini dilanjutkan, terlebih dahulu user pada komputer client lain yang menggunakan aplikasi ini untuk sementara dimatikan hingga proses ini selesai.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnSubmit" class="btn btn-primary mr-2 ">
                                    <i class="fas fa-save"></i>
                                    Save
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
        initDatepicker()
        // $('#crudForm').find('[name=tglterakhir]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        tglterakhir()

        function tglterakhir() {
            $.ajax({
                url: `${apiUrl}tutupbuku`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#crudForm').find('[name=tglterakhir]').val($.datepicker.formatDate('dd-mm-yy', new Date(response.data.text))).trigger('change');

                },
                error: error => {
                    if (error.status === 422) {
                        showDialog(error.statusText)
                    }
                },
            })
        }
        $('#crudForm').find('[name=tgltutupbuku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    })

    $(document).on('click', `#btnSubmit`, function(event) {
        let tglterakhir = $('#crudForm').find('[name=tglterakhir]').val()
        let tgltutupbuku = $('#crudForm').find('[name=tgltutupbuku]').val()
        let form = $('#crudForm')
        let data = $('#crudForm').serializeArray()
        if (tglterakhir != '' && tgltutupbuku != '') {
            $.ajax({
                url: `${apiUrl}tutupbuku`,
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

                    $('#crudForm').find('[name=tglterakhir]').val(dateFormat(response.data['text'])).trigger('change');
                    $('#crudForm').find('[name=tgltutupbuku]').val('').trigger('change');

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


        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })
    $(document).on('click', `.ui-dialog .ui-button`, function(event) {
        event.preventDefault()
        window.location.href = `${appUrl}/dashboard`
    })
</script>
@endpush()
@endsection
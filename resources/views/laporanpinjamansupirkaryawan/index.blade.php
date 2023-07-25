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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </button>
                                <button type="button" id="btnExport" class="btn btn-warning mr-1 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'nobukti'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let hasDetail = false


    $(document).ready(function() {

        initDatepicker()
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


        if (!`{{ $myAuth->hasPermission('laporanpinjamansupirkaryawan', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanpinjamansupirkaryawan', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()

        $.ajax({
            url: `{{ route('laporanpinjamansupirkaryawan.report') }}`,
            method: 'GET',
            data: {
                sampai: sampai
            },
            success: function(response) {
                // Handle the success response
                var newWindow = window.open('','_blank');
                newWindow.document.open();
                newWindow.document.write(response);
                newWindow.document.close();
            },
            error: function(error) {
                console.log(error)
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    setErrorMessages($('#crudForm'), error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON.message);
                }
            }
        });
    })

    $(document).on('click', `#btnExport`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()

        if (sampai != '') {

            window.open(`{{ route('laporanpinjamansupirkaryawan.export') }}?sampai=${sampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


</script>
@endpush()
@endsection
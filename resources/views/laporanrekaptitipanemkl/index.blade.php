@extends('layouts.master')

@section('content')
<!-- <style>
    .ui-datepicker-calendar {
        display: none;
    }
</style> -->
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
                                <div class="col-sm-4">
                                    <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">

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
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        // $('.datepicker').datepicker({
        //         changeMonth: true,
        //         changeYear: true,
        //         showButtonPanel: true,
        //         showOn: "button",
        //         dateFormat: 'mm-yy',
        //         onClose: function(dateText, inst) {
        //             $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        //         }
        //     }).siblings(".ui-datepicker-trigger")
        //     .wrap(
        //         `
		// 	<div class="input-group-append">
		// 	</div>
		// `
        //     )
        //     .addClass("ui-datepicker-trigger btn btn-easyui text-easyui-dark").html(`
		// 	<i class="fa fa-calendar-alt"></i>
		// `);

        if (!`{{ $myAuth->hasPermission('laporanrekaptitipanemkl', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('laporanrekaptitipanemkl', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        
        getCekReport().then((response) => {
            window.open(`{{ route('laporanrekaptitipanemkl.report') }}?periode=${periode}`)
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()
                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.statusText, error.responseJSON.message)

            }
        })
    })

    $(document).on('click', `#btnExport`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        
        getCekExport().then((response) => {
            window.open(`{{ route('laporanrekaptitipanemkl.export') }}?periode=${periode}`)
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()
                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.statusText, error.responseJSON.message)

            }
        })

    })

    function getCekReport() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanrekaptitipanemkl/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    jenisorder : $('#crudForm').find('[name=jenisorder]').val(),
                    periode : $('#crudForm').find('[name=periode]').val(),
                    tglsampai : $('#crudForm').find('[name=tglsampai]').val(),
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)

                },
            });
        });
    }

    function getCekExport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanrekaptitipanemkl/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    jenisorder : $('#crudForm').find('[name=jenisorder]').val(),
                    periode : $('#crudForm').find('[name=periode]').val(),
                    tglsampai : $('#crudForm').find('[name=tglsampai]').val(),
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)

                },
            });
        });
    }
</script>
@endpush()
@endsection
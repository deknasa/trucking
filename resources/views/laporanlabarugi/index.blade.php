@extends('layouts.master')

@section('content')
<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
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
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">Periode <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </a>
                                <a id="btnExport" class="btn btn-warning mr-1 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </a>
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

        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: "button",
                dateFormat: 'mm-yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }).siblings(".ui-datepicker-trigger")
            .wrap(
                `
			<div class="input-group-append">
			</div>
		`
            )
            .addClass("ui-datepicker-trigger btn btn-easyui text-easyui-dark").html(`
			<i class="fa fa-calendar-alt"></i>
		`);
        
        let css_property =
        {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor" : "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('laporanlabarugi', 'report') }}`) {
            $('#btnEkspor').prop('disabled', true)
            $('#btnEkspor').css(css_property);
        }
        if (!`{{ $myAuth->hasPermission('laporanlabarugi', 'export') }}`) {
            $('#btnEksport').prop('disabled', true)
            $('#btnEkspor').css(css_property);
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        // let sampai = $('#crudForm').find('[name=sampai]').val()

        // if (sampai != '') {

        //     window.open(`{{ route('laporanlabarugi.report') }}?sampai=${sampai}`)    
        // } else {
        //     showDialog('ISI SELURUH KOLOM')
        // }

        let sampai = $('#crudForm').find('[name=sampai]').val()
        getCekReport().then((response) => {
            window.open(`{{ route('laporanlabarugi.report') }}?sampai=${sampai}`) 
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
        let sampai = $('#crudForm').find('[name=sampai]').val()

        if (sampai != '') {

            window.open(`{{ route('laporanlabarugi.export') }}?sampai=${sampai}`)    
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function getCekReport() {

return new Promise((resolve, reject) => {
    $.ajax({
        url: `${apiUrl}laporanlabarugi/report`,
        dataType: "JSON",
        headers: {
            Authorization: `Bearer ${accessToken}`
        },
        data: {
            sampai: $('#crudForm').find('[name=sampai]').val(),
            isCheck: true,
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
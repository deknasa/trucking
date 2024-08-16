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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Tahun<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </button>
                                <button type="button" id="btnExport" class="btn btn-warning ">
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
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
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
            .addClass("btn btn-easyui text-easyui-dark").html(`
			<i class="fa fa-calendar-alt"></i>
		`);



        if (!`{{ $myAuth->hasPermission('laporanaruskas', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanaruskas', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }


    })

    $(document).on('click', `#btnPreview`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()

        if (periode != '') {

            window.open(`{{ route('laporanaruskas.report') }}?periode=${periode}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })
    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let periode = $('#crudForm').find('[name=periode]').val()

        $.ajax({
            url: `{{ route('laporanaruskas.export') }}?periode=${periode}`,
            type: 'GET',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
            },
            xhrFields: {
                responseType: 'arraybuffer'
            },
            success: function(response, status, xhr) {
                if (xhr.status === 200) {
                    if (response !== undefined) {
                        var blob = new Blob([response], {
                            type: 'cabang/vnd.ms-excel'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = `LAPORAN ARUS KAS/BANK  ${new Date().getTime()}.xlsx`;
                        link.click();
                    }
                }
                
                $('#processingLoader').addClass('d-none')
            },
            error: function(xhr, status, error) {
                $('#processingLoader').addClass('d-none')
                showDialog('TIDAK ADA DATA')
            }
        })
    })

   
</script>
@endpush()
@endsection
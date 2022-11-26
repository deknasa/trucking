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
            <div class="card card-primary">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Bulan/Tahun<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tanggal" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <button id="btnSubmit" class="btn btn-primary ">
                                    <i class="fa fa-print"></i>
                                    Report
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Data<span class="text-danger">*</span></label>

                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="data" id="data" class="form-select select2bs4" style="width: 100%;">
                                    <option>--PILIH DATA--</option>
                                    <option value="jurnalumumheader">JURNAL UMUM</option>
                                    <option value="piutangheader">PIUTANG</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kode Perk.<span class="text-danger">*</span></label>

                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="coa" class="form-control coa-lookup">
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
        initSelect2($('#crudForm').find('[name=data]'), false)
        initLookup()
        $('#crudForm').find('[name=tanggal]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

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
            .addClass("btn btn-primary").html(`
			<i class="fa fa-calendar-alt"></i>
		`);

        $('#btnSubmit').click(function(event) {
            let tanggal = $('#crudForm').find('[name=tanggal]').val()
            let data = $('#crudForm').find('[name=data]').val()
            window.open(`{{ route('reportall.report') }}?tgl=${tanggal}&data=${data}`)
        })
    })

    function initLookup() {

        $('.coa-lookup').lookup({
            title: 'Akun perk. Lookup',
            fileName: 'akunpusat',
            onSelectRow: (akunpusat, element) => {
                element.val(akunpusat.coa)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
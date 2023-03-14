@extends('layouts.master')

@section('content')
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
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TANGGAL DARI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tgldr" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">
                                    TANGGAL SAMPAI <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tglsd" class="form-control datepicker">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kode Perkiraan Dari<span class="text-danger">*</span></label>

                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="coadr" class="form-control coa-lookup">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kode Perkiraan Sampai<span class="text-danger">*</span></label>

                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="coasd" class="form-control coa-lookup">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-4 mt-2">
                                <button id="btnSubmit" class="btn btn-primary ">
                                    <i class="fa fa-print"></i>
                                    Report
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
        initSelect2($('#crudForm').find('[name=data]'), false)
        initLookup()
         initDatepicker()
        $('#crudForm').find('[name=tgldr]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglsd]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        


        $('#btnSubmit').click(function(event) {
            let tgldr = $('#crudForm').find('[name=tgldr]').val()
            let tglsd = $('#crudForm').find('[name=tglsd]').val()
            let coadr = $('#crudForm').find('[name=coadr]').val()
            let coasd = $('#crudForm').find('[name=coasd]').val()
            window.open(`{{ route('reportneraca.report') }}?tgldr=${tgldr}&tglsd=${tglsd}&coadr=${coadr}&coasd=${coasd}`)
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
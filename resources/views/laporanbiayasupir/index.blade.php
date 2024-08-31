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
                                    <input type="text" name="dari" id="dari" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-sm-1 mt-2 text-center">
                                <label class="mt-2">s/d</label>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" id="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
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

        initLookup()
        initDatepicker()
        let today = new Date();
        firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', firstDay)).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');



        if (!`{{ $myAuth->hasPermission('laporanbiayasupir', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        // window.open(` {{ route('laporanbiayasupir.export') }}?dari=${dari}&sampai=${sampai}`)
        $.ajax({
            url: `${apiUrl}laporanbiayasupir/export`,
            // url: `{{ route('laporanbiayasupir.export') }}?dari=${dari}&sampai=${sampai}`,
            // url: `${apiUrl}laporanbiayasupir/export?dari=${dari}&sampai=${sampai}`,
            type: 'GET',
            data : {
                dari : dari,
                sampai : sampai
            },
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
                        link.download = 'LAPORAN BIAYA SUPIR ' + new Date().getTime() + '.xlsx';
                        link.click();
                    }
                }

                $('#processingLoader').addClass('d-none')
            },
            error: function(xhr, status, error) {
                $('#processingLoader').addClass('d-none')
                console.log(error.responseJSON)
                // showDialog('TIDAK ADA DATA')
            }
        })
    })

    function initLookup() {

        $('.bank-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'bank',
            onSelectRow: (bank, element) => {
                $('#crudForm [name=bank_id]').first().val(bank.id)
                element.val(bank.namabank)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=bank_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
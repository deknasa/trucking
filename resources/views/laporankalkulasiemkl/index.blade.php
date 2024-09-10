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
                                    <input type="text" name="periode" class="form-control monthpicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Jenis Order<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="jenisorder_id">
                                <input type="text" id="jenisorder" name="jenisorder" class="form-control jenisorder-lookup">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-4">
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
@push('report-scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.viewer.office2013.whiteblue.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.designer.office2013.whiteblue.css') }}">
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.reports.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.viewer.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.designer.js') }}"></script>
@endpush()
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
        initMonthpicker()
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger(
            'change');


        initLookup()
        if (!`{{ $myAuth->hasPermission('laporankalkulasiemkl', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')
        let periode = $('#crudForm').find('[name=periode]').val()
        let jenis = $('#crudForm').find('[name=jenisorder]').val()

        if (jenis != '' && periode != '') {
            $.ajax({

                // url: `{{ route('laporankalkulasiemkl.export') }}?periode=${periode}&jenis=${jenis}`,
                url: `${apiUrl}laporankalkulasiemkl/export`,
                type: 'GET',
                data: {
                    periode: periode,
                    jenis: jenis
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
                            link.download = 'LAP. KETERANGAN PINJAMAN' + new Date().getTime() + '.xlsx';
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

        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

   

    function initLookup() {
        $('.jenisorder-lookup').lookupMaster({
            title: 'jenisorder Lookup',
            fileName: 'jenisorderMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'jenisorder_id',
                    searchText: 'jenisorder-lookup',
                    title: 'jenisorder Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (jenisorder, element) => {
                $('#crudForm [name=jenisorder_id]').first().val(jenisorder.id)
                element.val(jenisorder.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=jenisorder_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

    }
</script>
@endpush()
@endsection
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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Supir<span class="text-danger"></span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="supirdari_id">
                                    <input type="text" name="supirdari" id="supirdari" class="form-control supirdari-lookup">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="supirsampai_id">
                                    <input type="text" name="supirsampai" id="supirsampai" class="form-control supirsampai-lookup">
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
        initLookup()

        if (!`{{ $myAuth->hasPermission('laporanhistorypinjaman', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanhistorypinjaman', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let supirdari_id = $('#crudForm').find('[name=supirdari_id]').val()
        let supirsampai_id = $('#crudForm').find('[name=supirsampai_id]').val()
        if (((supirdari_id == '') && (supirsampai_id == '')) || (supirdari_id != '') && (supirsampai_id != '')) {
            $('#processingLoader').removeClass('d-none')
            $.ajax({
                
                url: `{{ route('laporanhistorypinjaman.export') }}?supirdari_id=${supirdari_id}&supirsampai_id=${supirsampai_id}`,
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
                            link.download = 'LAP. HISTORY PINJAMAN ' + new Date().getTime() + '.xlsx';
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
    $(document).on('click', `#btnPreview`, function(event) {
        let supirdari_id = $('#crudForm').find('[name=supirdari_id]').val()
        let supirsampai_id = $('#crudForm').find('[name=supirsampai_id]').val()
        if ((supirdari_id == '') && (supirsampai_id == '')) {
            window.open(`{{ route('laporanhistorypinjaman.report') }}?supirdari_id=${supirdari_id}&supirsampai_id=${supirsampai_id}`)
        } else if ((supirdari_id != '') && (supirsampai_id != '')) {
            window.open(`{{ route('laporanhistorypinjaman.report') }}?supirdari_id=${supirdari_id}&supirsampai_id=${supirsampai_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {

        $('.supirdari-lookup').lookupMaster({
            title: 'Supir Lookup',
            fileName: 'supirMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'ALL',
                    searching: 1,
                    valueName: 'supirdari_id',
                    searchText: 'supirdari-lookup',
                    title: 'supir dari',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supirdari_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="supirdari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.supirsampai-lookup').lookupMaster({
            title: 'Supir Lookup',
            fileName: 'supirMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'ALL',
                    searching: 1,
                    valueName: 'supirsampai_id',
                    searchText: 'supirsampai-lookup',
                    title: 'supir sampai',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supirsampai_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="supirsampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
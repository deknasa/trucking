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
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">MINGGU KE<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="tgldari">
                                    <input type="hidden" name="tglsampai">
                                    <input type="text" name="minggu" class="form-control minggu-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">CABANG<span class="text-danger"></span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="cabang_id">
                                    <input type="text" name="cabang" class="form-control cabang-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-file-print"></i>
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

        if (!`{{ $myAuth->hasPermission('laporanarusdanapusat', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanarusdanapusat', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })


    $(document).on('click', `#btnPreview`, function(event) {
        let tgldari = $('#crudForm').find('[name=tgldari]').val()
        let tglsampai = $('#crudForm').find('[name=tglsampai]').val()
        let minggu = $('#crudForm').find('[name=minggu]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()
        let cabang = $('#crudForm').find('[name=cabang]').val()

        window.open(`{{ route('laporanarusdanapusat.report') }}?tgldari=${tgldari}&tglsampai=${tglsampai}&cabang=${cabang}&cabang_id=${cabang_id}&minggu=${minggu}`)


    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

       
        let tgldari = $('#crudForm').find('[name=tgldari]').val()
        let tglsampai = $('#crudForm').find('[name=tglsampai]').val()
        let minggu = $('#crudForm').find('[name=minggu]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()
        let cabang = $('#crudForm').find('[name=cabang]').val()
        $.ajax({
            url: `{{ route('laporanarusdanapusat.export') }}?tgldari=${tgldari}&tglsampai=${tglsampai}&cabang=${cabang}&cabang_id=${cabang_id}&minggu=${minggu}`,
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
                        link.download = `Arus Dana Pusat-Cabang Mingguan ${new Date().getTime()}.xlsx`;
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

    function initLookup() {

        $('.cabang-lookup').lookup({
            title: 'Cabang Lookup',
            fileName: 'cabang',
            onSelectRow: (cabang, element) => {
                $('#crudForm [name=cabang_id]').first().val(cabang.id)
                element.val(cabang.namacabang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=cabang_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.minggu-lookup').lookup({
            title: 'Mingguan Lookup',
            fileName: 'mingguan',
            onSelectRow: (minggu, element) => {
                $('#crudForm [name=tgldari]').val(minggu.fTglDr)
                $('#crudForm [name=tglsampai]').val(minggu.fTglSd)
                element.val(minggu.fKode)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=tgldari]').val('')
                $('#crudForm [name=tglsampai]').val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
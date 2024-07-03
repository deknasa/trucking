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
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Tanggal<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tgldari" id="tgldari" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-sm-1 mt-2 text-center">
                                <label class="mt-2">s/d</label>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tglsampai" id="tglsampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">jenis order </label>
                            <div class="col-sm-4 mt-2">

                                <input type="hidden" name="jenisorder">
                                <input type="text" id="jenisorder" name="jenisordernama" class="form-control jenisorder-lookup">
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
        // initSelect2($(`#jenisorder`), false)
        initLookup()

        initDatepicker()
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');

        if (!`{{ $myAuth->hasPermission('laporantitipanemkl', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('laporantitipanemkl', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let jenisorder = $('#crudForm').find('[name=jenisorder]').val()
        let tgldari = $('#crudForm').find('[name=tgldari]').val()
        let tglsampai = $('#crudForm').find('[name=tglsampai]').val()
        let periode = $('#crudForm').find('[name=periode]').val()

        getCekReport().then((response) => {
            window.open(`{{ route('laporantitipanemkl.report') }}?jenisorder=${jenisorder}&tgldari=${tgldari}&tglsampai=${tglsampai}&periode=${periode}`)
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
        $('#processingLoader').removeClass('d-none')

        let jenisorder = $('#crudForm').find('[name=jenisorder]').val()
        let tgldari = $('#crudForm').find('[name=tgldari]').val()
        let tglsampai = $('#crudForm').find('[name=tglsampai]').val()
        let periode = $('#crudForm').find('[name=periode]').val()

        $.ajax({
            url: `{{ route('laporantitipanemkl.export') }}?jenisorder=${jenisorder}&tgldari=${tgldari}&tglsampai=${tglsampai}&periode=${periode}`,
            type: 'GET',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', `Bearer ${accessToken}`);
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
                        link.download = 'LAPORAN REKAP TITIPAN EMKL BELUM LUNAS ' + new Date().getTime() + '.xlsx';
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

    function getCekReport() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporantitipanemkl/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    jenisorder: $('#crudForm').find('[name=jenisorder]').val(),
                    tgldari: $('#crudForm').find('[name=periode]').val(),
                    tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                    periode: $('#crudForm').find('[name=periode]').val(),
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
                url: `${apiUrl}laporantitipanemkl/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    jenisorder: $('#crudForm').find('[name=jenisorder]').val(),
                    tgldari: $('#crudForm').find('[name=tgldari]').val(),
                    tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                    periode: $('#crudForm').find('[name=periode]').val(),
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

    function initLookup() {

        $('.jenisorder-lookup').lookupMaster({
            title: 'Jenis Order Lookup',
            fileName: 'jenisorderMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'jenisorder_id',
                    searchText: 'jenisorder-lookup',
                    title: 'Jenis Order Lookup',
                    typeSearch: 'ALL',
                    singleColumn : true,
                    hideLabel: true,
                }
            },
            onSelectRow: (jenisorder, element) => {
                $('#crudForm [name=jenisorder]').first().val(jenisorder.id)
                element.val(jenisorder.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=jenisorder]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
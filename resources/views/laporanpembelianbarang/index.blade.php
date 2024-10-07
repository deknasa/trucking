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
                                    <input type="text" name="sampai" class="form-control monthpicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">JENIS LAPORAN <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <select name="jenislaporan" id="jenislaporan" class="form-select select2bs4" style="width: 100%;">
                                    </select>
                                </div>
                            </div>
                        </div>

           
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <!-- <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </button> -->
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
        initMonthpicker()
        initSelect2($('#crudForm').find('[name=jenislaporan]'), false)
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
        setJenisLaporanOptions($('#crudForm'))

        if (!`{{ $myAuth->hasPermission('laporanpembelianbarang', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanpembelianbarang', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    const setJenisLaporanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=jenislaporan]').empty()
            relatedForm.find('[name=jenislaporan]').append(
                new Option('-- PILIH JENIS LAPORAN --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "JENIS LAPORAN"
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusReuse => {
                        let option = new Option(statusReuse.text, statusReuse.id)

                        relatedForm.find('[name=jenislaporan]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }


    $(document).on('click', `#btnPreview`, function(event) {

        let sampai = $('#crudForm').find('[name=sampai]').val()
        let jenislaporan = $('#crudForm').find('[name=jenislaporan]').val()

        $.ajax({
            url: `{{ route('laporanpembelianbarang.report') }}`,
            method: 'GET',
            data: {
                sampai: sampai,
                jenislaporan: jenislaporan
            },
            success: function(response) {
                // Handle the success response
                var newWindow = window.open('', '_blank');
                newWindow.document.open();
                newWindow.document.write(response);
                newWindow.document.close();
            },
            error: function(error) {
                console.log(error)
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    setErrorMessages($('#crudForm'), error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON.message);
                }
            }
        });
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')
        let jenislaporan = $('#crudForm').find('[name=jenislaporan]').val()

        let sampai = $('#crudForm').find('[name=sampai]').val()

        if (sampai != '') {
            $.ajax({
                url: `${apiUrl}laporanpembelianbarang/export`,
                // url: `{{ route('laporanpembelianbarang.export') }}?sampai=${sampai}`,
                type: 'GET',
                data: {
                    sampai: sampai,
                    jenislaporan: jenislaporan
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
                            link.download = 'LAPORAN PEMBELIAN BARANG ' + new Date().getTime() + '.xlsx';
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

    function getCekReport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanpembelianbarang/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    jenislaporan: $('#crudForm').find('[name=jenislaporan]').val(),
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
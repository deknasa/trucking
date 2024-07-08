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
                                    <input type="text" name="dari" class="form-control datepicker">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">JENIS STOK<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="kelompok_id">
                                <input type="text" name="kelompok" id="kelompok" class="form-control kelompok-lookup">
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

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');



        if (!`{{ $myAuth->hasPermission('laporanklaimpjtsupir', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanklaimpjtsupir', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
        let kelompok = $('#crudForm').find('[name=kelompok]').val()

        $.ajax({
            url: `{{ route('laporanklaimpjtsupir.report') }}`,
            method: 'GET',
            data: {
                sampai: sampai,
                dari: dari,
                kelompok: kelompok,
                kelompok_id: kelompok_id,
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
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
        let kelompok = $('#crudForm').find('[name=kelompok]').val()

        if (dari != '' && sampai != '') {
            $('#processingLoader').removeClass('d-none')
            
            $.ajax({
                url: `{{ route('laporanklaimpjtsupir.export') }}?sampai=${sampai}&dari=${dari}&kelompok_id=${kelompok_id}&kelompok=${kelompok}`,
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
                            link.download = 'LAP. KLAIM PJT SUPIR ' + new Date().getTime() + '.xlsx';
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
                url: `${apiUrl}laporanklaimpjtsupir/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    dari: $('#crudForm').find('[name=dari]').val(),
                    kelompok: $('#crudForm').find('[name=kelompok_id]').val(),
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


    function initLookup() {
        $('.kelompok-lookup').lookupMaster({
            title: 'kelompok Lookup',
            fileName: 'kelompokMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'kelompok_id',
                    searchText: 'kelompok-lookup',
                    title: 'Kelompok lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (kategori, element) => {
                $('#crudForm [name=kelompok_id]').first().val(kategori.id)
                element.val(kategori.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="kelompok_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
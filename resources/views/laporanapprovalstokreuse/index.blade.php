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
                            <label class="col-12 col-sm-2 col-form-label mt-2">stok<span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stok_id">
                                <input type="text" name="stok" class="form-control stok-lookup">
                            </div>
                        </div>
                        
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <div class="btn-group dropup  scrollable-menu">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="btnPreview">
                                        <i class="fas fa-print"></i>
                                        Report
                                    </button>
                                    <ul class="dropdown-menu" id="menu-approve" aria-labelledby="btnPreview">
                                        <li><a class="dropdown-item" id="reportPrinterBesar" href="#">Printer Lain</a></li>
                                        <li><a class="dropdown-item" id="reportPrinterKecil" href="#">Printer Epson Seri LX</a></li>
                                    </ul>
                                </div>
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

        if (!`{{ $myAuth->hasPermission('laporanapprovalstokreuse', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanapprovalstokreuse', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#reportPrinterBesar`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stok_id = $('#crudForm').find('[name=stok_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let stok = $('#crudForm').find('[name=stok]').val()
        let stoksampai = $('#crudForm').find('[name=stoksampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()
        getCekReport().then((response) => {
            window.open(`{{ route('laporanapprovalstokreuse.report') }}?stok=${stok}&stok_id=${stok_id}&printer=reportPrinterBesar`)
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
    $(document).on('click', `#reportPrinterKecil`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stok_id = $('#crudForm').find('[name=stok_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let stok = $('#crudForm').find('[name=stok]').val()
        let stoksampai = $('#crudForm').find('[name=stoksampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()
        getCekReport().then((response) => {
            window.open(`{{ route('laporanapprovalstokreuse.report') }}?stok=${stok}&stok_id=${stok_id}&printer=reportPrinterKecil`)
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

        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stok_id = $('#crudForm').find('[name=stok_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let stok = $('#crudForm').find('[name=stok]').val()
        let stoksampai = $('#crudForm').find('[name=stoksampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()

        if (dari != '' && sampai != '') {

            $.ajax({
                url: `{{ route('laporanapprovalstokreuse.export') }}?stok=${stok}&stok_id=${stok_id}`,
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
                            link.download = `LAPORAN BUKU BESAR ${new Date().getTime()}.xlsx`;
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
                url: `${apiUrl}laporanapprovalstokreuse/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    stok: $('#crudForm').find('[name=stok]').val(),
                    stok_id: $('#crudForm').find('[name=stok_id]').val(),
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

        $('.stok-lookup').lookup({
            title: 'Kd. Perkiraan Lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
                this.postData = {
                    levelstok: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stok_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=stok_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
       
    }
</script>
@endpush()
@endsection
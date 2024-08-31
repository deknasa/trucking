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
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                {{-- <div class="btn-group dropup  scrollable-menu">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="btnPreview">
                                        <i class="fas fa-print"></i>
                                        Report
                                    </button>
                                    <ul class="dropdown-menu" id="menu-approve" aria-labelledby="btnPreview">
                                        <li><a class="dropdown-item" id="reportPrinterBesar" href="#">Printer Lain</a></li>
                                        <li><a class="dropdown-item" id="reportPrinterKecil" href="#">Printer Epson Seri LX</a></li>
                                    </ul>
                                </div> --}}
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
        initDatepicker()

        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        
        if (!`{{ $myAuth->hasPermission('laporandatajurnal', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#reportPrinterBesar`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let coadari_id = $('#crudForm').find('[name=coadari_id]').val()
        let coasampai_id = $('#crudForm').find('[name=coasampai_id]').val()
        let coadari = $('#crudForm').find('[name=coadari]').val()
        let coasampai = $('#crudForm').find('[name=coasampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()
        getCekReport().then((response) => {
            window.open(`{{ route('laporanbukubesar.report') }}?dari=${dari}&sampai=${sampai}&printer=reportPrinterBesar`)
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
        let coadari_id = $('#crudForm').find('[name=coadari_id]').val()
        let coasampai_id = $('#crudForm').find('[name=coasampai_id]').val()
        let coadari = $('#crudForm').find('[name=coadari]').val()
        let coasampai = $('#crudForm').find('[name=coasampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()
        getCekReport().then((response) => {
            window.open(`{{ route('laporandatajurnal.report') }}?dari=${dari}&sampai=${sampai}&printer=reportPrinterKecil`)
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

        if (dari != '' && sampai != '') {
            $.ajax({
                url: `${apiUrl}laporandatajurnal/export`,
                // url: `{{ route('laporandatajurnal.export') }}?dari=${dari}&sampai=${sampai}`,
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
                            link.download = `LAPORAN DATA JURNAL ${new Date().getTime()}.xlsx`;
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
                url: `${apiUrl}laporandatajurnal/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    isCheck:true
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

        $('.coadari-lookup').lookup({
            title: 'Kd. Perkiraan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
                this.postData = {
                    levelCoa: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (coa, element) => {
                $('#crudForm [name=coadari_id]').first().val(coa.id)
                element.val(coa.keterangancoa)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=coadari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.coasampai-lookup').lookup({
            title: 'Kd. Perkiraan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
                this.postData = {
                    levelCoa: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (coa, element) => {
                $('#crudForm [name=coasampai_id]').first().val(coa.id)
                element.val(coa.keterangancoa)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=coasampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.cabang-lookup').lookup({
            title: 'Cabang Lookup',
            fileName: 'cabang',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
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
    }
</script>
@endpush()
@endsection
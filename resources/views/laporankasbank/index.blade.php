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
                            <label class="col-12 col-sm-2 col-form-label mt-2">KAS/BANK<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="bank_id">
                                    <input type="text" name="bank" class="form-control bank-lookup">
                                </div>
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
        initDatepicker()

        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        if (!`{{ $myAuth->hasPermission('laporankasbank', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporankasbank', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#reportPrinterBesar`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let bank_id = $('#crudForm').find('[name=bank_id]').val()
        let bank = $('#crudForm').find('[name=bank]').val()

        getCekReport().then((response) => {
            window.open(`{{ route('laporankasbank.report') }}?dari=${dari}&sampai=${sampai}&bank=${bank}&bank_id=${bank_id}&printer=reportPrinterBesar`)
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.responseJSON)

            }
        })

    })
    

    $(document).on('click', `#reportPrinterKecil`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let bank_id = $('#crudForm').find('[name=bank_id]').val()
        let bank = $('#crudForm').find('[name=bank]').val()

        getCekReport().then((response) => {
            window.open(`{{ route('laporankasbank.report') }}?dari=${dari}&sampai=${sampai}&bank=${bank}&bank_id=${bank_id}&printer=reportPrinterKecil`)
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.responseJSON)

            }
        })

    })

    $(document).on('click', `#btnExport`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let bank_id = $('#crudForm').find('[name=bank_id]').val()
        let bank = $('#crudForm').find('[name=bank]').val()

        getCekExport().then((response) => {
            window.open(`{{ route('laporankasbank.export') }}?dari=${dari}&sampai=${sampai}&bank=${bank}&bank_id=${bank_id}`)
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.responseJSON)

            }
        })

    })

    function getCekReport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporankasbank/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    bank: $('#crudForm').find('[name=bank]').val(),
                    bank_id: $('#crudForm').find('[name=bank_id]').val(),
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

    function getCekExport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporankasbank/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    bank: $('#crudForm').find('[name=bank]').val(),
                    bank_id: $('#crudForm').find('[name=bank_id]').val(),
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
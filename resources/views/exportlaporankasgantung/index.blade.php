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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kas/Bank<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="bank_id" value="{{ $data['bank_id'] }}">
                                <input type="text" id="bank" name="bank" value="{{ $data['bank'] }}" class="form-control bank-lookup">
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
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger(
            'change');

        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: "button",
                dateFormat: 'mm-yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }).siblings(".ui-datepicker-trigger")
            .wrap(
                `
    <div class="input-group-append">
    </div>
`
            )
            .addClass("btn btn-easyui text-easyui-dark").html(`
    <i class="fa fa-calendar-alt"></i>
`);


        if (!`{{ $myAuth->hasPermission('exportlaporankasgantung', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')
        let periode = $('#crudForm').find('[name=periode]').val()
        let bank_id = $('#crudForm').find('[name=bank_id]').val()
        let bank = $('#crudForm').find('[name=bank]').val()
        $.ajax({
            url: `{{ route('exportlaporankasgantung.export') }}?periode=${periode}&bank_id=${bank_id}&bank=${bank}`,
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
                        link.download = 'LAPORAN KAS GANTUNG ' + bank + ' '+ new Date().getTime() + '.xlsx';
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
        // getCekExport().then((response) => {
        //     window.open(` {{ route('exportlaporankasgantung.export') }}?periode=${periode}&bank_id=${bank_id}&bank=${bank}`)
        // }).catch((error) => {
        //     if (error.status === 422) {
        //         $('.is-invalid').removeClass('is-invalid')
        //         $('.invalid-feedback').remove()

        //         setErrorMessages($('#crudForm'), error.responseJSON.errors);
        //     } else {
        //         showDialog(error.statusText, error.responseJSON.message)

        //     }
        // })
    })

    function getCekExport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}exportlaporankasgantung/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    periode: $('#crudForm').find('[name=periode]').val(),
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

    function noData() {
        showDialog("TIDAK ADA DATA")
    }

    function initLookup() {

        $('.bank-lookup').lookupMaster({
            title: 'Bank Lookup',
            fileName: 'bankMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'bank_id',
                    searchText: 'bank-lookup',
                    title: 'bank Lookup',
                    typeSearch: 'ALL',
                    tipe: 'KAS',
                }
            },
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
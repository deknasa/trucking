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
                                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="periode" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Kas/Bank<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <input type="hidden" name="bank_id">
                                    <input type="text" name="bank" class="form-control bank-lookup">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-6 mt-4">
                                    <a id="btnEkspor" class="btn btn-warning ">
                                        <i class="fas fa-file-export"></i>
                                        Export
                                    </a>
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

                let css_property = {
                    "color": "#fff",
                    "background-color": "rgb(173 180 187)",
                    "cursor": "not-allowed",
                    "border-color": "rgb(173 180 187)"
                }
                if (!`{{ $myAuth->hasPermission('exportlaporankasharian', 'export') }}`) {
                    $('#btnEkspor').prop('disabled', true)
                    $('#btnEkspor').css(css_property);
                }
            })


            $(document).on('click', `#btnEkspor`, function(event) {
                let periode = $('#crudForm').find('[name=periode]').val()
                let bank_id = $('#crudForm').find('[name=bank_id]').val()

                getCekExport().then((response) => {
                    window.open(` {{ route('laporankasharian.export') }}?sampai=${periode}&&jenis=${bank_id}`)
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

            function getCekExport() {

                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `${apiUrl}exportlaporankasharian/export`,
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

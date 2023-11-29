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
                                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span
                                        class="text-danger">*</span></label>
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
                                <label class="col-12 col-sm-2 col-form-label mt-2">Trado</label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="tradodari_id">
                                        <input type="text" name="tradodari" class="form-control tradodari-lookup">
                                    </div>
                                </div>
                                <div class="col-sm-1 mt-2">
                                    <h5 class="text-center mt-2">s/d</h5>
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="tradosampai_id">
                                        <input type="text" name="tradosampai" class="form-control tradosampai-lookup">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mt-4">
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

                $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');
                $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');

                if (!`{{ $myAuth->hasPermission('exportlaporanmingguansupir', 'export') }}`) {
                    $('#btnExport').attr('disabled', 'disabled')
                }
            })

            $(document).on('click', `#btnExport`, function(event) {
                let dari = $('#crudForm').find('[name=dari]').val()
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let tradodari_id = $('#crudForm').find('[name=tradodari_id]').val()
                let tradodari = $('#crudForm').find('[name=tradodari]').val()
                let tradosampai_id = $('#crudForm').find('[name=tradosampai_id]').val()
                let tradosampai = $('#crudForm').find('[name=tradosampai]').val()

                getCekExport().then((response) => {
                    window.open(
                        `{{ route('exportlaporanmingguansupir.export') }}?dari=${dari}&sampai=${sampai}&tradodari=${tradodari}&tradodari_id=${tradodari_id}&tradosampai=${tradosampai}&tradosampai_id=${tradosampai_id}`
                    )
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
                        url: `${apiUrl}exportlaporanmingguansupir/export`,
                        dataType: "JSON",
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: $('#crudForm').find('[name=dari]').val(),
                            sampai: $('#crudForm').find('[name=sampai]').val(),
                            tradodari: $('#crudForm').find('[name=tradodari]').val(),
                            tradodari_id: $('#crudForm').find('[name=tradodari_id]').val(),
                            tradosampai: $('#crudForm').find('[name=tradosampai]').val(),
                            tradosampai_id: $('#crudForm').find('[name=tradosampai_id]').val(),
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
                $('.tradodari-lookup').lookup({
                    title: 'Trado Lookup',
                    fileName: 'trado',
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                        }
                    },  
                    onSelectRow: (trado, element) => {
                        $('#crudForm [name=tradodari_id]').first().val(trado.id)
                        element.val(trado.kodetrado)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        $('#crudForm [name=tradodari_id]').first().val('')
                        element.val('')
                        element.data('currentValue', element.val())
                    }
                })

                $('.tradosampai-lookup').lookup({
                    title: 'Trado Lookup',
                    fileName: 'trado',
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                        }
                    },  
                    onSelectRow: (trado, element) => {
                        $('#crudForm [name=tradosampai_id]').first().val(trado.id)
                        element.val(trado.kodetrado)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        $('#crudForm [name=tradosampai_id]').first().val('')
                        element.val('')
                        element.data('currentValue', element.val())
                    }
                })
            }
        </script>
    @endpush()
@endsection

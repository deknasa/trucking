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
                                <h5 class="mt-3">s/d</h5>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="sampai" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Pelanggan<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="pelanggandari_id">
                                        <input type="text" name="pelanggandari"
                                            class="form-control pelanggandari-lookup">
                                    </div>
                                </div>
                                <h5 class="mt-3">s/d</h5>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="pelanggansampai_id">
                                        <input type="text" name="pelanggansampai"
                                            class="form-control pelanggansampai-lookup">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mt-4">
                                    <a id="btnPreview" class="btn btn-info mr-1 ">
                                        <i class="fas fa-print"></i>
                                        Report
                                    </a>
                                    <a id="btnExport" class="btn btn-warning mr-1 ">
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

                initDatepicker()
                $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');
                $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');
                initLookup()

                let css_property = {
                    "color": "#fff",
                    "background-color": "rgb(173 180 187)",
                    "cursor": "not-allowed",
                    "border-color": "rgb(173 180 187)"
                }
                if (!`{{ $myAuth->hasPermission('laporankartupiutangperpelanggan', 'report') }}`) {
                    $('#btnPreview').prop('disabled', true)
                    $('#btnPreview').css(css_property);
                }

            })

            $(document).on('click', `#btnPreview`, function(event) {
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let dari = $('#crudForm').find('[name=dari]').val()
                let pelanggandari_id = $('#crudForm').find('[name=pelanggandari_id]').val()
                let pelanggansampai_id = $('#crudForm').find('[name=pelanggansampai_id]').val()
                let pelanggandari = $('#crudForm').find('[name=pelanggandari]').val()
                let pelanggansampai = $('#crudForm').find('[name=pelanggansampai]').val()

                if (dari != '' && sampai != '') {

                    window.open(
                        `{{ route('laporankartupiutangperpelanggan.report') }}?sampai=${sampai}&dari=${dari}&pelanggandari_id=${pelanggandari_id}&pelanggansampai_id=${pelanggansampai_id}&pelanggandari=${pelanggandari}&pelanggansampai=${pelanggansampai}`
                    )
                } else {
                    showDialog('ISI SELURUH KOLOM')
                }
            })

            $(document).on('click', `#btnExport`, function(event) {
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let dari = $('#crudForm').find('[name=dari]').val()
                let pelanggandari_id = $('#crudForm').find('[name=pelanggandari_id]').val()
                let pelanggansampai_id = $('#crudForm').find('[name=pelanggansampai_id]').val()
                let pelanggandari = $('#crudForm').find('[name=pelanggandari]').val()
                let pelanggansampai = $('#crudForm').find('[name=pelanggansampai]').val()

                getCekReport().then((response) => {
                    window.open(
                        `{{ route('laporankartupiutangperpelanggan.export') }}?sampai=${sampai}&dari=${dari}&pelanggandari_id=${pelanggandari_id}&pelanggansampai_id=${pelanggansampai_id}&pelanggandari=${pelanggandari}&pelanggansampai=${pelanggansampai}`
                    )
                }).catch((error) => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        // return showDialog(error.responseJSON.errors.export);

                        setErrorMessages($('#crudForm'), error.responseJSON.errors);
                    } else {
                        showDialog(error.statusText, error.responseJSON.message)

                    }
                })

            })

            function getCekReport() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `${apiUrl}laporankartupiutangperpelanggan/report`,
                        dataType: "JSON",
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: $('#crudForm').find('[name=dari]').val(),
                            sampai: $('#crudForm').find('[name=sampai]').val(),
                            pelanggandari: $('#crudForm').find('[name=pelanggandari]').val(),
                            pelanggandari_id: $('#crudForm').find('[name=pelanggandari_id]').val(),
                            pelanggansampai: $('#crudForm').find('[name=pelanggansampai]').val(),
                            pelanggansampai_id: $('#crudForm').find('[name=pelanggansampai_id]').val(),
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
                        url: `${apiUrl}laporankartupiutangperpelanggan/export`,
                        dataType: "JSON",
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: $('#crudForm').find('[name=dari]').val(),
                            sampai: $('#crudForm').find('[name=sampai]').val(),
                            pelanggandari: $('#crudForm').find('[name=pelanggandari]').val(),
                            pelanggandari_id: $('#crudForm').find('[name=pelanggandari_id]').val(),
                            pelanggansampai: $('#crudForm').find('[name=pelanggansampai]').val(),
                            pelanggansampai_id: $('#crudForm').find('[name=pelanggansampai_id]').val(),
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
                $('.pelanggandari-lookup').lookup({
                    title: 'Pelanggan Lookup',
                    fileName: 'pelanggan',
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                        }
                    },
                    onSelectRow: (pelanggan, element) => {
                        $('#crudForm [name=pelanggandari_id]').first().val(pelanggan.kodepelanggan)
                        element.val(pelanggan.namapelanggan)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        element.val('')
                        $(`#crudForm [name="pelanggandari_id"]`).first().val('')
                        element.data('currentValue', element.val())
                    }
                })
                $('.pelanggansampai-lookup').lookup({
                    title: 'Pelanggan Lookup',
                    fileName: 'pelanggan',
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                        }
                    },
                    onSelectRow: (pelanggan, element) => {
                        $('#crudForm [name=pelanggansampai_id]').first().val(pelanggan.kodepelanggan)
                        element.val(pelanggan.namapelanggan)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        element.val('')
                        $(`#crudForm [name="pelanggansampai_id"]`).first().val('')
                        element.data('currentValue', element.val())
                    }
                })
            }
        </script>
    @endpush()
@endsection

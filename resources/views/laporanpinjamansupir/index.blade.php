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
                                        <input type="text" name="sampai" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Jenis Pinjaman<span
                                        class="text-danger"></span></label>
                                <div class="col-sm-4 mt-2">
                                    {{-- <select name="jenis" id="jenis" class="form-select select2bs4" style="width: 100%;">
                                </select> --}}
                                    <input type="hidden" name="jenis">
                                    <input type="text" name="jenisnama" data-target-name="jenis" id="jenisnama"
                                        class="form-control lg-form jenis-lookup">
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
    @push('report-scripts')
    @endpush()
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
                // initSelect2($('#crudForm').find('[name=jenis]'), false)
                // setJenisKaryawanOptions($('#crudForm'))

                initDatepicker()
                $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');

                initLookup()
                if (!`{{ $myAuth->hasPermission('laporanpinjamansupir', 'report') }}`) {
                    $('#btnPreview').attr('disabled', 'disabled')
                }
                if (!`{{ $myAuth->hasPermission('laporanpinjamansupir', 'export') }}`) {
                    $('#btnExport').attr('disabled', 'disabled')
                }
            })

            $(document).on('click', `#btnPreview`, function(event) {
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let jenis = $('#crudForm').find('[name=jenis]').val()

                getCekReport().then((response) => {
                    window.open(`{{ route('laporanpinjamansupir.report') }}?sampai=${sampai}&jenis=${jenis}`)
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

            function getCekReport() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `${apiUrl}laporanpinjamansupir/report`,
                        dataType: "JSON",
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            sampai: $('#crudForm').find('[name=sampai]').val(),
                            jenis: $('#crudForm').find('[name=jenis]').val(),
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
        $(`.jenis-lookup`).lookupV3({
            title: 'Jenis Lookup',
            fileName: 'parameterV3',
            searching: ['text'],
            labelColumn: false,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'STATUS POSTING',
                    subgrp: 'STATUS POSTING',
                };
            },
            onSelectRow: (status, element) => {
                let elId = element.data('targetName')
                $(`#crudForm [name=${elId}]`).first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let elId = element.data('targetName')
                $(`#crudForm [name=${elId}]`).first().val('')
                element.val('')
                element.data('currentValue', element.val())
            },
        });
    }

            $(document).on('click', `#btnExport`, function(event) {
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let jenis = $('#crudForm').find('[name=jenis]').val()

                if (sampai != '') {
                    $('#processingLoader').removeClass('d-none')

                    $.ajax({
                        // url: `{{ route('laporanpinjamansupir.export') }}?sampai=${sampai}&jenis=${jenis}`,
                        url: `${apiUrl}laporanpinjamansupir/export`,
                        type: 'GET',
                        data: {
                            sampai: sampai,
                            jenis: jenis
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
                                    link.download = 'LAP. PINJAMAN SUPIR ' + new Date().getTime() + '.xlsx';
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

            function laporanpinjamansupir(data, detailParams, dataCabang) {
                Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
                Stimulsoft.Base.StiFontCollection.addOpentypeFontFile(
                    "{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

                var report = new Stimulsoft.Report.StiReport();
                var dataSet = new Stimulsoft.System.Data.DataSet("Data");

                if (accessCabang == 'MEDAN') {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanPinjamanSupirA4.mrt') }}`)
                } else if (accessCabang == 'MAKASSAR') {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanPinjamanSupirLetter.mrt') }}`)
                } else {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanPinjamanSupir.mrt') }}`);
                }

                // report.loadFile(`{{ asset('public/reports/ReportLaporanPinjamanSupir.mrt') }}`);

                dataSet.readJson({
                    'data': data,
                    'dataCabang': dataCabang,
                    'parameter': detailParams
                });

                report.regData(dataSet.dataSetName, '', dataSet);
                report.dictionary.synchronize();

                // var options = new Stimulsoft.Designer.StiDesignerOptions()
                // options.appearance.fullScreenMode = true
                // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
                // designer.report = report;
                // designer.renderHtml('content');

                report.renderAsync(function() {
                    report.exportDocumentAsync(function(pdfData) {
                        let blob = new Blob([new Uint8Array(pdfData)], {
                            type: 'application/pdf'
                        });
                        let fileURL = URL.createObjectURL(blob);
                        window.open(fileURL, '_blank');
                        manipulatePdfWithJsPdf(pdfData);
                    }, Stimulsoft.Report.StiExportFormat.Pdf);
                });
            }

        </script>
    @endpush()
@endsection

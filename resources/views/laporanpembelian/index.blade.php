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

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">SUPPLIER<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="supplierdari_id">
                                <input type="text" id="supplierdari" name="supplierdari" class="form-control supplierdari-lookup">
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="suppliersampai_id">
                                <input type="text" id="suppliersampai" name="suppliersampai" class="form-control suppliersampai-lookup">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">STATUS<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="status" id="status">
                                <input type="text" id="status" name="statusnama" class="form-control status-lookup">
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
<link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.viewer.office2013.whiteblue.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.designer.office2013.whiteblue.css') }}">
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.reports.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.viewer.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.designer.js') }}"></script>
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

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');

        initLookup()

        if (!`{{ $myAuth->hasPermission('laporanpembelian', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanpembelian', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let supplierdari_id = $('#crudForm').find('[name=supplierdari_id]').val()
        let suppliersampai_id = $('#crudForm').find('[name=suppliersampai_id]').val()
        let supplierdari = $('#crudForm').find('[name=supplierdari]').val()
        let suppliersampai = $('#crudForm').find('[name=suppliersampai]').val()
        let status = $('#crudForm').find('[name=statusnama]').val()

        $.ajax({
            url: `${apiUrl}laporanpembelian/report`,
            method: 'GET',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                dari: dari,
                sampai: sampai,
                supplierdari_id: supplierdari_id,
                suppliersampai_id: suppliersampai_id,
                supplierdari: supplierdari,
                suppliersampai: suppliersampai,
                status: status,
            },
            success: function(response) {
                // console.log(response)
                let data = response.data
                let dataCabang = response.namacabang
                let detailParams = {
                    dari: dari,
                    sampai: sampai,
                    supplierdari_id: supplierdari_id,
                    suppliersampai_id: suppliersampai_id,
                    supplierdari: supplierdari,
                    suppliersampai: suppliersampai,
                    status: status,
                };
                laporanpembelian(data, detailParams, dataCabang);
            },
            error: function(xhr, status, error) {
                $('#processingLoader').addClass('d-none')
                showDialog('TIDAK ADA DATA')
            }
        })
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let supplierdari_id = $('#crudForm').find('[name=supplierdari_id]').val()
        let suppliersampai_id = $('#crudForm').find('[name=suppliersampai_id]').val()
        let supplierdari = $('#crudForm').find('[name=supplierdari]').val()
        let suppliersampai = $('#crudForm').find('[name=suppliersampai]').val()
        let status = $('#crudForm').find('[name=statusnama]').val()
        $.ajax({
            url: `${apiUrl}laporanpembelian/export`,
            // url: `{{ route('laporanpembelian.export') }}?dari=${dari}&sampai=${sampai}&supplierdari=${supplierdari}&supplierdari_id=${supplierdari_id}&suppliersampai=${suppliersampai}&suppliersampai_id=${suppliersampai_id}&status=${status}`,
            type: 'GET',
            data: {
                dari: dari,
                sampai: sampai,
                supplierdari_id: supplierdari_id,
                suppliersampai_id: suppliersampai_id,
                supplierdari: supplierdari,
                suppliersampai: suppliersampai,
                status: status
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
                        link.download = 'LAP. PEMBELIAN PER SUPPLIER ' + new Date().getTime() + '.xlsx';
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

    })

    function laporanpembelian(data, detailParams, dataCabang) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        report.loadFile(`{{ asset('public/reports/ReportPembelian3.mrt') }}`);

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

    // function getCekReport() {
    //     return new Promise((resolve, reject) => {
    //         $.ajax({
    //             url: `${apiUrl}laporanpembelian/report`,
    //             dataType: "JSON",
    //             headers: {
    //                 Authorization: `Bearer ${accessToken}`
    //             },
    //             data: {
    //                 dari: $('#crudForm').find('[name=dari]').val(),
    //                 sampai: $('#crudForm').find('[name=sampai]').val(),
    //                 supplierdari: $('#crudForm').find('[name=supplierdari]').val(),
    //                 supplierdari_id: $('#crudForm').find('[name=supplierdari_id]').val(),
    //                 suppliersampai: $('#crudForm').find('[name=suppliersampai]').val(),
    //                 suppliersampai_id: $('#crudForm').find('[name=suppliersampai_id]').val(),
    //                 status: $('#crudForm').find('[name=statusnama]').val(),
    //                 isCheck: true,
    //             },
    //             success: (response) => {
    //                 resolve(response);
    //             },
    //             error: error => {
    //                 reject(error)

    //             },
    //         });
    //     });
    // }

    function getCekExport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanpembelian/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    supplierdari: $('#crudForm').find('[name=supplierdari]').val(),
                    supplierdari_id: $('#crudForm').find('[name=supplierdari_id]').val(),
                    suppliersampai: $('#crudForm').find('[name=suppliersampai]').val(),
                    suppliersampai_id: $('#crudForm').find('[name=suppliersampai_id]').val(),
                    status: $('#crudForm').find('[name=status]').val(),
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

        $('.supplierdari-lookup').lookupMaster({
            title: 'Supplier Lookup',
            fileName: 'supplierMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supplierdari_id',
                    searchText: 'supplierdari-lookup',
                    title: 'Supplier Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=supplierdari_id]').first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supplierdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.suppliersampai-lookup').lookupMaster({
            title: 'Supplier Lookup',
            fileName: 'supplierMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'suppliersampai_id',
                    searchText: 'suppliersampai-lookup',
                    title: 'Supplier Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=suppliersampai_id]').first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=suppliersampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.status-lookup').lookupMaster({
            title: 'Status Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'LAPORAN PEMBELIAN',
                    subgrp: 'LAPORAN PEMBELIAN',
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'status_id',
                    searchText: 'status-lookup',
                    title: 'Status Lookup',
                    typeSearch: 'ALL',
                    singleColumn: true,
                    hideLabel: true,
                }
            },
            onSelectRow: (status, element) => {
                $('#crudForm [name=status]').first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=status]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        function getCekReport() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}laporanpembelian/report`,
                    dataType: "JSON",
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        dari: $('#crudForm').find('[name=dari]').val(),
                        sampai: $('#crudForm').find('[name=sampai]').val(),
                        supplierdari: $('#crudForm').find('[name=supplierdari]').val(),
                        supplierdari_id: $('#crudForm').find('[name=supplierdari_id]').val(),
                        suppliersampai: $('#crudForm').find('[name=suppliersampai]').val(),
                        suppliersampai_id: $('#crudForm').find('[name=suppliersampai_id]').val(),
                        status: $('#crudForm').find('[name=status]').val(),
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
                    url: `${apiUrl}laporanpembelian/export`,
                    dataType: "JSON",
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        dari: $('#crudForm').find('[name=dari]').val(),
                        sampai: $('#crudForm').find('[name=sampai]').val(),
                        supplierdari: $('#crudForm').find('[name=supplierdari]').val(),
                        supplierdari_id: $('#crudForm').find('[name=supplierdari_id]').val(),
                        suppliersampai: $('#crudForm').find('[name=suppliersampai]').val(),
                        suppliersampai_id: $('#crudForm').find('[name=suppliersampai_id]').val(),
                        status: $('#crudForm').find('[name=status]').val(),
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
    }
</script>
@endpush()
@endsection
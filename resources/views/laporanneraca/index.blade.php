@extends('layouts.master')

@section('content')
{{-- <style>
    /* .ui-datepicker-calendar {
        display: none;
    } */
</style> --}}
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
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">Periode <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control monthpicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Cabang<span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="cabang_id">
                                <input type="text" name="cabang" class="form-control cabang-lookup">
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

        initLookup()
        initMonthpicker()
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('mm-yy', new Date())).trigger(
            'change');

        // let idcabang = `<?php $data['idcabang']['text'] ?>`;
        let idcabang = `<?= $cabang['id'] ?>`;
        if (idcabang != 1) {
            $('#crudForm [name=cabang]').attr('readonly', true)
            $('#crudForm [name=cabang]').parents('.input-group').find('.input-group-append').hide()
            $('#crudForm [name=cabang]').parents('.input-group').find('.button-clear').hide()
        }
        $('#crudForm [name=cabang_id]').val(`<?= $cabang['id'] ?>`);
        $('#crudForm [name=cabang]').val(`<?= $cabang['namacabang'] ?>`);

        if (!`{{ $myAuth->hasPermission('laporanneraca', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanneraca', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#reportPrinterBesar`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()

        // getCekReport().then((response) => {
        //     // $.ajax({
        //     //     url: `{{ route('laporanneraca.report') }}?sampai=${sampai}`,
        //     // });
        //     window.open(`{{ route('laporanneraca.report') }}?sampai=${sampai}&cabang_id=${cabang_id}&printer=reportPrinterBesar`)
        // }).catch((error) => {
        //     if (error.status === 422) {
        //         $('.is-invalid').removeClass('is-invalid')
        //         $('.invalid-feedback').remove()

        //         setErrorMessages($('#crudForm'), error.responseJSON.errors);
        //     } else {
        //         showDialog(error.statusText, error.responseJSON.message)

        //     }
        // })

        getCekReport(sampai, cabang_id, 'reportPrinterBesar')
    })

    $(document).on('click', `#reportPrinterKecil`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()


        // getCekReport().then((response) => {
        //     // $.ajax({
        //     //     url: `{{ route('laporanneraca.report') }}?sampai=${sampai}`,
        //     // });
        //     window.open(`{{ route('laporanneraca.report') }}?sampai=${sampai}&cabang_id=${cabang_id}&printer=reportPrinterKecil`)
        // }).catch((error) => {
        //     if (error.status === 422) {
        //         $('.is-invalid').removeClass('is-invalid')
        //         $('.invalid-feedback').remove()

        //         setErrorMessages($('#crudForm'), error.responseJSON.errors);
        //     } else {
        //         showDialog(error.statusText, error.responseJSON.message)

        //     }
        // })

        getCekReport(sampai, cabang_id, 'reportPrinterKecil')

    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let sampai = $('#crudForm').find('[name=sampai]').val()
        let cabang_id = $('#crudForm').find('[name=cabang_id]').val()

        $.ajax({
            url: `${apiUrl}laporanneraca/export`,
            // url: `{{ route('laporanneraca.export') }}?sampai=${sampai}&cabang_id=${cabang_id}`,
            type: 'GET',
            data : {
                sampai : sampai,
                cabang_id : cabang_id
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
                        link.download = `LAPORAN NERACA ${new Date().getTime()}.xlsx`;
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

    // function getCekReport() {

    //     return new Promise((resolve, reject) => {
    //         $.ajax({
    //             url: `${apiUrl}laporanneraca/report`,
    //             dataType: "JSON",
    //             headers: {
    //                 Authorization: `Bearer ${accessToken}`
    //             },
    //             data: {
    //                 sampai: $('#crudForm').find('[name=sampai]').val(),
    //                 cabang_id: $('#crudForm').find('[name=cabang_id]').val(),
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

    function getCekReport(sampai, cabang_id, printer) {
        $.ajax({
                url: `${apiUrl}laporanneraca/report`,
                method: 'GET',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    sampai: sampai,
                    cabang_id: cabang_id
                },
                success: function(response) {
                    // console.log(response)
                    let data = response.data
                    let dataheader = response.dataheader
                    let detailParams = {
                        sampai: sampai,
                        cabang_id: cabang_id,
                        judullaporan: 'Laporan Neraca',
                        tanggal_cetak: `${new Date().getDate()}-${new Date().getMonth() + 1}-${new Date().getFullYear()} ${new Date().getHours()}:${new Date().getMinutes()}:${new Date().getSeconds()}`,
                    };
                    laporanneraca(data, detailParams, dataheader, printer);
                },
                error: function(error) {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        $('#rangeTglModal').modal('hide')
                        setErrorMessages($('#crudForm'), error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON.message);
                    }
                }
            })
            .always(() => {
                $('#processingLoader').addClass('d-none')
            });
    }

    function getCekExport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanneraca/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    cabang_id: $('#crudForm').find('[name=cabang_id]').val(),
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

    function laporanneraca(data, detailParams, dataheader, printer) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (printer == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanNeracaBesar.mrt') }}`);
        } else {
            report.loadFile(`{{ asset('public/reports/ReportLaporanNeraca.mrt') }}`);
        }

        dataSet.readJson({
            'data': data,
            'dataheader': dataheader,
            'parameter': detailParams
        });

        console.log('data',data)
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

    function initLookup() {
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
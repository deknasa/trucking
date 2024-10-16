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
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
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

        initDatepicker()
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');

        if (!`{{ $myAuth->hasPermission('laporanhutanggiro', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('laporanhutanggiro', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        getCekReport().then((response) => {
            window.open(`{{ route('laporanhutanggiro.report') }}?periode=${periode}`)
        }).catch((error) => {
            if (error.status === 422) {
                return showDialog(error.responseJSON.errors.export);
            } else {
                showDialog(error.statusText, error.responseJSON.message)
            }
        })
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let periode = $('#crudForm').find('[name=periode]').val()

        $.ajax({
            url: `${apiUrl}laporanhutanggiro/export`,
            // url: `{{ route('laporanhutanggiro.export') }}?periode=${periode}`,
            type: 'GET',
            data : {
                periode : periode
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
                        link.download = 'LAPORAN HUTANG GIRO ' + new Date().getTime() + '.xlsx';
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

    function laporanhutanggiro(data, detailParams, dataCabang,cabang) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (cabang == 'MEDAN') {
            var reportFile = `{{ asset('public/reports/ReportHutangGiroA4.mrt') }}`;
        }else if(cabang == 'MAKASSAR'){
            var reportFile = `{{ asset('public/reports/ReportHutangGiroLetter.mrt') }}`;
        }else{
            var reportFile = `{{ asset('public/reports/ReportHutangGiro.mrt') }}`;
        }

       
        report.loadFile(reportFile);

        dataSet.readJson({
            'data': data,
            'dataCabang': dataCabang,
            'parameter': detailParams
        });

        report.regData(dataSet.dataSetName, '', dataSet);
        report.dictionary.synchronize();

        // printJS('http://localhost/Report.pdf');

        // var options = new Stimulsoft.Designer.StiDesignerOptions()
        // options.appearance.fullScreenMode = true
        // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
        // designer.report = report;
        // designer.renderHtml('content');

        // console.log(report)

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

    function getCekReport() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanhutanggiro/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    periode: $('#crudForm').find('[name=periode]').val(),
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
                url: `${apiUrl}laporanhutanggiro/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    periode: $('#crudForm').find('[name=periode]').val(),
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
</script>
@endpush()
@endsection
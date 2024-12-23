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
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">JENIS STOK<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="kelompok_id">
                                <input type="text" name="kelompok" id="kelompok" class="form-control kelompok-lookup">
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
        initLookup()

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        if (!`{{ $myAuth->hasPermission('laporanklaimpjtsupir', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanklaimpjtsupir', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let kelompokid = $('#crudForm').find('[name=kelompok_id]').val()
        let kelompok = $('#crudForm').find('[name=kelompok]').val()

        getCekReport().then((response) => {
            window.open(`{{ route('laporanklaimpjtsupir.report') }}?sampai=${sampai}&dari=${dari}&kelompok=${kelompok}&kelompok_id=${kelompokid}`)
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
                url: `${apiUrl}laporanklaimpjtsupir/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    dari: $('#crudForm').find('[name=dari]').val(),
                    kelompok: $('#crudForm').find('[name=kelompok_id]').val(),
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

    $(document).on('click', `#btnExport`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
        let kelompok = $('#crudForm').find('[name=kelompok]').val()

        if (dari != '' && sampai != '') {
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}laporanklaimpjtsupir/export`,
                // url: `{{ route('laporanklaimpjtsupir.export') }}?sampai=${sampai}&dari=${dari}&kelompok_id=${kelompok_id}&kelompok=${kelompok}`,
                type: 'GET',
                data : {
                    dari : dari,
                    sampai : sampai,
                    kelompok_id : kelompok_id,
                    kelompok : kelompok,
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
                            link.download = 'LAP. KLAIM PJT SUPIR ' + new Date().getTime() + '.xlsx';
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

    function laporanklaimpjtsupir(data, detailParams, dataCabang) {

        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (accessCabang == 'MEDAN') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanKlaimPJTSupirA4.mrt') }}`)
        } else if (accessCabang == 'MAKASSAR') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanKlaimPJTSupirLetter.mrt') }}`)
        } else {
            report.loadFile(`{{ asset('public/reports/ReportLaporanKlaimPJTSupir.mrt') }}`);
        }

        // report.loadFile(`{{ asset('public/reports/ReportLaporanKlaimPJTSupir.mrt') }}`);

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

    function initLookup() {
        $('.kelompok-lookup').lookupV3({
            title: 'kelompok Lookup',
            fileName: 'kelompokV3',
            searching: ['kodekelompok'],
            labelColumn: false,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kategori, element) => {
                $('#crudForm [name=kelompok_id]').first().val(kategori.id)
                element.val(kategori.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="kelompok_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
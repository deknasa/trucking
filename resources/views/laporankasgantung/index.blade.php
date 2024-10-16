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
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kas/Bank<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="bank_id" value="{{ $data['bank_id'] }}">
                                <input type="text" name="bank" id="bank" value="{{ $data['bank'] }}" class="form-control bank-lookup">
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
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


        if (!`{{ $myAuth->hasPermission('laporankasgantung', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('laporankasgantung', 'export') }}`) {
            $('#btnExport').prop('disabled', true)
            $('#btnExport').css(css_property);
        }

    })

    $(document).on('click', `#reportPrinterBesar`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        let bank = $('#crudForm').find('[name=bank]').val()
        let bank_id = $('#crudForm').find('[name=bank_id]').val()

        if (periode != '') {

            window.open(`{{ route('laporankasgantung.report') }}?periode=${periode}&bank=${bank}&bank_id=${bank_id}&printer=reportPrinterBesar`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#reportPrinterKecil`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        let bank = $('#crudForm').find('[name=bank]').val()
        let bank_id = $('#crudForm').find('[name=bank_id]').val()

        if (periode != '') {

            window.open(`{{ route('laporankasgantung.report') }}?periode=${periode}&bank=${bank}&bank_id=${bank_id}&printer=reportPrinterKecil`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function getCekReport(periode, bank_id, bank, printer) {
        $.ajax({
                url: `${apiUrl}laporankasgantung/report`,
                method: 'GET',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    periode: periode,
                    bank_id: bank_id,
                    bank: bank
                },
                success: function(response) {
                    // console.log(response)
                    let data = response.data
                    let dataCabang = response.namacabang
                    let detailParams = {
                        periode: periode,
                        bank_id: bank_id,
                        bank: bank
                    };
                    laporankasgantung(data, detailParams, dataCabang, printer);
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

    $(document).on('click', `#btnExport`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        let bank_id = $('#crudForm').find('[name=bank_id]').val()
        let bank = $('#crudForm').find('[name=bank]').val()

        if (periode != '' && bank_id != '') {
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}laporankasgantung/export`,
                // url: `{{ route('laporankasgantung.export') }}?periode=${periode}&bank_id=${bank_id}&bank=${bank}`,
                type: 'GET',
                data: {
                    periode: periode,
                    bank_id: bank_id,
                    bank: bank,
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
                            link.download = 'LAP. KAS GANTUNG ' + bank + ' ' + new Date().getTime() + '.xlsx';
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

    function laporankasgantung(data, detailParams, dataCabang, printer) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (printer == 'reportPrinterBesar') {
            if (accessCabang == 'MEDAN') {
                report.loadFile(`{{ asset('public/reports/ReportLaporanKasGantungBesarA4.mrt') }}`)
            } else if (accessCabang == 'MAKASSAR') {
                report.loadFile(`{{ asset('public/reports/ReportLaporanKasGantungBesarLetter.mrt') }}`)
            } else {
                report.loadFile(`{{ asset('public/reports/ReportLaporanKasGantungBesar.mrt') }}`);
            }
        } else {
            report.loadFile(`{{ asset('public/reports/ReportLaporanKasGantung.mrt') }}`);
        }

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

        $('.bank-lookup').lookupV3({
            title: 'Bank Lookup',
            fileName: 'bankV3',
            searching: ['namabank'],
            labelColumn: false,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
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
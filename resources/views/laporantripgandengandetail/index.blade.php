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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Gandengan</label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="gandengandari_id">
                                    <input type="text" name="gandengandari" id="gandengandari" class="form-control gandengandari-lookup">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="gandengansampai_id">
                                    <input type="text" name="gandengansampai" id="gandengansampai" class="form-control gandengansampai-lookup">
                                </div>
                            </div>
                        </div>
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
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        initLookup()

        if (!`{{ $myAuth->hasPermission('laporantripgandengandetail', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporantripgandengandetail', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let gandengandari_id = $('#crudForm').find('[name=gandengandari_id]').val()
        let gandengansampai_id = $('#crudForm').find('[name=gandengansampai_id]').val()
        let gandengandari = $('#crudForm').find('[name=gandengandari]').val()
        let gandengansampai = $('#crudForm').find('[name=gandengansampai]').val()
        if (dari != '' && sampai != '') {
            window.open(`{{ route('laporantripgandengandetail.report') }}?sampai=${sampai}&dari=${dari}&gandengandari_id=${gandengandari_id}&gandengansampai_id=${gandengansampai_id}&gandengandari=${gandengandari}&gandengansampai=${gandengansampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let gandengandari_id = $('#crudForm').find('[name=gandengandari_id]').val()
        let gandengansampai_id = $('#crudForm').find('[name=gandengansampai_id]').val()
        let gandengandari = $('#crudForm').find('[name=gandengandari]').val()
        let gandengansampai = $('#crudForm').find('[name=gandengansampai]').val()


        if (dari != '' && sampai != '') {

            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}laporantripgandengandetail/export`,
                // url: `{{ route('laporantripgandengandetail.export') }}?sampai=${sampai}&dari=${dari}&gandengandari_id=${gandengandari_id}&gandengansampai_id=${gandengansampai_id}&gandengandari=${gandengandari}&gandengansampai=${gandengansampai}`,
                type: 'GET',
                data: {
                    dari: dari,
                    sampai: sampai,
                    gandengandari_id: gandengandari_id,
                    gandengansampai_id: gandengansampai_id,
                    gandengandari: gandengandari,
                    gandengansampai: gandengansampai,
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
                            link.download = 'LAP. TRIP GANDENGAN ' + new Date().getTime() + '.xlsx';
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


    function initLookup() {
        $('.gandengandari-lookup').lookupV3({
            title: 'Gandengan Lookup',
            fileName: 'gandenganV3',
            searching: ['name','keterangan'],
            labelColumn: true,
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'kelompok_id',
                    searchText: 'kelompok-lookup',
                    title: 'Kelompok',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengandari_id]').first().val(gandengan.id)
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="gandengandari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.gandengansampai-lookup').lookupV3({
            title: 'Gandengan Lookup',
            fileName: 'gandenganV3',
            searching: ['name','keterangan'],
            labelColumn: true,
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengansampai_id]').first().val(gandengan.id)
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="gandengansampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }
    function laporantripgandengandetail(data, detailParams, dataCabang,cabang) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (cabang == 'MEDAN') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanTripGandenganDetailA4.mrt') }}`);
        }else if(cabang == 'MAKASSAR'){
            report.loadFile(`{{ asset('public/reports/ReportLaporanTripGandenganDetailLetter.mrt') }}`);
        }else{
            report.loadFile(`{{ asset('public/reports/ReportLaporanTripGandenganDetail.mrt') }}`);
        }

        // report.loadFile(`{{ asset('public/reports/ReportLaporanTripGandenganDetail.mrt') }}`);

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
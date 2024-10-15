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
                            <label class="col-12 col-sm-2 col-form-label mt-2">SUPIR (DARI)<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="supirdari_id">
                                <input type="text" name="supirdari" id="supirdari" class="form-control supirdari-lookup">
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
        initSelect2($('#crudForm').find('[name=status]'), false)
        setStatusKembali($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=ricdari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ricsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        initLookup()
        if (!`{{ $myAuth->hasPermission('laporanhistorydeposito', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanhistorydeposito', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let supirdari_id = $('#crudForm').find('[name=supirdari_id]').val()
        let supirdari = $('#crudForm').find('[name=supirdari]').val()
        let supirsampai = $('#crudForm').find('[name=supirsampai_id]').val()
        if (supirdari_id != '') {
            window.open(`{{ route('laporanhistorydeposito.report') }}?&supirdari_id=${supirdari_id}&supirdari=${supirdari}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let supirdari_id = $('#crudForm').find('[name=supirdari_id]').val()
        let supirdari = $('#crudForm').find('[name=supirdari]').val()
        let supirsampai = $('#crudForm').find('[name=supirsampai_id]').val()

        if (supirdari_id != '') {
            $.ajax({
                url: `${apiUrl}laporanhistorydeposito/export`,
                // url: `{{ route('laporanhistorydeposito.export') }}?&supirdari_id=${supirdari_id}&supirdari=${supirdari}`,
                type: 'GET',
                data: {
                    supirdari_id: supirdari_id,
                    supirdari: supirdari,
                    supirsampai: supirsampai,
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
                            link.download = 'LAP. HISTORY DEPOSITO  ' + new Date().getTime() + '.xlsx';
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
            $('#processingLoader').addClass('d-none')
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {
        $('.supirdari-lookup').lookupV3({
            title: 'Supir Lookup',
            fileName: 'supirV3',
            searching: ['namasupir',"namaalias"],
            labelColumn: true,
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            filterToolbar: true,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'ALL',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supirdari_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="supirdari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        });

        $('.supirsampai-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'ALL',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supirsampai_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="supirsampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function laporanhistorydeposito(data, detailParams, dataCabang, user,cabang) {

        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (cabang == 'MEDAN') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanHistoryPenjualanA4.mrt') }}`);
        }else if(cabang == 'MAKASSAR'){
            report.loadFile(`{{ asset('public/reports/ReportLaporanHistoryPenjualanLetter.mrt') }}`);
        }else{
            report.loadFile(`{{ asset('public/reports/ReportLaporanHistoryPenjualan.mrt') }}`);
        }

        // report.loadFile(`{{ asset('public/reports/ReportLaporanHistoryPenjualan.mrt') }}`);

        dataSet.readJson({
            'data': data,
            'dataCabang': dataCabang,
            'user': user,
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

    const setStatusKembali = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=status]').append(
            new Option('-- PILIH STATUS KEMBALI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'STATUS KEMBALI'
        })
        data.push({
            name: 'subgrp',
            value: 'STATUS KEMBALI'
        })
        $.ajax({
            url: `${apiUrl}parameter/combo`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {

                response.data.forEach(statusKembali => {
                    let option = new Option(statusKembali.text, statusKembali.id)
                    relatedForm.find('[name=status]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=approve]')
                //     .val($(`#crudForm [name=approve] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');

                // resolve()
            }
        })
        // })
    }
</script>
@endpush()
@endsection
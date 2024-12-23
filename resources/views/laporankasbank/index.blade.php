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
                                <label class="col-12 col-sm-2 col-form-label mt-2">KAS/BANK<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="bank_id">
                                        <input type="text" id="bank" name="bank"
                                            class="form-control bank-lookup">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display:none;">
                                <label class="col-12 col-sm-2 col-form-label mt-2">PERIODE DATA<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" value="{{ $data['defaultperiode']['id'] }}"
                                            name="periodedata_id">
                                        <input type="text" id="periodedata" value="{{ $data['defaultperiode']['text'] }}"
                                            name="periodedata" class="form-control periodedata-lookup">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mt-4">
                                    <div class="btn-group dropup  scrollable-menu">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                            id="btnPreview">
                                            <i class="fas fa-print"></i>
                                            Report
                                        </button>
                                        <ul class="dropdown-menu" id="menu-approve" aria-labelledby="btnPreview">
                                            <li><a class="dropdown-item" id="reportPrinterBesar" href="#">Printer
                                                    Lain</a></li>
                                            <li><a class="dropdown-item" id="reportPrinterKecil" href="#">Printer
                                                    Epson Seri LX</a></li>
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

                $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');
                $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');

                if (!`{{ $myAuth->hasPermission('laporankasbank', 'report') }}`) {
                    $('#btnPreview').attr('disabled', 'disabled')
                }
                if (!`{{ $myAuth->hasPermission('laporankasbank', 'export') }}`) {
                    $('#btnExport').attr('disabled', 'disabled')
                }
            })

            // $(document).on('click', `#reportPrinterBesar`, function(event) {
            //     let dari = $('#crudForm').find('[name=dari]').val()
            //     let sampai = $('#crudForm').find('[name=sampai]').val()
            //     let bank_id = $('#crudForm').find('[name=bank_id]').val()
            //     let bank = $('#crudForm').find('[name=bank]').val()
            //     let periodedata_id = $('#crudForm').find('[name=periodedata_id]').val()
            //     let periodedata = $('#crudForm').find('[name=periodedata]').val()
              
            //     getCekReport(dari, sampai, bank_id, bank, periodedata_id, periodedata, 'reportPrinterBesar')
            // })

            $(document).on('click', `#reportPrinterKecil`, function(event) {
                let dari = $('#crudForm').find('[name=dari]').val()
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let bank_id = $('#crudForm').find('[name=bank_id]').val()
                let bank = $('#crudForm').find('[name=bank]').val()
                let periodedata_id = $('#crudForm').find('[name=periodedata_id]').val()
                let periodedata = $('#crudForm').find('[name=periodedata]').val()

                getCekReport().then((response) => {
                    window.open(`{{ route('laporankasbank.report') }}?dari=${dari}&sampai=${sampai}&bank=${bank}&bank_id=${bank_id}&periodedata=${periodedata}&periodedata_id=${periodedata_id}&printer=reportPrinterKecil`)
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

            $(document).on('click', `#reportPrinterBesar`, function(event) {
                let dari = $('#crudForm').find('[name=dari]').val()
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let bank_id = $('#crudForm').find('[name=bank_id]').val()
                let bank = $('#crudForm').find('[name=bank]').val()
                let periodedata_id = $('#crudForm').find('[name=periodedata_id]').val()
                let periodedata = $('#crudForm').find('[name=periodedata]').val()
                getCekReport().then((response) => {
                    window.open(`{{ route('laporankasbank.report') }}?dari=${dari}&sampai=${sampai}&bank=${bank}&bank_id=${bank_id}&periodedata=${periodedata}&periodedata_id=${periodedata_id}&printer=reportPrinterBesar`)
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
    

            $(document).on('click', `#btnExport`, function(event) {
                $('#processingLoader').removeClass('d-none')

                let dari = $('#crudForm').find('[name=dari]').val()
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let bank_id = $('#crudForm').find('[name=bank_id]').val()
                let bank = $('#crudForm').find('[name=bank]').val()
                let periodedata_id = $('#crudForm').find('[name=periodedata_id]').val()
                let periodedata = $('#crudForm').find('[name=periodedata]').val()

                $.ajax({
                    url: `${apiUrl}laporankasbank/export`,
                    // url: `{{ route('laporankasbank.export') }}?dari=${dari}&sampai=${sampai}&bank=${bank}&bank_id=${bank_id}&periodedata=${periodedata}&periodedata_id=${periodedata_id}`,
                    type: 'GET',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                    },
                    data: {
                        dari: dari,
                        sampai: sampai,
                        bank_id: bank_id,
                        bank: bank,
                        periodedata_id: periodedata_id,
                        periodedata: periodedata
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
                                link.download = `LAPORAN ${bank} ${new Date().getTime()}.xlsx`;
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

            // function getCekReport(dari, sampai, bank_id, bank, periodedata_id, periodedata, printer) {
            //     console.log(dari, sampai, bank_id, bank, periodedata_id, periodedata, printer)
            //     $.ajax({
            //             url: `${apiUrl}laporankasbank/report`,
            //             method: 'GET',
            //             headers: {
            //                 Authorization: `Bearer ${accessToken}`
            //             },
            //             data: {
            //                 dari: dari,
            //                 sampai: sampai,
            //                 bank_id: bank_id,
            //                 bank: bank,
            //                 periodedata_id: periodedata_id,
            //                 periodedata: periodedata,
            //             },
            //             success: function(response) {
            //                 console.log('adjsd');
                            
            //                 let data = response.data
            //                 let datasaldo = response.datasaldo
            //                 let infopemeriksa = response.infopemeriksa
            //                 let dataCabang = response.namacabang
            //                 let cabang = accessCabang
            //                 let detailParams = {
            //                     dari: dari,
            //                     sampai: sampai,
            //                     bank_id: bank_id,
            //                     bank: bank,
            //                     periodedata_id: periodedata_id,
            //                     periodedata: periodedata,
            //                 };

            //                 let jumlah = 1;
            //                 if (accessCabang == 'PUSAT') {
            //                     if (data.length > 1) {
            //                         data.shift()
            //                         jumlah = 2;
            //                     }
            //                 }
            //                 console.log(data);
                            
            //                 // return view('reports.laporankasbank', compact('data', 'dataCabang', 'detailParams', 'printer', 'cabang', 'datasaldo', 'infopemeriksa', 'jumlah'));
            //                 laporankasbank(data, datasaldo, infopemeriksa, dataCabang, cabang, detailParams, jumlah,
            //                     printer);
            //             },
            //             error: function(error) {
            //                 console.log(error);
                            
            //                 if (error.status === 422) {
            //                     $('.is-invalid').removeClass('is-invalid');
            //                     $('.invalid-feedback').remove();
            //                     $('#rangeTglModal').modal('hide')
            //                     setErrorMessages($('#crudForm'), error.responseJSON.errors);
            //                 } else {
            //                     showDialog(error.responseJSON.message);
            //                 }
            //             }
            //         })
            //         .always(() => {
            //             $('#processingLoader').addClass('d-none')
            //         });
            // }


    function initLookup() {
        $('.bank-lookup').lookupV4({
            title: 'Bank Lookup',
            fileName: 'bankV4',
            searching: ['namabank'],
            labelColumn: false,
            endpoint : 'bank',
            lookupName: 'bankLookup',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
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

        $(`.periodedata-lookup`).lookupMaster({
            title: 'PERIODE DATA Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'PERIODE DATA',
                    subgrp: 'PERIODE DATA',
                    searching: 1,
                    valueName: `periodedata_id`,
                    searchText: `periodedata-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'PERIODE DATA'
                };
            },
            onSelectRow: (status, element) => {
                $('#crudForm [name=periodedata_id]').first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let status_id_input = $('#crudForm [name=periodedata_id]').first();
                status_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });
    }


            function getCekReport() {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `${apiUrl}laporankasbank/report`,
                        dataType: "JSON",
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: $('#crudForm').find('[name=dari]').val(),
                            sampai: $('#crudForm').find('[name=sampai]').val(),
                            bank: $('#crudForm').find('[name=bank]').val(),
                            bank_id: $('#crudForm').find('[name=bank_id]').val(),
                            periodedata: $('#crudForm').find('[name=periodedata]').val(),
                            periodedata_id: $('#crudForm').find('[name=periodedata_id]').val(),
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
                        url: `${apiUrl}laporankasbank/export`,
                        dataType: "JSON",
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: $('#crudForm').find('[name=dari]').val(),
                            sampai: $('#crudForm').find('[name=sampai]').val(),
                            bank: $('#crudForm').find('[name=bank]').val(),
                            bank_id: $('#crudForm').find('[name=bank_id]').val(),
                            periodedata: $('#crudForm').find('[name=periodedata]').val(),
                            periodedata_id: $('#crudForm').find('[name=periodedata_id]').val(),
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

           

            function laporankasbank(data, datasaldo, infopemeriksa, dataCabang, cabang, detailParams, jumlah, printer) {
                Stimulsoft.Base.StiLicense.Key = "6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHksEid1Z5nN/hHQewjPL/4/AvyNDbkXgG4Am2U6dyA8Ksinqp" +
                "6agGqoHp+1KM7oJE6CKQoPaV4cFbxKeYmKyyqjF1F1hZPDg4RXFcnEaYAPj/QLdRHR5ScQUcgxpDkBVw8XpueaSFBs" +
                "JVQs/daqfpFiipF1qfM9mtX96dlxid+K/2bKp+e5f5hJ8s2CZvvZYXJAGoeRd6iZfota7blbsgoLTeY/sMtPR2yutv" +
                "gE9TafuTEhj0aszGipI9PgH+A/i5GfSPAQel9kPQaIQiLw4fNblFZTXvcrTUjxsx0oyGYhXslAAogi3PILS/DpymQQ" +
                "0XskLbikFsk1hxoN5w9X+tq8WR6+T9giI03Wiqey+h8LNz6K35P2NJQ3WLn71mqOEb9YEUoKDReTzMLCA1yJoKia6Y" +
                "JuDgUf1qamN7rRICPVd0wQpinqLYjPpgNPiVqrkGW0CQPZ2SE2tN4uFRIWw45/IITQl0v9ClCkO/gwUtwtuugegrqs" +
                "e0EZ5j2V4a1XDmVuJaS33pAVLoUgK0M8RG72"; 
                // Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
                // Stimulsoft.Base.StiFontCollection.addOpentypeFontFile(
                //     "{{ asset('libraries/stimulsoft-report/2024.3.6/font/tahoma.ttf') }}", "Tahoma");
               
                var report = new Stimulsoft.Report.StiReport();
                var dataSet = new Stimulsoft.System.Data.DataSet("Data");

                // console.log(cabang, printer)
                
                if (cabang == 'PUSAT') {
                    if (jumlah == 2) {
                        report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarPusat.mrt') }}`)
                    } else {
                        report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarPusatSaldo.mrt') }}`)
                    }
                } else {
                    if (printer == 'reportPrinterBesar') {
                        // console.log(cabang)
                        if (cabang == 'MEDAN') {
                            report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarA4TestBlob.mrt') }}`)
                        } else if (cabang == 'MAKASSAR') {
                            report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarLetter.mrt') }}`)
                        } else {
                            report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesar.mrt') }}`)
                        }
                    } else {
                        report.loadFile(`{{ asset('public/reports/ReportLaporanKasBank.mrt') }}`)
                    }
                }

                dataSet.readJson({
                    'data': data,
                    'datasaldo': datasaldo,
                    'infopemeriksa': infopemeriksa,
                    'dataCabang': dataCabang,
                    'parameter': detailParams
                });

                report.regData(dataSet.dataSetName, '', dataSet);
                report.dictionary.synchronize();
                
                console.log('masuk');
                
                // var options = new Stimulsoft.Designer.StiDesignerOptions()
                // options.appearance.fullScreenMode = true
                // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
                // designer.report = report;
                // designer.renderHtml('content');

               // PDF
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

               

              
                //WORD
                // report.renderAsync(function() {
                //     report.exportDocumentAsync(function(wordData) {
                //         let blob = new Blob([new Uint8Array(wordData)], {
                //             type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                //         });
                //         let fileURL = URL.createObjectURL(blob);
                //         let link = document.createElement('a');
                //         link.href = fileURL;
                //         link.download = 'Laporan.docx';
                //         link.click();
                //     }, Stimulsoft.Report.StiExportFormat.Word2007);
                // }, function(error) {
                //     console.error("Error rendering report: ", error);
                // });

            }
        </script>
    @endpush()
@endsection

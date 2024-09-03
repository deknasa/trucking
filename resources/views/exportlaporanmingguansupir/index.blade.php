@extends('layouts.master')

@section('content')
<style>
     .no-calendar .ui-datepicker-calendar {
            display: none;
        }
</style>
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
                                <label class="col-12 col-sm-2 col-form-label mt-2">bulan<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="bulan" class="form-control bulan">
                                    </div>
                                </div>
                            
                                <div class="col-sm-1 text-center mt-2" >
                                    <label class=" mt-2 ">MINGGU KE<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        {{-- <input type="hidden" name="tgldari">
                                        <input type="hidden" name="tglsampai"> --}}
                                        <input type="text" name="minggu" id="minggu" class="form-control minggu-lookup">
                                    </div>
                                </div>
                            </div>
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
                                <label class="col-12 col-sm-2 col-form-label mt-2">Trado</label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="tradodari_id">
                                        <input type="text" name="tradodari" id="tradodari" class="form-control tradodari-lookup">
                                    </div>
                                </div>
                                <div class="col-sm-1 mt-2">
                                    <h5 class="text-center mt-2">s/d</h5>
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="tradosampai_id">
                                        <input type="text" name="tradosampai" id="tradosampai" class="form-control tradosampai-lookup">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">JENIS LAPORAN</label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                    <select name="jenislaporan" id="jenislaporan" class="form-select select2bs4" style="width: 100%;">
                                    </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6 mt-4">
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
                initSelect2($('#crudForm').find('[name=jenislaporan]'), false)
                setJenisLaporanOptions($('#crudForm'))
                $('#crudForm').find('[name=bulan]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
                $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');
                $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
                    'change');

                if (!`{{ $myAuth->hasPermission('exportlaporanmingguansupir', 'export') }}`) {
                    $('#btnExport').attr('disabled', 'disabled')
                }

                $('.bulan').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    showOn: "button",
                    dateFormat: 'mm-yy',
                    onClose: function(dateText, inst) {
                        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                        $(inst.dpDiv).removeClass('no-calendar');
                    },
                    beforeShow: function(input, inst) {
                        // Tambahkan kelas khusus untuk menyembunyikan kalender
                        setTimeout(function() {
                            $(inst.dpDiv).addClass('no-calendar');
                        }, 0);
                    },
                    onChangeMonthYear : function (year, month, inst) { 
                        $('#minggu').val('')
                    } 
                }).siblings(".ui-datepicker-trigger")
                .wrap(
                    `
                    <div class="input-group-append">
                    </div>
                    `)
                .addClass("btn btn-easyui text-easyui-dark").html(`
                <i class="fa fa-calendar-alt"></i>
                `);

                $('#crudForm').find('[name=bulan]').on('change', function() {
                    $('#minggu').val('')
                })
            })

            $(document).on('click', `#btnExport`, function(event) {
                let dari = $('#crudForm').find('[name=dari]').val()
                let sampai = $('#crudForm').find('[name=sampai]').val()
                let tradodari_id = $('#crudForm').find('[name=tradodari_id]').val()
                let tradodari = $('#crudForm').find('[name=tradodari]').val()
                let tradosampai_id = $('#crudForm').find('[name=tradosampai_id]').val()
                let tradosampai = $('#crudForm').find('[name=tradosampai]').val()
                let jenislaporan = $('#crudForm').find('[name=jenislaporan]').val()

                // getCekExport().then((response) => {
                    
                    $('#processingLoader').removeClass('d-none')
                    
                    $.ajax({
                        url: `${apiUrl}exportlaporanmingguansupir/export`,
                        // url: `{{ route('exportlaporanmingguansupir.export') }}?dari=${dari}&sampai=${sampai}&tradodari=${tradodari}&tradodari_id=${tradodari_id}&tradosampai=${tradosampai}&tradosampai_id=${tradosampai_id}`,
                        type: 'GET',
                        data : {
                            dari : dari,
                            sampai : sampai,
                            tradodari_id : tradodari_id,
                            tradodari : tradodari,
                            tradosampai_id : tradosampai_id,
                            tradosampai : tradosampai,
                            jenislaporan : jenislaporan
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
                                    link.download = 'EXPORT RINCIAN MINGGUAN ' + new Date().getTime() + '.xlsx';
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
                // }).catch((error) => {
                //     if (error.status === 422) {
                //         $('.is-invalid').removeClass('is-invalid')
                //         $('.invalid-feedback').remove()

                //         setErrorMessages($('#crudForm'), error.responseJSON.errors);
                //     } else {
                //         showDialog(error.statusText, error.responseJSON.message)

                //     }
                // })

            })

            function getCekExport() {

                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `${apiUrl}exportlaporanmingguansupir/export`,
                        dataType: "JSON",
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: $('#crudForm').find('[name=dari]').val(),
                            sampai: $('#crudForm').find('[name=sampai]').val(),
                            tradodari: $('#crudForm').find('[name=tradodari]').val(),
                            tradodari_id: $('#crudForm').find('[name=tradodari_id]').val(),
                            tradosampai: $('#crudForm').find('[name=tradosampai]').val(),
                            tradosampai_id: $('#crudForm').find('[name=tradosampai_id]').val(),
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
                $('.tradodari-lookup').lookupMaster({
                    title: 'Trado Lookup',
                    fileName: 'tradoMaster',
                    typeSearch: 'ALL',
                    searching: 1,
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                            searching: 1,
                            valueName: 'tradodari_id',
                            searchText: 'tradodari-lookup',
                            title: 'trado dari',
                            typeSearch: 'ALL',
                        }
                    },  
                    onSelectRow: (trado, element) => {
                        $('#crudForm [name=tradodari_id]').first().val(trado.id)
                        element.val(trado.kodetrado)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        $('#crudForm [name=tradodari_id]').first().val('')
                        element.val('')
                        element.data('currentValue', element.val())
                    }
                })

                $('.tradosampai-lookup').lookupMaster({
                    title: 'Trado Lookup',
                    fileName: 'tradoMaster',
                    typeSearch: 'ALL',
                    searching: 1,
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                            searching: 1,
                            valueName: 'tradosampai_id',
                            searchText: 'tradosampai-lookup',
                            title: 'trado sampai',
                            typeSearch: 'ALL',
                        }
                    },  
                    onSelectRow: (trado, element) => {
                        $('#crudForm [name=tradosampai_id]').first().val(trado.id)
                        element.val(trado.kodetrado)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        $('#crudForm [name=tradosampai_id]').first().val('')
                        element.val('')
                        element.data('currentValue', element.val())
                    }
                })

                $('.minggu-lookup').lookupMaster({
                    title: 'Mingguan Lookup',
                    fileName: 'mingguanMaster',
                    typeSearch: 'ALL',
                    searching: 1,
                    beforeProcess: function(test) {
                        this.postData = {
                            Aktif: 'AKTIF',
                            bulan: $('#crudForm').find('[name=bulan]').val(),
                            searching: 1,
                            valueName: 'minggu',
                            searchText: 'minggu',
                            title: 'minggu',
                            typeSearch: 'ALL',
                        }
                    },  
                    onSelectRow: (minggu, element) => {
                        
                        $('#crudForm').find('[name=dari]').val(minggu.fTglDr).trigger('change');
                        $('#crudForm').find('[name=sampai]').val(minggu.fTglSd).trigger('change');
                        element.val(minggu.fKode)
                        element.data('currentValue', element.val())
                    },
                    onCancel: (element) => {
                        element.val(element.data('currentValue'))
                    },
                    onClear: (element) => {
                        // $('#crudForm [name=tgldari]').val('')
                        // $('#crudForm [name=tglsampai]').val('')
                        element.val('')
                        element.data('currentValue', element.val())
                    }
                })
            }
            
            const setJenisLaporanOptions = function(relatedForm) {
                return new Promise((resolve, reject) => {
                    relatedForm.find('[name=jenislaporan]').empty()
                    relatedForm.find('[name=jenislaporan]').append(
                        new Option('-- PILIH JENIS LAPORAN --', '', false, true)
                    ).trigger('change')
                    $.ajax({
                        url: `${apiUrl}parameter`,
                        method: 'GET',
                        dataType: 'JSON',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            filters: JSON.stringify({
                                "groupOp": "AND",
                                "rules": [{
                                    "field": "grp",
                                    "op": "cn",
                                    "data": "JENIS RINCIAN MINGGUAN"
                                }]
                            })
                        },
                        success: response => {
                            response.data.forEach(statusReuse => {
                                let option = new Option(statusReuse.text, statusReuse.id)
                                relatedForm.find('[name=jenislaporan]').append(option).trigger('change')
                                if (statusReuse.default == 'YA') {
                                    relatedForm.find('[name=jenislaporan]').val(statusReuse.id).trigger('change');
                                }
                            });
                            
                            resolve()
                        },
                        error: error => {
                            reject(error)
                        }
                    })
                })
            }    
        </script>
    @endpush()
@endsection

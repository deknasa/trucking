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
                        {{-- <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                            <label class="col-12 col-sm-2 col-form-label mt-2">Minggu ke<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="minggu" class="form-control datepicker">
                                </div>
                            </div>
                            
                        </div> --}}

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-10 mt-2">
                                <div class="input-group">
                                    <input type="text" name="dari" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">CUSTOMER (DARI)</label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="agendari_id">
                                <input type="text" id="agendari" name="agendari" class="form-control agendari-lookup">
                            </div>
                            <h5 class="col-sm-1 mt-3 text-center">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="agensampai_id">
                                <input type="text" id="agensampai" name="agensampai" class="form-control agensampai-lookup">
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
        setLaporanPiutangPerAgen($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        
        if (!`{{ $myAuth->hasPermission('laporankartupiutangperagen', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporankartupiutangperagen', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
        initLookup()
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let agendari_id = $('#crudForm').find('[name=agendari_id]').val()
        let agensampai_id = $('#crudForm').find('[name=agensampai_id]').val()
        let agendari = $('#crudForm').find('[name=agendari]').val()
        let agensampai = $('#crudForm').find('[name=agensampai]').val()

        getCekReport().then((response) => {
            window.open(`{{ route('laporankartupiutangperagen.report') }}?dari=${dari}&sampai=${sampai}&agendari_id=${agendari_id}&agensampai_id=${agensampai_id}&agendari=${agendari}&agensampai=${agensampai}`)
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
        let agendari_id = $('#crudForm').find('[name=agendari_id]').val()
        let agensampai_id = $('#crudForm').find('[name=agensampai_id]').val()
        let agendari = $('#crudForm').find('[name=agendari]').val()
        let agensampai = $('#crudForm').find('[name=agensampai]').val()

        $.ajax({
            url: `{{ route('laporankartupiutangperagen.export') }}?dari=${dari}&sampai=${sampai}&agendari_id=${agendari_id}&agensampai_id=${agensampai_id}&agendari=${agendari}&agensampai=${agensampai}`,
            type: 'GET',
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
                        link.download = 'LAPORAN KARTU PIUTANG PER CUSTOMER ' + new Date().getTime() + '.xlsx';
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

    function getCekReport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporankartupiutangperagen/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    agendari_id: $('#crudForm').find('[name=agendari_id]').val(),
                    agensampai_id: $('#crudForm').find('[name=agensampai_id]').val(),
                    agendari: $('#crudForm').find('[name=agendari]').val(),
                    agensampai: $('#crudForm').find('[name=agensampai]').val(),
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
                url: `${apiUrl}laporankartupiutangperagen/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    agendari_id: $('#crudForm').find('[name=agendari_id]').val(),
                    agensampai_id: $('#crudForm').find('[name=agensampai_id]').val(),
                    agendari: $('#crudForm').find('[name=agendari]').val(),
                    agensampai: $('#crudForm').find('[name=agensampai]').val(),
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

        $('.agendari-lookup').lookupMaster({
            title: 'Customer Lookup',
            fileName: 'agenMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'agendari_id',
                    searchText: 'agendari-lookup',
                    title: 'Customer Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (agen, element) => {
                $('#crudForm [name=agendari_id]').first().val(agen.id)
                element.val(agen.namaagen)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=agendari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.agensampai-lookup').lookupMaster({
            title: 'Customer Lookup',
            fileName: 'agenMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'agensampai_id',
                    searchText: 'agensampai-lookup',
                    title: 'Customer Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (agen, element) => {
                $('#crudForm [name=agensampai_id]').first().val(agen.id)
                element.val(agen.namaagen)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=agensampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    const setLaporanPiutangPerAgen = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=status]').append(
            new Option('-- PILIH STATUS KEMBALI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'LAPORAN PEMBELIAN'
        })
        data.push({
            name: 'subgrp',
            value: 'LAPORAN PEMBELIAN'
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

                response.data.forEach(laporanPembelian => {
                    let option = new Option(laporanPembelian.text, laporanPembelian.text)
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
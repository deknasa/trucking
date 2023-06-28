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
                            <label class="col-12 col-sm-2 col-form-label mt-2">stok (DARI)<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stokdari_id">
                                <input type="text" name="stokdari" class="form-control stokdari-lookup">
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stoksampai_id">
                                <input type="text" name="stoksampai" class="form-control stoksampai-lookup">
                            </div>
                        </div>
{{--                     
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">STATUS<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <select name="status" id="status" class="form-select select2bs4" style="width: 100%;">

                                </select>
                            </div>
                        </div> --}}
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </a>
                                <a id="btnExport" class="btn btn-warning mr-1 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </a>
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
        setLaporanPembelian($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        initLookup()
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stokdari_id= $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id= $('#crudForm').find('[name=stoksampai_id]').val()
        let stokdari= $('#crudForm').find('[name=stokdari]').val()
        let stoksampai= $('#crudForm').find('[name=stoksampai]').val()
        let status= $('#crudForm').find('[name=status]').val()

        
        if (dari != '' && sampai != '' && stokdari != '' && stoksampai != '') {
            window.open(`{{ route('laporanpembelianstok.report') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&stokdari=${stokdari}&stoksampai=${stoksampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }

    })

    $(document).on('click', `#btnExport`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stokdari_id= $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id= $('#crudForm').find('[name=stoksampai_id]').val()
        let stokdari= $('#crudForm').find('[name=stokdari]').val()
        let stoksampai= $('#crudForm').find('[name=stoksampai]').val()
        let status= $('#crudForm').find('[name=status]').val()

        if (dari != '' && sampai != '' && stokdari != '' && stoksampai != '') {
            window.open(`{{ route('laporanpembelianstok.export') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&stokdari=${stokdari}&stoksampai=${stoksampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }

            })

    function initLookup() {
        $('.stokdari-lookup').lookup({
            title: 'Stok Lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stokdari_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="stokdari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        });

        $('.stoksampai-lookup').lookup({
            title: 'stok Lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stoksampai_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="stoksampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }

    const setLaporanPembelian = function(relatedForm) {
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
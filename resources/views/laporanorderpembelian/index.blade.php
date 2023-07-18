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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Vendor<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="supplierdari_id">
                                    <input type="text" name="supplierdari" class="form-control supplierdari-lookup">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="suppliersampai_id">
                                    <input type="text" name="suppliersampai" class="form-control suppliersampai-lookup">
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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Parameter<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <select name="text" id="text" class="form-select select2bs4" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
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

        initSelect2($('#crudForm').find('[name=text]'), false)
        setTextParameterOptions($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        initLookup()
        
        
        if (!`{{ $myAuth->hasPermission('laporanorderpembelian', 'report') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let supplierdari_id = $('#crudForm').find('[name=supplierdari_id]').val()
        let suppliersampai_id = $('#crudForm').find('[name=suppliersampai_id]').val()
        let supplierdari = $('#crudForm').find('[name=supplierdari]').val()
        let suppliersampai = $('#crudForm').find('[name=suppliersampai]').val()
        let text_id = $('#crudForm').find('[name=text]').val()
        let text = $('#text').find('option:selected').text();

        if (dari != '' && sampai != '') {

            window.open(`{{ route('laporanorderpembelian.report') }}?sampai=${sampai}&dari=${dari}&supplierdari_id=${supplierdari_id}&suppliersampai_id=${suppliersampai_id}&supplierdari=${supplierdari}&suppliersampai=${suppliersampai}&text_id=${text_id}&text=${text}`)    
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {
        $('.supplierdari-lookup').lookup({
            title: 'Supplier Lookup',
            fileName: 'supplier',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=supplierdari_id]').first().val(supplier.namasupplier)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="supplierdari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.suppliersampai-lookup').lookup({
            title: 'Supplier Lookup',
            fileName: 'supplier',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=suppliersampai_id]').first().val(supplier.namasupplier)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="suppliersampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        }) 
    }

    const setTextParameterOptions = function(relatedForm) 
    {
        relatedForm.find('[name=text]').append(
            new Option('-- PILIH JENIS LAPORAN --', '', false, true)
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

                response.data.forEach(statusPosting => {
                    let option = new Option(statusPosting.text, statusPosting.id)
                    relatedForm.find('[name=text]').append(option).trigger('change')
                });

               
                relatedForm
                    .find('[name=text]')
                    .val($(`#crudForm [name=text] option:eq(1)`).val())
                    .trigger('change')
                    .trigger('select2:selected');
            }
        })
    }
</script>
@endpush()
@endsection
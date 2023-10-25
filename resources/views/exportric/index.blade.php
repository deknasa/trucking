@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6 row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">STATUS RIC<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-10 mt-2">
                                    <select name="statusric" id="statusric" class="form-select select2bs4" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 row">
                                <label class="col-12 col-sm-2 col-form-label">Dari<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="dari" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-6 row">
                                <label class="col-12 col-sm-2 col-form-label">Periode<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="periode" id="periode" class="form-control monthpicker">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <label class="col-12 col-sm-2 col-form-label">Sampai<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="sampai" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-6 row">
                                <label class="col-12 col-sm-2 col-form-label">Jenis<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-10">
                                    <div class="input-group">
                                        <input type="hidden" name="kelompok_id">
                                        <input type="text" name="kelompok" class="form-control kelompok-lookup">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <label class="col-12 col-sm-2 col-form-label">NO BK<span class="text-danger">*</span></label>
                                <div class="col-sm-10 col-md-10">
                                    <div class="input-group">
                                        <input type="hidden" name="trado_id">
                                        <input type="text" name="trado" class="form-control trado-lookup">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6">
                                <button type="button" id="btnExport" class="btn btn-warning mr-2 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
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
        initSelect2($('#crudForm').find('[name=statusric]'), false)
        setStatusRic($('#crudForm'))
        initDatepicker()
        initMonthpicker()
        initLookup()
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        ui - datepicker - div

        if (!`{{ $myAuth->hasPermission('exportric', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        let statusric = $('#crudForm').find('[name=statusric]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
        let trado_id = $('#crudForm').find('[name=trado_id]').val()

        if (periode != '' && statusric != '' && dari != '' && sampai != '' && kelompok_id != '' && trado_id != '') {
            window.open(`{{ route('exportric.export') }}?periode=${periode}&statusric=${statusric}&dari=${dari}&sampai=${sampai}&kelompok_id=${kelompok_id}&trado_id=${trado_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {

        $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.kelompok-lookup').lookup({
            title: 'Kelompok Lookup',
            fileName: 'kelompok',
            onSelectRow: (kelompok, element) => {
                $('#crudForm [name=kelompok_id]').first().val(kelompok.id)
                element.val(kelompok.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=kelompok_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
    const setStatusRic = function(relatedForm) {
        relatedForm.find('[name=statusric]').append(
            new Option('-- PILIH STATUS RIC --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'STATUS EXPORT RIC'
        })
        data.push({
            name: 'subgrp',
            value: 'STATUS EXPORT RIC'
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

                response.data.forEach(statusric => {
                    let option = new Option(statusric.text, statusric.id)
                    relatedForm.find('[name=statusric]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=statusric]')
                //     .val($(`#crudForm [name=jenis] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');
            }
        })
    }
</script>
@endpush()
@endsection
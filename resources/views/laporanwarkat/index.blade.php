@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Warkat<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <select name="text" id="text" class="form-select select2bs4" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-secondary mr-2 ">
                                    <i class="fas fa-sync"></i>
                                    Cetak
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

        initSelect2($('#crudForm').find('[name=text]'), false)
        setTextParameterOptions($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        
        let css_property =
        {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor" : "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('laporanwarkat', 'report') }}`) {
            $('#btnEkspor').prop('disabled', true)
            $('#btnEkspor').css(css_property);
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()

        if (dari != '' && sampai != '') {

            window.open(`{{ route('laporanwarkat.report') }}?sampai=${sampai}&dari=${dari}`)    
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    const setTextParameterOptions = function(relatedForm) 
    {
        relatedForm.find('[name=text]').append(
            new Option('-- PILIH JENIS WARKAT --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'LAPORAN PIUTANG GIRO'
        })
        data.push({
            name: 'subgrp',
            value: 'LAPORAN PIUTANG GIRO'
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
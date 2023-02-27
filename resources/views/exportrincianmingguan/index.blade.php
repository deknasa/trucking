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
                    <!-- <div class="card-body"> -->
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Rincian Mingguan</a></li>
                            <li><a href="#tabs-2">Rincian Beda Mandor Beda Supir</a></li>
                            <li><a href="#tabs-3">Job trado luar banding omset trucking</a></li>
                        </ul>
                        <div id="tabs-1">

                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="periode" class="form-control periode">
                                    </div>
                                </div>
                                <div class="mt-3">Minggu ke</div>
                                <div class="col-sm-4 mt-2">
                                    <select name="minggu" id="minggu" class="form-select select2bs4" style="width: 100%;">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Dari Tanggal<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="dari" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="mt-3">s/d</div>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="sampai" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Supir<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <input type="hidden" name="supirdari_id">
                                    <input type="text" name="supirdari" class="form-control supirdari-lookup">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Sampai<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <input type="hidden" name="supirsampai_id">
                                    <input type="text" name="supirsampai" class="form-control supirsampai-lookup">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-6 mt-4">
                                    <a id="btnEkspor" class="btn btn-secondary text-white mr-2 ">
                                        <i class="fas fa-sync"></i>
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="tabs-2">
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="periode2" class="form-control periode2">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-6 mt-4">
                                    <a id="btnEkspor2" class="btn btn-secondary text-white mr-2 ">
                                        <i class="fas fa-sync"></i>
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="tabs-3">

                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">JENIS <span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <select name="jenis" id="jenis" class="form-select select2bs4" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Dari Tanggal<span class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="dari3" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="mt-3">s/d</div>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="sampai3" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-6 mt-4">
                                    <a id="btnEkspor3" class="btn btn-secondary text-white mr-2 ">
                                        <i class="fas fa-sync"></i>
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- </div> -->
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
        initLookup();
        $("#tabs").tabs();

        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=periode2]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
        initDatepicker();
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=dari3]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai3]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        let defaultDate = new Date();

        initSelect2($('#crudForm').find('[name=minggu]'), false)

        initSelect2($('#crudForm').find('[name=jenis]'), false)
        setJenisOrderan($('#crudForm'))

        $('.periode').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: "button",
                dateFormat: 'mm-yy',
                defaultDate: defaultDate,
                onClose: function(dateText, inst) {

                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));

                    setWeeks(inst, 'onclose')
                },
                onSelect: function(dateText, inst) {

                    setWeeks(inst, 'onselect')

                },
            }).siblings(".ui-datepicker-trigger")
            .wrap(
                `
                <div class="input-group-append">
                </div>
		        `
            )
            .addClass("btn btn-primary").html(`
			    <i class="fa fa-calendar-alt"></i>
		    `).datepicker('setDate', defaultDate);

        $('.periode2').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: "button",
                dateFormat: 'mm-yy',
                defaultDate: defaultDate,
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                },
            }).siblings(".ui-datepicker-trigger")
            .wrap(
                `
                <div class="input-group-append">
                </div>
		        `
            )
            .addClass("btn btn-primary").html(`
			    <i class="fa fa-calendar-alt"></i>
		    `);


        let elem = $('.periode');
        $('.periode').datepicker('getDate')
        let inst = $.datepicker._getInst(elem[0]);
        setWeeks(inst, 'ready')

        let css_property = {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor": "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('exportrincianmingguan', 'export') }}`) {
            $('#btnEkspor').prop('disabled', true)
            $('#btnEkspor').css(css_property);
            $('#btnEkspor2').prop('disabled', true)
            $('#btnEkspor2').css(css_property);
            $('#btnEkspor3').prop('disabled', true)
            $('#btnEkspor3').css(css_property);
        }

    })

    $(document).on('click', `#btnEkspor`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        let minggu = $('#crudForm').find('[name=minggu]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let supirdari_id = $('#crudForm').find('[name=supirdari_id]').val()
        let supirsampai_id = $('#crudForm').find('[name=supirsampai_id]').val()

        if (minggu != '' && dari != '' && sampai != '' && supirdari_id != '' && supirsampai_id != '') {

            window.open(`{{ route('exportrincianmingguan.export') }}?periode=${periode}&minggu=${minggu}&dari=${dari}&sampai=${sampai}&supirdari_id=${supirdari_id}&supirsampai_id=${supirsampai_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


    $(document).on('click', `#btnEkspor2`, function(event) {
        let periode = $('#crudForm').find('[name=periode2]').val()

        if (periode != '') {

            window.open(`{{ route('exportrincianmingguan.export') }}?periode=${periode}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    

    $(document).on('click', `#btnEkspor3`, function(event) {
        let dari = $('#crudForm').find('[name=dari3]').val()
        let sampai = $('#crudForm').find('[name=sampai3]').val()

        if (dari != '' && sampai != '') {

            window.open(`{{ route('exportrincianmingguan.export') }}?dari=${dari}&sampai=${sampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function setWeeks(inst, moment) {

        $('#crudForm').find('[name=minggu]').empty()
        $('#crudForm').find('[name=minggu]').append(
            new Option('-- PILIH MINGGU --', '', false, true)
        ).trigger('change')

        var firstOfMonth = new Date(inst.selectedYear, inst.selectedMonth, 1);
        var lastOfMonth = new Date(inst.selectedYear, inst.selectedMonth + 1, 0);

        var firstDay = firstOfMonth.getDay();
        if (firstDay == 7)
            firstDay = 1;
        else
            firstDay += 1;
        var used = firstOfMonth.getDay() % 7 + 1 + lastOfMonth.getDate();
        weeks = Math.ceil(used / 7);
        for (x = 1; x <= weeks; x++) {
            let option = new Option(x, x)
            $('#crudForm').find('[name=minggu]').append(option).trigger('change')
        }
    }

    const setJenisOrderan = function(relatedForm) {
        relatedForm.find('[name=jenis]').append(
            new Option('-- PILIH JENIS ORDERAN --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'JENIS ORDERAN'
        })
        data.push({
            name: 'subgrp',
            value: 'JENIS ORDERAN'
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

                response.data.forEach(statusApproval => {
                    let option = new Option(statusApproval.text, statusApproval.id)
                    relatedForm.find('[name=jenis]').append(option).trigger('change')
                });

                relatedForm
                    .find('[name=jenis]')
                    .val($(`#crudForm [name=jenis] option:eq(1)`).val())
                    .trigger('change')
                    .trigger('select2:selected');
            }
        })
    }

    function initLookup() {

        $('.supirdari-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',

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
                $('#crudForm [name=supirdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.supirsampai-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',

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
                $('#crudForm [name=supirsampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
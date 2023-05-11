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
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Posisi Akhir Ban Trado<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="posisiakhirtrado_id" id="tradoId">
                                    <input type="text"  name="posisiakhirtrado" class="form-control posisiakhirtrado-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Posisi Akhir Ban Gandengan<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="posisiakhirgandengan_id" id="gandenganId">
                                    <input type="text" id="gandenganId" name="posisiakhirgandengan" class="form-control posisiakhirgandengan-lookup">
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
        initLookup()
        
        let css_property =
        {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor" : "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('laporanorderpembelian', 'report') }}`) {
            $('#btnEkspor').prop('disabled', true)
            $('#btnEkspor').css(css_property);
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let posisiakhirtrado= $('#crudForm').find('[name=posisiakhirtrado]').val()
        let posisiakhirtradoId= $('#crudForm').find('[name=posisiakhirtrado_id]').val()
        let posisiakhirgandengan = $('#crudForm').find('[name=posisiakhirgandengan]').val()
        let posisiakhirgandenganId = $('#crudForm').find('[name=posisiakhirgandengan_id]').val()
        let posisiakhirgandengantext = $('#crudForm').find('[name=posisiakhirgandengan]').val()
        let jenislaporan_id = $('#crudForm').find('[name=text]').val()
        let jenislaporan = $('#text').find('option:selected').text();

        if (dari != '' && sampai != '' && jenislaporan_id != '' && jenislaporan != ''&&(posisiakhirtrado != '' ||posisiakhirgandengan != '')) {

            window.open(`{{ route('laporanpemakaianban.report') }}?sampai=${sampai}&dari=${dari}&posisiakhirtrado_id=${posisiakhirtradoId}&posisiakhirtrado=${posisiakhirtrado}&posisiakhirgandengan_id=${posisiakhirgandenganId}&posisiakhirgandengan=${posisiakhirgandengan}&jenislaporan_id=${jenislaporan_id}&jenislaporan=${jenislaporan}`)    
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    

    function lookupSelected(el) {

    let trado = $('#crudForm').find(`[name="posisiakhirtrado"]`).parents('.input-group').children()

    let gandengan = $('#crudForm').find(`[name="posisiakhirgandengan"]`).parents('.input-group').children()


    switch (el) {
    case 'trado':
        gandengan.attr('disabled', true)
        gandengan.find('.lookup-toggler').attr('disabled', true)
        $('#gandenganId').attr('disabled', true);

        break;
    case 'gandengan':
        trado.attr('disabled', true)
        trado.find('.lookup-toggler').attr('disabled', true)
        $('#tradoId').attr('disabled', true);

        break;
    default:
        break;
    }

  }

  function enabledLookupSelected() {
        let trado = $('#crudForm').find(`[name="posisiakhirtrado"]`).parents('.input-group').children()
        let gandengan = $('#crudForm').find(`[name="posisiakhirgandengan"]`).parents('.input-group').children()
        trado.find(`.lookup-toggler`).attr("disabled", false);
        trado.attr('disabled', false);
        gandengan.find(`.lookup-toggler`).attr("disabled", false);
        gandengan.attr('disabled', false);


        $('#tradoId').attr('disabled', false);
        $('#tradoId').val('');

        $('#gudangId').attr('disabled', false);
        $('#gudangId').val('');
    }

    function initLookup() {
        $('.posisiakhirtrado-lookup').lookup({
            title: 'Posisi Akhir Ban Trado Lookup',
            fileName: 'trado',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=posisiakhirtrado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
                lookupSelected('trado');
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="posisiakhirtrado_id"]`).first().val('')
                element.data('currentValue', element.val())
                enabledLookupSelected()
            }
        })
        $('.posisiakhirgandengan-lookup').lookup({
            title: 'Posisi Akhir Ban Gandengan Lookup',
            fileName: 'gandengan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=posisiakhirgandengan_id]').first().val(gandengan.id)
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
                lookupSelected('gandengan');
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="posisiakhirgandengan_id"]`).first().val('')
                element.data('currentValue', element.val())
                enabledLookupSelected()
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
            value: 'LAPORAN PEMAKAIAN BAN'
        })
        data.push({
            name: 'subgrp',
            value: 'LAPORAN PEMAKAIAN BAN'
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
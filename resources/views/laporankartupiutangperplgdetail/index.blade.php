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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Pelanggan<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="pelanggandari_id">
                                    <input type="text" name="pelanggandari" class="form-control pelanggandari-lookup">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="pelanggansampai_id">
                                    <input type="text" name="pelanggansampai" class="form-control pelanggansampai-lookup">
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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Jenis<span class="text-danger">*</span></label>
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
        
        
        if (!`{{ $myAuth->hasPermission('laporankartupiutangperplgdetail', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let pelanggandari_id = $('#crudForm').find('[name=pelanggandari_id]').val()
        let pelanggansampai_id = $('#crudForm').find('[name=pelanggansampai_id]').val()
        let pelanggandari = $('#crudForm').find('[name=pelanggandari]').val()
        let pelanggansampai = $('#crudForm').find('[name=pelanggansampai]').val()

        if (dari != '' && sampai != '') {

            window.open(`{{ route('laporankartupiutangperplgdetail.report') }}?sampai=${sampai}&dari=${dari}&pelanggandari_id=${pelanggandari_id}&pelanggansampai_id=${pelanggansampai_id}&pelanggandari=${pelanggandari}&pelanggansampai=${pelanggansampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {
        $('.pelanggandari-lookup').lookup({
            title: 'Pelanggan Lookup',
            fileName: 'pelanggan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (pelanggan, element) => {
                $('#crudForm [name=pelanggandari_id]').first().val(pelanggan.kodepelanggan)
                element.val(pelanggan.namapelanggan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="pelanggandari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.pelanggansampai-lookup').lookup({
            title: 'Pelanggan Lookup',
            fileName: 'pelanggan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (pelanggan, element) => {
                $('#crudForm [name=pelanggansampai_id]').first().val(pelanggan.kodepelanggan)
                element.val(pelanggan.namapelanggan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="pelanggansampai_id"]`).first().val('')
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
            value: 'LAPORAN KARTU PIUTANG PER PELANGGAN'
        })
        data.push({
            name: 'subgrp',
            value: 'LAPORAN KARTU PIUTANG PER PELANGGAN'
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
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
                            <label class="col-12 col-sm-2 col-form-label mt-2">SUPIR (DARI)<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="supirdari_id">
                                <input type="text" name="supirdari" class="form-control supirdari-lookup">
                            </div>
                        </div>
                        
                      
                      
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
        setStatusKembali($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=ricdari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ricsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        initLookup()
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let supirdari_id= $('#crudForm').find('[name=supirdari_id]').val()
        let supirdari= $('#crudForm').find('[name=supirdari]').val()
        let supirsampai= $('#crudForm').find('[name=supirsampai_id]').val()
        if (supirdari_id != '') {

            window.open(`{{ route('laporanhistorydeposito.report') }}?&supirdari_id=${supirdari_id}&supirdari=${supirdari}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let supirdari_id= $('#crudForm').find('[name=supirdari_id]').val()
        let supirdari= $('#crudForm').find('[name=supirdari]').val()
        let supirsampai= $('#crudForm').find('[name=supirsampai_id]').val()
        if (supirdari_id != '') {

            window.open(`{{ route('laporanhistorydeposito.export') }}?&supirdari_id=${supirdari_id}&supirdari=${supirdari}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
            })

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
                element.val('')
                $(`#crudForm [name="supirdari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        });

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
                element.val('')
                $(`#crudForm [name="supirsampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }

    const setStatusKembali = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=status]').append(
            new Option('-- PILIH STATUS KEMBALI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'STATUS KEMBALI'
        })
        data.push({
            name: 'subgrp',
            value: 'STATUS KEMBALI'
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

                response.data.forEach(statusKembali => {
                    let option = new Option(statusKembali.text, statusKembali.id)
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
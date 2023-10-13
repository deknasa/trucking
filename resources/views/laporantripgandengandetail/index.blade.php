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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Gandengan<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="gandengandari_id">
                                    <input type="text" name="gandengandari" class="form-control gandengandari-lookup">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="gandengansampai_id">
                                    <input type="text" name="gandengansampai" class="form-control gandengansampai-lookup">
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
        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        initLookup()
        
        if (!`{{ $myAuth->hasPermission('laporantripgandengandetail', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporantripgandengandetail', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let gandengandari_id = $('#crudForm').find('[name=gandengandari_id]').val()
        let gandengansampai_id = $('#crudForm').find('[name=gandengansampai_id]').val()
        let gandengandari = $('#crudForm').find('[name=gandengandari]').val()
        let gandengansampai = $('#crudForm').find('[name=gandengansampai]').val()

        if (dari != '' && sampai != '') {

            window.open(`{{ route('laporantripgandengandetail.report') }}?sampai=${sampai}&dari=${dari}&gandengandari_id=${gandengandari_id}&gandengansampai_id=${gandengansampai_id}&gandengandari=${gandengandari}&gandengansampai=${gandengansampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })
    
    $(document).on('click', `#btnExport`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let gandengandari_id = $('#crudForm').find('[name=gandengandari_id]').val()
        let gandengansampai_id = $('#crudForm').find('[name=gandengansampai_id]').val()
        let gandengandari = $('#crudForm').find('[name=gandengandari]').val()
        let gandengansampai = $('#crudForm').find('[name=gandengansampai]').val()


        if (dari != '' && sampai != '') {

            window.open(`{{ route('laporantripgandengandetail.export') }}?sampai=${sampai}&dari=${dari}&gandengandari_id=${gandengandari_id}&gandengansampai_id=${gandengansampai_id}&gandengandari=${gandengandari}&gandengansampai=${gandengansampai}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


    function initLookup() {
        $('.gandengandari-lookup').lookup({
            title: 'Gandengan Lookup',
            fileName: 'gandengan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengandari_id]').first().val(gandengan.id)
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="gandengandari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
        $('.gandengansampai-lookup').lookup({
            title: 'Gandengan Lookup',
            fileName: 'gandengan',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengansampai_id]').first().val(gandengan.id)
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="gandengansampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }


</script>
@endpush()
@endsection
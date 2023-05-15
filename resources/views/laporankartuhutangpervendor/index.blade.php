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
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Vendor<span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="suppdari_id">
                                <input type="text" name="suppdari" class="form-control suppdari-lookup">
                            </div>
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="suppsampai_id">
                                <input type="text" name="suppsampai" class="form-control suppsampai-lookup">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-secondary mr-2 ">
                                    <i class="fas fa-sync"></i>
                                    Cetak
                                </a>
                                <!-- <a id="btnExport" class="btn btn-warning mr-2 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </a> -->
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
        initLookup()
        initDatepicker()

        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let suppdari_id = $('#crudForm').find('[name=suppdari_id]').val()
        let suppsampai_id = $('#crudForm').find('[name=suppsampai_id]').val()

        if (dari != '' && sampai != '' && suppdari_id != '' && suppsampai_id != '') {

            window.open(`{{ route('laporankartuhutangpervendor.report') }}?dari=${dari}&sampai=${sampai}&suppdari_id=${suppdari_id}&suppsampai_id=${suppsampai_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let suppdari_id = $('#crudForm').find('[name=suppdari_id]').val()
        let suppsampai_id = $('#crudForm').find('[name=suppsampai_id]').val()

        if (dari != '' && sampai != '' && suppdari_id != '' && suppsampai_id != '') {

            window.open(`{{ route('laporanbukubesar.export') }}?dari=${dari}&sampai=${sampai}&suppdari_id=${suppdari_id}&suppsampai_id=${suppsampai_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })



    function initLookup() {

        $('.suppdari-lookup').lookup({
            title: 'supplier dari lookup',
            fileName: 'supplier',
            beforeProcess: function(test) {
                this.postData = {
                    // levelsupplier: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=suppdari_id]').first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=suppdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.suppsampai-lookup').lookup({
            title: 'LAPORAN KARTU HUTANG PER VENDOR',
            fileName: 'supplier',
            beforeProcess: function(test) {
                this.postData = {
                    levelsupplier: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=suppsampai_id]').first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=suppsampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Stok<span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stokdari_id">
                                <input type="text" name="stokdari" class="form-control stokdari-lookup">
                            </div>
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stoksampai_id">
                                <input type="text" name="stoksampai" class="form-control stoksampai-lookup">
                            </div>
                        </div>

                        <div class="row" id="kategori">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kategori<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="kategori_id">
                                    <input type="text" name="kategori" class="form-control kategori-lookup">
                                </div>
                            </div>
                        </div>

                        
                        <div class="row" id="gudang">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Gudang<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="gudang_id">
                                    <input type="text" name="gudang" class="form-control gudang-lookup">
                                </div>
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
    // let sortname = 'nobukti'
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
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let kategori_id = $('#crudForm').find('[name=kategori_id]').val()
        let gudang_id = $('#crudForm').find('[name=gudang_id]').val()
        if (dari != '' && sampai != '' && stokdari_id != '' && stoksampai_id != '' && kategori_id != '' & gudang_id != '') {

            window.open(`{{ route('laporankartustok.report') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&kategori_id=${kategori_id}&gudang_id=${gudang_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


    $(document).on('click', `#btnExport`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
         let kategori_id = $('#crudForm').find('[name=kategori_id]').val()
         let gudang_id = $('#crudForm').find('[name=gudang_id]').val()
        if (dari != '' && sampai != '' && stokdari_id != '' && stoksampai_id != '' && kategori_id != '' && gudang_id != '') {

            window.open(`{{ route('laporanbukubesar.export') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&kategori_id=${kategori_id}&gudang_id=${gudang_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })



    function initLookup() {

        $('.stokdari-lookup').lookup({
            title: 'stok dari lookup',
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
                $('#crudForm [name=stokdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.stoksampai-lookup').lookup({
            title: 'stok sampai dari lookup',
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
                $('#crudForm [name=stoksampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.kategori-lookup').lookup({
            title: 'kategori dari lookup',
            fileName: 'kategori',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kategori, element) => {
                $('#crudForm [name=kategori_id]').first().val(kategori.id)
                element.val(kategori.kodekategori)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=kategori_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.gudang-lookup').lookup({
            title: 'gudang dari lookup',
            fileName: 'gudang',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (gudang, element) => {
                $('#crudForm [name=gudang_id]').first().val(gudang.id)
                element.val(gudang.gudang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gudang_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Dari tanggal<span class="text-danger">*</span></label>
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
                                <a id="btnEkspor" class="btn btn-secondary mr-2 ">
                                    <i class="fas fa-sync"></i>
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
        initLookup();
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
        initDatepicker();

        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        
        let css_property =
        {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor" : "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('exportrincianmingguanpendapatan', 'export') }}`) {
            $('#btnEkspor').prop('disabled', true)
            $('#btnEkspor').css(css_property);
        }
    })

    $(document).on('click', `#btnEkspor`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let supirdari_id = $('#crudForm').find('[name=supirdari_id]').val()
        let supirsampai_id = $('#crudForm').find('[name=supirsampai_id]').val()

        if (dari != '' && sampai != '' && supirdari_id != '' && supirsampai_id != '') {

            window.open(`{{ route('exportrincianmingguanpendapatan.export') }}?dari=${dari}&sampai=${sampai}&supirdari_id=${supirdari_id}&supirsampai_id=${supirsampai_id}`)
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
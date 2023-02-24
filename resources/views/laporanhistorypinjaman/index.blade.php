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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Supir<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="supirdari_id" >
                                    <input type="text" name="supirdari" class="form-control supirdari-lookup">
                                </div>
                            </div> 
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="supirsampai_id" >
                                    <input type="text" name="supirsampai" class="form-control supirsampai-lookup">
                                </div>
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
        initLookup()
        let css_property =
        {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor" : "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('laporanhistorypinjaman', 'export') }}`) {
            $('#btnEkspor').prop('disabled', true)
            $('#btnEkspor').css(css_property);
        }
    })

    $(document).on('click', `#btnEkspor`, function(event) {
        let supirdari_id = $('#crudForm').find('[name=supirdari_id]').val()

        if (supirdari_id != '') {

            window.open(`{{ route('laporanhistorypinjaman.export') }}?supirdari_id=${supirdari_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup(){
        
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
                element.val('')
                $(`#crudForm [name="supirsampai_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })
    }

</script>
@endpush()
@endsection
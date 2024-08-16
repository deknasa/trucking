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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row" id="supplier">
                                    <label class="col-12 col-sm-3 col-form-label mt-2">supplier<span class="text-danger">*</span></label>
                                    <div class="col-sm-9 mt-2">
                                        <div class="input-group">
                                            <input type="hidden" name="supplier_id">
                                            <input type="text" name="supplier" class="form-control supplier-lookup">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class=" row">
                            <div class="col-md-6 mt-4">
                                <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </button>
                                {{-- <button type="button" id="btnExport" class="btn btn-warning mr-2 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </button> --}}

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let indexRow = 0;
    let id = "";
    let triggerClick = true;
    let pager = '#jqGridPager'
    $(document).ready(function() {
        initLookup()
      

    })

    $(document).on('click', `#btnPreview`, function(event) {

        let supplier = $('#crudForm').find('[name=supplier]').val()
        let supplier_id = $('#crudForm').find('[name=supplier_id]').val()
        if (
            // (kelompok_id != '') &&
            // (statusreuse != '') &&
            // (statusban != '') &&
            // (filter != '') &&
            (supplier != '') &&
            (supplier_id != '')
            // (stokdari_id != '') &&
            // (stoksampai_id != '') &&
            // (dataFilter != '')
        ) {
            window.open(`{{ route('laporansupplierbandingstok.report') }}?supplier=${supplier}&supplier_id=${supplier_id}`)

        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


    $(document).on('click', `#btnExport`, function(event) {
        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
        let kelompok = $('#crudForm').find('[name=kelompok]').val()
        let statusreuse = $('#crudForm').find('[name=statusreuse]').val()
        let statusban = $('#crudForm').find('[name=statusban]').val()
        let filter = $('#crudForm').find('[name=filter]').val()
        let jenistgltampil = $('#crudForm').find('[name=jenistgltampil]').val()
        let gudang_id = $('#crudForm').find('[name=gudang_id]').val()
        let trado_id = $('#crudForm').find('[name=trado_id]').val()
        let gandengan_id = $('#crudForm').find('[name=gandengan_id]').val()
        let priode = $('#crudForm').find('[name=priode]').val()
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let dataFilter = ''
        if (filter == '186') {
            dataFilter = gudang_id
        }
        if (filter == '187') {
            dataFilter = trado_id
        }
        if (filter == '188') {
            dataFilter = gandengan_id
        }

        if (
            //(kelompok_id != '') &&
            // (statusreuse != '') &&
            // (statusban != '') &&
            // (filter != '') &&
            // (jenistgltampil != '') &&
            (priode != '')
            // (stokdari_id != '') &&
            // (stoksampai_id != '') &&
            // (dataFilter != '')
        ) {
            window.open(`{{ route('laporansaldoinventory.export') }}?kelompok_id=${kelompok_id}&kelompok=${kelompok}&statusreuse=${statusreuse}&statusban=${statusban}&filter=${filter}&jenistgltampil=${jenistgltampil}&priode=${priode}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&dataFilter=${dataFilter}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function initLookup() {

        $('.supplier-lookup').lookup({
            title: 'supplier Lookup',
            fileName: 'supplier',
            beforeProcess: function(test) {
              this.postData = {
                Aktif: 'AKTIF',
              }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=supplier_id]').first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supplier_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
       
    }

</script>
@endpush()
@endsection
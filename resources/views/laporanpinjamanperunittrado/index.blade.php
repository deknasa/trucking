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
                            <label class="col-12 col-sm-2 col-form-label mt-2">TRADO<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="trado_id">
                                    <input type="text" name="trado" class="form-control trado-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </a>
                                <a id="btnEkspor" class="btn btn-warning mr-1 ">
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
        initLookup()
        let css_property = {
            "color": "#fff",
            "background-color": "rgb(173 180 187)",
            "cursor": "not-allowed",
            "border-color": "rgb(173 180 187)"
        }
        if (!`{{ $myAuth->hasPermission('laporanpinjamanperunittrado', 'report') }}`) {
            $('#btnPreview').prop('disabled', true)
            $('#btnPreview').css(css_property);
        }
        if (!`{{ $myAuth->hasPermission('laporanpinjamanperunittrado', 'export') }}`) {
            $('#btnEkspor').prop('disabled', true)
            $('#btnEkspor').css(css_property);
        }
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let trado_id = $('#crudForm').find('[name=trado_id]').val()
        let trado = $('#crudForm').find('[name=trado]').val()

        getCekReport().then((response) => {
            
            window.open(`{{ route('laporanpinjamanperunittrado.report') }}?trado=${trado}&trado_id=${trado_id}`)
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.responseJSON)

            }
        })

    })

    $(document).on('click', `#btnEkspor`, function(event) {
        let trado_id = $('#crudForm').find('[name=trado_id]').val()
        let trado = $('#crudForm').find('[name=trado]').val()
        
        getCekExport().then((response) => {
            if(response.data.length == 0){
                showDialog("Tidak ada data")
            }else{
                window.open(`{{ route('laporanpinjamanperunittrado.export') }}?trado=${trado}&trado_id=${trado_id}`)
            }
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.responseJSON)

            }
        })

    })

    function getCekReport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanpinjamanperunittrado/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    trado: $('#crudForm').find('[name=trado]').val(),
                    trado_id: $('#crudForm').find('[name=trado_id]').val(),
                    isCheck: true,
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)

                },
            });
        });
    }

    function getCekExport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanpinjamanperunittrado/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    trado: $('#crudForm').find('[name=trado]').val(),
                    trado_id: $('#crudForm').find('[name=trado_id]').val(),
                    isCheck: true,
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)

                },
            });
        });
    }

    function initLookup() {

        $('.trado-lookup').lookup({
            title: 'Bank Lookup',
            fileName: 'trado',
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
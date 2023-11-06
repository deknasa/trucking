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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Tanggal<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tgldari" id="tgldari" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-sm-1 mt-2 text-center">
                                <label class="mt-2">s/d</label>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tglsampai" id="tglsampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">jenis order </label>
                            <div class="col-sm-4 mt-2">
                                <select name="jenisorder" id="jenisorder" class="form-select select2" style="width: 100%;">
                                    {{-- <option value=""> </option> --}}
                                    @foreach ($combojenisorder as $jenisorder)
                                    <option value="{{$jenisorder['id']}}"> {{$jenisorder['keterangan']}} </option>
                                    @endforeach
                                </select>
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
        initSelect2($(`#jenisorder`), false)

        initDatepicker()
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
            $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
            $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');

        if (!`{{ $myAuth->hasPermission('laporantitipanemkl', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('laporantitipanemkl', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let jenisorder = $('#crudForm').find('[name=jenisorder]').val()
        let tgldari = $('#crudForm').find('[name=tgldari]').val()
        let tglsampai = $('#crudForm').find('[name=tglsampai]').val()
        let periode = $('#crudForm').find('[name=periode]').val()

        getCekReport().then((response) => {
            window.open(`{{ route('laporantitipanemkl.report') }}?jenisorder=${jenisorder}&tgldari=${tgldari}&tglsampai=${tglsampai}&periode=${periode}`)
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()
                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.statusText, error.responseJSON.message)

            }
        })
    })

    $(document).on('click', `#btnExport`, function(event) {
        let jenisorder = $('#crudForm').find('[name=jenisorder]').val()
        let tgldari = $('#crudForm').find('[name=tgldari]').val()
        let tglsampai = $('#crudForm').find('[name=tglsampai]').val()
        let periode = $('#crudForm').find('[name=periode]').val()

        getCekExport().then((response) => {
            // window.open(
                window.open(`{{ route('laporantitipanemkl.export') }}?jenisorder=${jenisorder}&tgldari=${tgldari}&tglsampai=${tglsampai}&periode=${periode}`)
            // )
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()
                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.statusText, error.responseJSON.message)

            }
        })

    })

    function getCekReport() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporantitipanemkl/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    jenisorder: $('#crudForm').find('[name=jenisorder]').val(),
                    tgldari: $('#crudForm').find('[name=periode]').val(),
                    tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                    periode: $('#crudForm').find('[name=periode]').val(),
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
                url: `${apiUrl}laporantitipanemkl/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    jenisorder: $('#crudForm').find('[name=jenisorder]').val(),
                    tgldari: $('#crudForm').find('[name=tgldari]').val(),
                    tglsampai: $('#crudForm').find('[name=tglsampai]').val(),
                    periode: $('#crudForm').find('[name=periode]').val(),
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
</script>
@endpush()
@endsection
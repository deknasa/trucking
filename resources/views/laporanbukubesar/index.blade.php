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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kd. Perkiraan<span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="coadari_id">
                                <input type="text" name="coadari" class="form-control coadari-lookup">
                            </div>
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="coasampai_id">
                                <input type="text" name="coasampai" class="form-control coasampai-lookup">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
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
        initDatepicker()

        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let coadari_id = $('#crudForm').find('[name=coadari_id]').val()
        let coasampai_id = $('#crudForm').find('[name=coasampai_id]').val()
        let coadari = $('#crudForm').find('[name=coadari]').val()
        let coasampai = $('#crudForm').find('[name=coasampai]').val()
        getCekReport().then((response) => {
            window.open(`{{ route('laporanbukubesar.report') }}?dari=${dari}&sampai=${sampai}&coadari=${coadari}&coasampai=${coasampai}&coadari_id=${coadari_id}&coasampai_id=${coasampai_id}`)
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
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let coadari_id = $('#crudForm').find('[name=coadari_id]').val()
        let coasampai_id = $('#crudForm').find('[name=coasampai_id]').val()

        if (dari != '' && sampai != '') {

            window.open(`{{ route('laporanbukubesar.export') }}?dari=${dari}&sampai=${sampai}&coadari_id=${coadari_id}&coasampai_id=${coasampai_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    function getCekReport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanbukubesar/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    coadari: $('#crudForm').find('[name=coadari]').val(),
                    coadari_id: $('#crudForm').find('[name=coadari_id]').val(),
                    coasampai: $('#crudForm').find('[name=coasampai]').val(),
                    coasampai_id: $('#crudForm').find('[name=coasampai_id]').val(),
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

        $('.coadari-lookup').lookup({
            title: 'Kd. Perkiraan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
                this.postData = {
                    levelCoa: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (coa, element) => {
                $('#crudForm [name=coadari_id]').first().val(coa.id)
                element.val(coa.keterangancoa)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=coadari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.coasampai-lookup').lookup({
            title: 'Kd. Perkiraan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
                this.postData = {
                    levelCoa: '3',
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (coa, element) => {
                $('#crudForm [name=coasampai_id]').first().val(coa.id)
                element.val(coa.keterangancoa)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=coasampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
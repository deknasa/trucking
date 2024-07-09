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
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row"  style="display:none;">
                            <label class="col-12 col-sm-2 col-form-label mt-2">PERIODE DATA<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" value="{{$data['defaultperiode']['id']}}" name="periodedata_id">
                                    <input type="text" id="periodedata" value="{{$data['defaultperiode']['text']}}" name="periodedata" class="form-control periodedata-lookup">
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
        initSelect2($('#crudForm').find('[name=jenis]'), false)
        setJenisKaryawanOptions($('#crudForm'))
        initLookup()
        initDatepicker()
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        
        if (!`{{ $myAuth->hasPermission('laporandepositosupir', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporandepositosupir', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let periodedata_id = $('#crudForm').find('[name=periodedata_id]').val()
        let periodedata = $('#crudForm').find('[name=periodedata]').val()
        if (sampai != '') {

            window.open(`{{ route('laporandepositosupir.report') }}?sampai=${sampai}&periodedata=${periodedata}&periodedata_id=${periodedata_id}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let sampai = $('#crudForm').find('[name=sampai]').val()
        let periodedata_id = $('#crudForm').find('[name=periodedata_id]').val()
        let periodedata = $('#crudForm').find('[name=periodedata]').val()

        if (sampai != '') {
            $.ajax({
                url: `{{ route('laporandepositosupir.export') }}?sampai=${sampai}&periodedata=${periodedata}&periodedata_id=${periodedata_id}`,
                type: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                },
                xhrFields: {
                    responseType: 'arraybuffer'
                },
                success: function(response, status, xhr) {
                    if (xhr.status === 200) {
                        if (response !== undefined) {
                            var blob = new Blob([response], {
                                type: 'cabang/vnd.ms-excel'
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'LAP. DEPOSITO SUPIR  ' + new Date().getTime() + '.xlsx';
                            link.click();
                        }
                    }
                    
                    $('#processingLoader').addClass('d-none')
                },
                error: function(xhr, status, error) {
                    $('#processingLoader').addClass('d-none')
                    showDialog('TIDAK ADA DATA')
                }
            })
            
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    const setJenisKaryawanOptions = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=jenis]').append(
            new Option('-- PILIH JENIS KARYAWAN --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'JENIS KARYAWAN'
        })
        data.push({
            name: 'subgrp',
            value: 'JENIS KARYAWAN'
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

                response.data.forEach(statusApproval => {
                    let option = new Option(statusApproval.text, statusApproval.id)
                    relatedForm.find('[name=jenis]').append(option).trigger('change')
                });

               
                relatedForm
                    .find('[name=jenis]')
                    .val($(`#crudForm [name=jenis] option:eq(1)`).val())
                    .trigger('change')
                    .trigger('select2:selected');
            }
        })
        // })
    }

    function initLookup() {
       
        $(`.periodedata-lookup`).lookupMaster({
            title: 'PERIODE DATA Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                url: `${apiUrl}parameter/combo`,
                grp: 'PERIODE DATA',
                subgrp: 'PERIODE DATA',
                searching: 1,
                valueName: `periodedata_id`,
                searchText: `periodedata-lookup`,
                singleColumn: true,
                hideLabel: true,
                title: 'PERIODE DATA'
                };
            },
            onSelectRow: (status, element) => {
                $('#crudForm [name=periodedata_id]').first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let status_id_input = $('#crudForm [name=periodedata_id]').first();
                status_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });
    }

</script>
@endpush()
@endsection
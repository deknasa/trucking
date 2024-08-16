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
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Jenis Pinjaman<span class="text-danger"></span></label>
                            <div class="col-sm-4 mt-2">
                                <select name="jenis" id="jenis" class="form-select select2bs4" style="width: 100%;">

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
        initSelect2($('#crudForm').find('[name=jenis]'), false)
        setJenisKaryawanOptions($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


        if (!`{{ $myAuth->hasPermission('laporanpinjamansupirkaryawan', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanpinjamansupirkaryawan', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let jenis = $('#crudForm').find('[name=jenis]').val()

        if (sampai != '') {
            $('#processingLoader').removeClass('d-none')
            $.ajax({
                url: `{{ route('laporanpinjamansupirkaryawan.report') }}`,
                method: 'GET',
                data: {
                    sampai: sampai,
                    jenis: jenis,
                },
                success: function(response) {
                    $('#processingLoader').addClass('d-none')
                    // Handle the success response
                    var newWindow = window.open('', '_blank');
                    newWindow.document.open();
                    newWindow.document.write(response);
                    newWindow.document.close();
                },
                error: function(error) {
                    $('#processingLoader').addClass('d-none')
                    console.log(error)
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        setErrorMessages($('#crudForm'), error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON.message);
                    }
                }
            });
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let jenis = $('#crudForm').find('[name=jenis]').val()

        if (sampai != '') {
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `{{ route('laporanpinjamansupirkaryawan.export') }}?sampai=${sampai}&jenis=${jenis}`,
                type: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                },
                xhrFields: {
                    responseType: 'arraybuffer'
                },
                success: function(response, status, xhr) {
                    $('#processingLoader').addClass('d-none')

                    if (xhr.status === 200) {
                        if (response !== undefined) {
                            var blob = new Blob([response], {
                                type: 'cabang/vnd.ms-excel'
                            });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'LAP. PINJAMAN KARYAWAN ' + new Date().getTime() + '.xlsx';
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
            new Option('-- PILIH JENIS PINJAMAN --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'STATUS POSTING'
        })
        data.push({
            name: 'subgrp',
            value: 'STATUS POSTING'
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

                response.data.forEach(statusPosting => {
                    let option = new Option(statusPosting.text, statusPosting.id)
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
</script>
@endpush()
@endsection
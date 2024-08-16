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
                        {{-- <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                            <label class="col-12 col-sm-2 col-form-label mt-2">Minggu ke<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="minggu" class="form-control datepicker">
                                </div>
                            </div>
                            
                        </div> --}}

                        <div class="form-group row">
                            <label class="col-12 col-sm-1 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-11 mt-2">
                                <div class="input-group">
                                    <input type="text" name="dari" class="form-control datepicker">
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-1 col-form-label mt-2">SUPPLIER</label>
                            <div class="col-sm-5 mt-2">
                                <input type="hidden" name="supplierdari_id">
                                <input type="text" id="supplierdari" name="supplierdari" class="form-control supplierdari-lookup">
                            </div>
                            <h5 class="col-sm-1 mt-3 text-center">s/d</h5>
                            <div class="col-sm-5 mt-2">
                                <input type="hidden" name="suppliersampai_id">
                                <input type="text" id="suppliersampai" name="suppliersampai" class="form-control suppliersampai-lookup">
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
        initSelect2($('#crudForm').find('[name=status]'), false)
        setLaporanKartuHutangPerSupplier($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger(
            'change');

        if (!`{{ $myAuth->hasPermission('laporankartuhutangpersupplier', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporankartuhutangpersupplier', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
        initLookup()
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let supplierdari_id = $('#crudForm').find('[name=supplierdari_id]').val()
        let suppliersampai_id = $('#crudForm').find('[name=suppliersampai_id]').val()
        let supplierdari = $('#crudForm').find('[name=supplierdari]').val()
        let suppliersampai = $('#crudForm').find('[name=suppliersampai]').val()

        getCekReport().then((response) => {
            window.open(
                `{{ route('laporankartuhutangpersupplier.report') }}?dari=${dari}&supplierdari_id=${supplierdari_id}&suppliersampai_id=${suppliersampai_id}&supplierdari=${supplierdari}&suppliersampai=${suppliersampai}`
            )
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                // return showDialog(error.responseJSON.errors.export);

                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.statusText, error.responseJSON.message)

            }
        })

    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let dari = $('#crudForm').find('[name=dari]').val()
        let supplierdari_id = $('#crudForm').find('[name=supplierdari_id]').val()
        let suppliersampai_id = $('#crudForm').find('[name=suppliersampai_id]').val()
        let supplierdari = $('#crudForm').find('[name=supplierdari]').val()
        let suppliersampai = $('#crudForm').find('[name=suppliersampai]').val()

        $.ajax({
            url: `{{ route('laporankartuhutangpersupplier.export') }}?dari=${dari}&supplierdari_id=${supplierdari_id}&suppliersampai_id=${suppliersampai_id}&supplierdari=${supplierdari}&suppliersampai=${suppliersampai}`,
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
                        link.download = 'LAPORAN KARTU HUTANG PER SUPPLIER ' + new Date().getTime() + '.xlsx';
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
    })

    function getCekReport() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporankartuhutangpersupplier/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    supplierdari: $('#crudForm').find('[name=supplierdari]').val(),
                    supplierdari_id: $('#crudForm').find('[name=supplierdari_id]').val(),
                    suppliersampai: $('#crudForm').find('[name=suppliersampai]').val(),
                    suppliersampai_id: $('#crudForm').find('[name=suppliersampai_id]').val(),
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
                url: `${apiUrl}laporankartuhutangpersupplier/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    supplierdari: $('#crudForm').find('[name=supplierdari]').val(),
                    supplierdari_id: $('#crudForm').find('[name=supplierdari_id]').val(),
                    suppliersampai: $('#crudForm').find('[name=suppliersampai]').val(),
                    suppliersampai_id: $('#crudForm').find('[name=suppliersampai_id]').val(),
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

        $('.supplierdari-lookup').lookupMaster({
            title: 'Supplier Lookup',
            fileName: 'supplierMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supplierdari_id',
                    searchText: 'supplierdari-lookup',
                    title: 'Supplier Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=supplierdari_id]').first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supplierdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.suppliersampai-lookup').lookupMaster({
            title: 'Supplier Lookup',
            fileName: 'supplierMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'suppliersampai_id',
                    searchText: 'suppliersampai-lookup',
                    title: 'Supplier Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=suppliersampai_id]').first().val(supplier.id)
                element.val(supplier.namasupplier)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=suppliersampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    const setLaporanKartuHutangPerSupplier = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=status]').append(
            new Option('-- PILIH STATUS KEMBALI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'LAPORAN PEMBELIAN'
        })
        data.push({
            name: 'subgrp',
            value: 'LAPORAN PEMBELIAN'
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

                response.data.forEach(laporanPembelian => {
                    let option = new Option(laporanPembelian.text, laporanPembelian.text)
                    relatedForm.find('[name=status]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=approve]')
                //     .val($(`#crudForm [name=approve] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');

                // resolve()
            }
        })
        // })
    }
</script>
@endpush()
@endsection
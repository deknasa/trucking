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
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">JENIS<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="jenis">
                                <input type="text" id="jenis" name="jenisnama" class="form-control jenis-lookup">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnExport" class="btn btn-warning mr-2 ">
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
        initLookup()

        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: "button",
                dateFormat: 'mm-yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }).siblings(".ui-datepicker-trigger")
            .wrap(
                `
			<div class="input-group-append">
			</div>
		`
            )
            .addClass("ui-datepicker-trigger btn btn-easyui text-easyui-dark").html(`
			<i class="fa fa-calendar-alt"></i>
		`);


        if (!`{{ $myAuth->hasPermission('exportpemakaianbarang', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        let jenis = $('#crudForm').find('[name=jenis]').val()

        if (periode != '' && jenis != '') {

            // window.open(`{{ route('exportpemakaianbarang.export') }}?periode=${periode}&jenis=${jenis}`)
            $.ajax({
                url: `${apiUrl}exportpemakaianbarang/export`,
                // url: `{{ route('laporanpembelianstok.export') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&stokdari=${stokdari}&stoksampai=${stoksampai}`,
                type: 'GET',
                data: {
                    periode: periode,
                    jenis: jenis
                },
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
                            link.download = 'LAP. PEMAKAIAN BARANG ' + new Date().getTime() + '.xlsx';
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

    function initLookup() {
        $('.jenis-lookup').lookupMaster({
            title: 'Jenis Pemakaian Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'JENIS PEMAKAIAN BARANG',
                    subgrp: 'JENIS PEMAKAIAN BARANG',
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'jenis_id',
                    searchText: 'text-lookup',
                    title: 'Jenis Pemakaian Lookup',
                    typeSearch: 'ALL',
                    singleColumn: true,
                    hideLabel: true,
                }
            },
            onSelectRow: (jenis, element) => {
                $('#crudForm [name=jenis]').first().val(jenis.id)
                element.val(jenis.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=jenis]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection
@extends('layouts.master')

@section('content')

<style>
    /* .ui-datepicker-calendar {
        display: none;
    } */
</style>
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
                                    <input type="text" name="periode" class="form-control monthpicker">
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Status<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <select name="status" id="status" class="form-select select2" style="width: 100%;">
                                    @foreach ($data['combostatus'] as $status)
                                    <option value="{{$status['id']}}"> {{$status['parameter']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 mt-2">
                                <a id="btnReload" class="btn btn-primary mr-2">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body border-bottom-0">
                    <div id="tabs">
                        <ul class="dejavu">
                            <li><a href="#detail-tab">Details</a></li>
                            <li><a href="#jurnal-tab">Jurnal</a></li>
                        </ul>
                        <div id="detail-tab">
                            <table id="detail"></table>
                        </div>

                        <div id="jurnal-tab">
                            <table id="jurnalGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Detail -->
@include('pencairangiropengeluaran._detail')
@include('pencairangiropengeluaran._modal')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
    let indexUrl = "{{ route('pencairangiropengeluaranheader.index') }}"
    let getUrl = "{{ route('pencairangiropengeluaranheader.get') }}"
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
    let sortname = 'pengeluaran_nobukti'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let hasDetail = false
    let currentTab = 'detail'
    let selectedRows = [];

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                }
            }
        }
    }

    initMonthpicker();
    $(document).ready(function() {
        $('#tabs').tabs();

        let nobukti = $('#jqGrid').jqGrid('getCell', id, 'pengeluaran_nobukti')
        loadDetailGrid()
        loadJurnalUmumGrid(nobukti)
        $('.select2').select2({
            width: 'resolve',
            theme: "bootstrap4"
        });
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

        $(document).on('click', '#btnReload', function(event) {
            $('.checkbox-jqgrid').prop('disabled',true)
            selectedRows = []
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    periode: $('#crudForm').find('[name=periode]').val(),
                    status: $('#status').find(":selected").val(),
                    proses: 'reload'
                },
            }).trigger('reloadGrid');
           

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        })

        function approve() {

            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let data = $('#crudForm').serializeArray()


            let nobukti = [];
            let nobuktiCair = [];
            let tglbuktigiro = [];
            $.each(selectedRows, function(index, item) {
                nobukti.push($(`#jqGrid tr#${item}`).find(`td[aria-describedby="jqGrid_pengeluaran_nobukti"]`).text())
                nobuktiCair.push($(`#jqGrid tr#${item}`).find(`td[aria-describedby="jqGrid_nobukti"]`).text())
                tglbuktigiro.push($(`#jqGrid tr#${item}`).find(`td[aria-describedby="jqGrid_tglbukti_giro"]`).text())
            });
            let requestData = {
                'nobukti': nobukti,
                'nobuktiCair': nobuktiCair,
                'tglbuktigiro': tglbuktigiro,
            };

            data.push({
                name: 'jumlahdetail',
                value: selectedRows.length
            })
            data.push({
                name: 'detail',
                value: JSON.stringify(requestData)
            })
            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })
            data.push({
                name: 'periode',
                value: $('#crudForm').find('[name=periode]').val()
            })
            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })


            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}pencairangiropengeluaranheader`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    $('#crudModal').modal('hide')
                   
                    $('#jqGrid').jqGrid('setGridParam', {
                        postData: {
                            periode: $('#crudForm').find('[name=periode]').val(),
                            status: $('#status').find(":selected").val(),
                            proses: 'reload'
                        },
                    }).trigger('reloadGrid');
                    selectedRows = []
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                },
                error: error => {

                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        $('#crudForm').find('[name=periode]').val(data.periode)
                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })

        }
        let form = $('#crudForm');

        $("#jqGrid").jqGrid({
                url: `{{ config('app.api_url') . 'pencairangiropengeluaranheader' }}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'Pilih',
                        name: 'id',
                        index: 'Pilih',
                        formatter: (value) => {
                            return `<input type="checkbox" class="checkbox-jqgrid" value="${value}" onchange="checkboxHandler(this)">`
                        },
                        editable: true,
                        edittype: 'checkbox',
                        search: false,
                        width: 70,
                        align: 'center',
                        formatoptions: {
                            disabled: false
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        align: 'left'
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'tglbukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'NO BUKTI GIRO',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                        name: 'urlpengeluaran',
                        align: 'left',
                        formatter: (value, options, rowData) => {
                            if ((value == null) || (value == '')) {
                                return '';
                            }
                        //     let tgldari = rowData.tgldariheaderpengeluaranheader
                        //     let tglsampai = rowData.tglsampaiheaderpengeluaranheader
                        //     let url = "{{route('pengeluaranheader.index')}}"
                        //     let formattedValue = $(`
                        //     <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
                        //    `)
                            return value
                        }
                    },
                    {
                        label: 'TGL BUKTI GIRO',
                        name: 'tglbukti_giro',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat
                    },
                    {
                        label: 'pengeluaran_nobukti',
                        name: 'pengeluaran_nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        hidden: true,
                        search: false
                    },
                    {
                        label: 'ALAT BAYAR',
                        name: 'alatbayar_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'TGL JATUH TEMPO',
                        name: 'tgljatuhtempo',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'BANK',
                        name: 'bank_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'DIBAYAR KE',
                        name: 'dibayarke',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'CREATED AT',
                        name: 'created_at',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        align: 'right',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'UPDATED AT',
                        name: 'updated_at',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        align: 'right',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortname,
                sortorder: sortorder,
                page: page,
                viewrecords: true,
                postData: {
                    periode: $('#crudForm').find('[name=periode]').val(),
                    status: $('#status').find(":selected").val()
                },
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },
                loadError: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();

                        setErrorMessages(form, xhr.responseJSON.errors);
                    } else {
                        showDialog(xhr.statusText);
                    }
                },
                onSelectRow: function(id, status) {
                    let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_pengeluaran_nobukti"]`).attr('title') ?? '';
                    let nobuktiCair = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

                    loadDetailData(id, nobukti, $('#status').find(":selected").val())
                    loadJurnalUmumData(id, nobuktiCair)
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    if (data.data.length === 0) {
                        $('#detail, #jurnalGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridData($(element))
                        })
                    }

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    //CHECKED STAY STILL
                    $.each(selectedRows, function(key, value) {

                        $('#jqGrid tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).find(`td input:checkbox`).prop('checked', true)
                            }
                        })

                    });

                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').limit
                    postData = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }

                    setTimeout(function() {

                        if (triggerClick) {
                            if (id != '') {
                                indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                                id = ''
                            } else if (indexRow != undefined) {
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                            }

                            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                                $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                            }

                            triggerClick = false
                        } else {
                            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                        }
                    }, 100)
                    $('.checkbox-jqgrid').prop('disabled',false)
                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    setHighlight($(this))
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {
                    abortGridLastRequest($(this))
                    $('#left-nav').attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({
                buttons: [{
                        id: 'approveun',
                        innerHTML: '<i class="fa fa-plus"></i> PROSES',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: () => {

                            approve()

                        }
                    },
                    {
                        id: 'edittgl',
                        innerHTML: '<i class="fa fa-pen"></i> EDIT TGL JATUH TEMPO',
                        class: 'btn btn-success btn-sm mr-1',
                        onClick: () => {
                            $('#tglJatuhTempoModal').data('action', 'edittgl')
                            $('#tglJatuhTempoModal').modal('show')

                        }
                    }
                ]
                
            })
        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        function permission() {
            if (!`{{ $myAuth->hasPermission('pencairangiropengeluaranheader', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('pencairangiropengeluaranheader', 'updateTglJatuhTempo') }}`) {
                $('#edittgl').attr('disabled', 'disabled')
            }
        }
    })
</script>
@endpush()
@endsection
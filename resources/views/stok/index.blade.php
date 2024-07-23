@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table id="jqGrid"></table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table id="detailsupplier"></table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="detailSPB"></table>
        </div>
    </div>
</div>

@include('stok._modal')
@include('stok._detailsupplier')
@include('stok._detailSPB')

@push('scripts')
<script>
    let indexUrl = "{{ route('stok.index') }}"
    let getUrl = "{{ route('stok.get') }}"
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let masterStokId = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'namastok'
    let sortorder = 'asc'
    let approveEditRequest = null;

    let autoNumericElements = []
    let selectedRows = [];
    let selectedRowsStok = [];

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
            selectedRowsStok.push($(element).parents('tr').find(`td[aria-describedby="jqGrid_namastok"]`).text())
            $(element).parents('tr').addClass('bg-light-blue')


        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                    selectedRowsStok.splice(i, 1);
                }
            }
        }
    }

    function clearSelectedRows() {
        selectedRows = []
        selectedRowsStok = []
        $('#gs_').prop('checked', false);
        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}stok`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                limit: 0,
                filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
            },
            success: (response) => {
                selectedRows = response.data.map((stok) => stok.id)
                selectedRowsStok = response.data.map((stok) => stok.namastok)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }


    $(document).ready(function() {

        $('#lookup').hide()

        loadSupplierGrid()
        loadSPBGrid()



        $('#crudModal').on('hidden.bs.modal', function() {
            activeGrid = '#jqGrid'
        })

        $("#jqGrid").jqGrid({
                url: `{{ config('app.api_url') . 'stok' }}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: '',
                        name: 'check',
                        width: 30,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        searchable: false,
                        searchoptions: {
                            type: 'checkbox',
                            clearSearch: false,
                            dataInit: function(element) {
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')
                                $(element).on('click', function() {
                                    $(element).attr('disabled', true)
                                    if ($(this).is(':checked')) {
                                        selectAllRows()
                                    } else {
                                        clearSelectedRows()
                                    }
                                })
                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '70px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'gambar',
                        name: 'gambar',
                        align: 'center',
                        search: false,
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        formatter: (value, row) => {
                            let images = []
                            if (value.length) {
                                let files = JSON.parse(value)

                                files.forEach(file => {
                                    if (file == '') {
                                        file = 'no-image'
                                    }
                                    let image = new Image()
                                    image.width = 25
                                    image.height = 25
                                    image.src =
                                        `${apiUrl}stok/${encodeURI(file)}/small`
                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}stok/no-image/small`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'NAMA',
                        name: 'namastok',
                        align: 'left',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
                    },
                    {
                        label: 'STATUS aktif',
                        name: 'statusaktif',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combo'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combo'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
                        `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            let statusaktif = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusaktif.WARNA}; color: ${statusaktif.WARNATULISAN};">
                  <span>${statusaktif.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusaktif = JSON.parse(rowObject.statusaktif)

                            return ` title="${statusaktif.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS reuse',
                        name: 'statusreuse',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['comboreuse'] as $status) :
                                        echo "$status[id]:$status[parameter]";
                                        if ($i !== count($data['comboreuse'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
                        `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            if (!value) {
                                return ''
                            }
                            let statusreuse = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusreuse.WARNA}; color: ${statusreuse.WARNATULISAN};">
                  <span>${statusreuse.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            if (!rowObject.statusreuse) {
                                return ''
                            }
                            let statusreuse = JSON.parse(rowObject.statusreuse)

                            return ` title="${statusreuse.MEMO}"`
                        }
                    },
                    {
                        label: 'tanpa klaim',
                        name: 'statusapprovaltanpaklaim',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combotanpaclaim'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combotanpaclaim'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
                        `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            if (!value) {
                                return ''
                            }
                            let statusreuse = JSON.parse(value)

                            let formattedValue = $(`
                            <div class="badge" style="background-color: ${statusreuse.WARNA}; color: ${statusreuse.WARNATULISAN};">
                                <span>${statusreuse.SINGKATAN}</span>
                            </div>
                            `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            if (!rowObject.statusapprovaltanpaklaim) {
                                return ''
                            }
                            let statusreuse = JSON.parse(rowObject.statusapprovaltanpaklaim)

                            return ` title="${statusreuse.MEMO}"`
                        }
                    },
                    {
                        label: 'keterangan',
                        name: 'keterangan',
                        width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
                        align: 'left',

                    },
                    {
                        label: 'Umur Aki',
                        name: 'umuraki',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'right',
                    },
                    {
                        label: 'Vulkanisir',
                        name: 'vulkan',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'right',
                    },
                    {
                        label: 'nama terpusat',
                        name: 'namaterpusat',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                        align: 'left',
                    },
                    {
                        label: 'kelompok',
                        name: 'kelompok',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'jenis trado',
                        name: 'jenistrado',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'sub kelompok',
                        name: 'subkelompok',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'kategori',
                        name: 'kategori',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                        align: 'left'
                    },
                    {
                        label: 'merk',
                        name: 'merk',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },

                    {
                        label: 'qty min',
                        name: 'qtymin',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                    },
                    {
                        label: 'qty max',
                        name: 'qtymax',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                    },
                    {
                        label: 'STATUS SERVICE RUTIN',
                        name: 'statusservicerutin',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['comboservice'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['comboservice'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
                        `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            let statusservicerutin = JSON.parse(value)
                            if (!statusservicerutin) {
                                return ''
                            }

                            let formattedValue = $(`
            <div class="badge" style="background-color: ${statusservicerutin.WARNA}; color: #fff;">
              <span>${statusservicerutin.SINGKATAN}</span>
            </div>
          `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusservicerutin = JSON.parse(rowObject.statusservicerutin)
                            if (!statusservicerutin) {
                                return ` title=" "`
                            }
                            return ` title="${statusservicerutin.MEMO}"`
                        }
                    },

                    {
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
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
                postData: {
                    dari: "index"
                },
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
                onSelectRow: function(id) {

                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

                    loadSuplierData(id)
                    masterStokId = id

                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    $.each(selectedRows, function(key, value) {
                        $('#jqGrid tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).find(`td input:checkbox`).prop('checked', true)
                                $(this).addClass('bg-light-blue')
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
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`)
                                    .click()
                                id = ''
                            } else if (indexRow != undefined) {
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`)
                                    .click()
                            }

                            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                                $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                            }

                            triggerClick = false
                        } else {
                            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                        }
                    }, 100)
                    $('#gs_check').prop('disabled', false)

                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    $('#gs_').attr('disabled', false)
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
                    $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: function(event) {
                            createStok()
                        }
                    },
                    {
                        id: 'edit',
                        innerHTML: '<i class="fa fa-pen"></i> EDIT',
                        class: 'btn btn-success btn-sm mr-1',
                        onClick: function(event) {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasidelete(selectedId, 'edit')

                                // editStok(selectedId)
                            }
                        }
                    },
                    {
                        id: 'delete',
                        innerHTML: '<i class="fa fa-trash"></i> DELETE',
                        class: 'btn btn-danger btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasidelete(selectedId, 'delete')
                            }
                        }
                    },
                    {
                        id: 'view',
                        innerHTML: '<i class="fa fa-eye"></i> VIEW',
                        class: 'btn btn-orange btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            viewStok(selectedId)
                        }
                    },
                    {
                        id: 'report',
                        innerHTML: '<i class="fa fa-print"></i> REPORT',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: () => {
                            $('#rangeModal').data('action', 'report')
                            $('#rangeModal').find('button:submit').html(`Report`)
                            $('#rangeModal').modal('show')
                        }
                    },
                    {
                        id: 'export',
                        innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
                        class: 'btn btn-warning btn-sm mr-1',
                        onClick: () => {
                            $('#rangeModal').data('action', 'export')
                            $('#rangeModal').find('button:submit').html(`Export`)
                            $('#rangeModal').modal('show')
                        }
                    },
                ],
                modalBtnList: [{
                    id: 'approve',
                    title: 'Approve',
                    caption: 'Approve',
                    innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
                    class: 'btn btn-purple btn-sm mr-1',
                    item: [{
                            id: 'approvalTanpaKlaim',
                            text: ' APPROVAL/UN Tanpa Klaim',
                            color: `<?php echo $data['listbtn']->btn->approvaltanpaklaim; ?>`,
                            hidden:(!`{{ $myAuth->hasPermission('stok', 'approvalklaim') }}`),
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                approvalTanpaKlaim(selectedId)
                            }
                        },
                        {
                            id: 'approvalReuse',
                            text: ' APPROVAL/UN Reuse',
                            color: `<?php echo $data['listbtn']->btn->approvalreuse; ?>`,
                            hidden:(!`{{ $myAuth->hasPermission('stok', 'approvalReuse') }}`),
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                approvalReuse(selectedId)
                            }
                        },
                        {
                            id: 'approveun',
                            text: ' APPROVAL NON AKTIF',
                            color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
                            hidden:(!`{{ $myAuth->hasPermission('stok', 'approvalnonaktif') }}`),
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                approvalNonAktif('stok')
                            }
                        },
                        {
                            id: 'approvalaktif',
                            text: ' APPROVAL AKTIF',
                            color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
                            hidden:(!`{{ $myAuth->hasPermission('stok', 'approvalaktif') }}`),
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                approvalAktif('stok')
                            }
                        },
                    ],
                }]

            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        $('#add .ui-pg-div')
            .addClass(`btn btn-sm btn-primary`)
            .parent().addClass('px-1')

        $('#edit .ui-pg-div')
            .addClass('btn btn-sm btn-success')
            .parent().addClass('px-1')

        $('#delete .ui-pg-div')
            .addClass('btn btn-sm btn-danger')
            .parent().addClass('px-1')

        $('#report .ui-pg-div')
            .addClass('btn btn-sm btn-info')
            .parent().addClass('px-1')

        $('#export .ui-pg-div')
            .addClass('btn btn-sm btn-warning')
            .parent().addClass('px-1')

        function permission() {

            if (cabangTnl == 'YA') {
                $('#add').attr('disabled', 'disabled')
            } else {
                if (!`{{ $myAuth->hasPermission('stok', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

            }

            if (!`{{ $myAuth->hasPermission('stok', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }

            // if (!`{{ $myAuth->hasPermission('stok', 'update') }}`) {

            if (cabangTnl == 'YA') {
                $('#edit').attr('disabled', 'disabled')
                $('#delete').attr('disabled', 'disabled')
            } else {

                if ((!`{{ $myAuth->hasPermission('stok', 'update') }}`) && (!`{{ $myAuth->hasPermission('stok', 'updateuser') }}`)) {

                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('stok', 'destroy') }}`) {
                    $('#delete').attr('disabled', 'disabled')
                }
            }

            if (!`{{ $myAuth->hasPermission('stok', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('stok', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
            let hakApporveCount = 0;
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('stok', 'approvalklaim') }}`) {
                hakApporveCount--
                $('#approvalTanpaKlaim').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('stok', 'approvalReuse') }}`) {
                hakApporveCount--
                $('#approvalReuse').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('stok', 'approvalnonaktif') }}`) {
                hakApporveCount--
                $('#approveun').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('stok', 'approvalaktif') }}`) {
                hakApporveCount--
                $('#approvalaktif').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            if (hakApporveCount < 1) {
                $('#approve').hide()
                //   $('#approve').attr('disabled', 'disabled')
            }
        }

        $('#rangeModal').on('shown.bs.modal', function() {
            if (autoNumericElements.length > 0) {
                $.each(autoNumericElements, (index, autoNumericElement) => {
                    autoNumericElement.remove()
                })
            }

            $('#formRange [name]:not(:hidden)').first().focus()

            $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
            $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
            if (page == 0) {
                $('#formRange [name=dari]').val(page)
                $('#formRange [name=sampai]').val(totalRecord)
            } else {
                $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
                $('#formRange [name=sampai]').val(totalRecord)
            }

            autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 0,
                allowDecimalPadding: false,
                minimumValue: 1,
                maximumValue: totalRecord
            })
        })

        $('#rangeModal').on('hidden.bs.modal', function() {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        })

        $('#formRange').submit(function(event) {
            event.preventDefault()

            let params
            let submitButton = $(this).find('button:submit')
            submitButton.attr('disabled', 'disabled')
            $('#processingLoader').removeClass('d-none')

            /* Set params value */
            for (var key in postData) {
                if (params != "") {
                    params += "&";
                }
                params += key + "=" + encodeURIComponent(postData[key]);
            }

            let formRange = $('#formRange')
            let offset = parseInt(formRange.find('[name=dari]').val().replace('.', '').replace(',', '')) - 1
            let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '').replace(',', '')) - offset
            params += `&offset=${offset}&limit=${limit}`

            getCekExport(params).then((response) => {
                    if ($('#rangeModal').data('action') == 'export') {
                        $.ajax({
                            url: `{{ config('app.api_url') }}stok/export?` + params,
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
                                            type: 'application/vnd.ms-excel'
                                        });
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = 'laporanStok' + new Date().getTime() + '.xlsx';
                                        link.click();
                                    }
                                    $('#rangeModal').modal('hide')
                                }

                            },
                            error: function(xhr, status, error) {
                                $('#processingLoader').addClass('d-none')
                                submitButton.removeAttr('disabled')
                            }
                        }).always(() => {
                            $('#processingLoader').addClass('d-none')

                            submitButton.removeAttr('disabled')
                        })
                        // let xhr = new XMLHttpRequest()
                        // xhr.open('GET', `{{ config('app.api_url') }}stok/export?${params}`, true)
                        // xhr.setRequestHeader("Authorization",
                        //     `Bearer {{ session('access_token') }}`)
                        // xhr.responseType = 'arraybuffer'

                        // xhr.onload = function(e) {
                        //     if (this.status === 200) {
                        //         if (this.response !== undefined) {
                        //             let blob = new Blob([this.response], {
                        //                 type: "application/vnd.ms-excel"
                        //             })
                        //             let link = document.createElement('a')

                        //             link.href = window.URL.createObjectURL(blob)
                        //             link.download = `laporanStok${(new Date).getTime()}.xlsx`
                        //             link.click()

                        //             // submitButton.removeAttr('disabled')
                        //         }
                        //     }
                        // }

                        // xhr.onerror = () => {
                        //     // submitButton.removeAttr('disabled')
                        // }

                        // xhr.send()
                        // // submitButton.removeAttr('disabled')
                    } else if ($('#rangeModal').data('action') == 'report') {
                        window.open(`{{ route('stok.report') }}?${params}`)
                        submitButton.removeAttr('disabled')
                        $('#processingLoader').addClass('d-none')
                        $('#rangeModal').modal('hide')
                    }
                })
                .catch((error) => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        let status
                        if (error.responseJSON.hasOwnProperty('status') == false) {
                            status = false
                        } else {
                            status = true
                        }
                        statusText = error.statusText
                        errors = error.responseJSON.errors
                        $.each(errors, (index, error) => {
                            let indexes = index.split(".");
                            if (status === false) {
                                indexes[0] = 'sampai'
                            }
                            let element;
                            element = $('#rangeModal').find(`[name="${indexes[0]}"]`)[
                                0];
                            if ($(element).length > 0 && !$(element).is(":hidden")) {
                                $(element).addClass("is-invalid");
                                $(`
                                            <div class="invalid-feedback">
                                            ${error[0].toLowerCase()}
                                            </div>
                                    `).appendTo($(element).parent());
                            } else {
                                setTimeout(() => {
                                    return showDialog(error);
                                }, 100)
                            }
                        });
                        $(".is-invalid").first().focus();
                        $('#processingLoader').addClass('d-none')

                    } else {
                        showDialog(error.statusText)
                    }
                })
                .finally(() => {
                    $('.ui-button').click()
                    submitButton.removeAttr('disabled')
                })
        })

        function getCekExport(params) {

            params += `&cekExport=true`

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}stok/export?${params}`,
                    dataType: "JSON",
                    headers: {
                        Authorization: `Bearer ${accessToken}`
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

        function approvalTanpaKlaim(id) {
            if (approveEditRequest) {
                approveEditRequest.abort();
            }
            approveEditRequest =
                $.ajax({
                    url: `${apiUrl}stok/approvalklaim`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        Id: selectedRows,
                        nama: selectedRowsStok
                    },
                    success: response => {
                        $('#crudForm').trigger('reset')
                        $('#crudModal').modal('hide')

                        $('#jqGrid').jqGrid().trigger('reloadGrid');
                        selectedRows = []
                        selectedRowsStok = []
                        $('#gs_').prop('checked', false)
                    },
                    error: error => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    },
                }).always(() => {
                    $('#processingLoader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })
        }

        function approvalReuse(id) {
            if (approveEditRequest) {
                approveEditRequest.abort();
            }
            approveEditRequest =
                $.ajax({
                    url: `${apiUrl}stok/approvalreuse`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        Id: selectedRows,
                        nama: selectedRowsStok,
                        info: info
                    },
                    success: response => {
                        $('#crudForm').trigger('reset')
                        $('#crudModal').modal('hide')

                        $('#jqGrid').jqGrid().trigger('reloadGrid');
                        selectedRows = []
                        selectedRowsStok = []
                        $('#gs_').prop('checked', false)
                    },
                    error: error => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    },
                }).always(() => {
                    $('#processingLoader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })
        }

        // function approvalTanpaKlaim(id) {
        //     if (approveEditRequest) {
        //         approveEditRequest.abort();
        //     }     
        //     approveEditRequest = $.ajax({
        //         url: `${apiUrl}stok/${id}`,
        //         method: 'GET',
        //         dataType: 'JSON',
        //         headers: {
        //             Authorization: `Bearer ${accessToken}`
        //         },
        //         success: response => {
        //             let msg = `YAKIN Approve Status Boleh Tanpa Klaim `
        //             console.log(response.data);
        //             if (response.data.statusapprovaltanpaklaim === statusTanpaKlaim) {
        //                 msg = `YAKIN UnApprove Status Boleh Tanpa Klaim `
        //             }
        //             showConfirm(msg,response.data.nobukti,`stok/${response.data.id}/approvalklaim`)
        //         },
        //     })
        // }

        getStatusTanpaKlaim()

        function getStatusTanpaKlaim() {
            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    limit: 0,
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": "STATUS APPROVAL"
                        }, {
                            "field": "text",
                            "op": "cn",
                            "data": "APPROVAL"
                        }]
                    })
                },
                success: response => {
                    statusTanpaKlaim = response.data[0].id;
                }
            })
        }





    })
</script>
@endpush()
@endsection
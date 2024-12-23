@extends('layouts.master')

@section('content')
    <!-- Grid -->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <table id="jqGrid"></table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-body" style="min-height: 529px">
                        <div id="tabs" style="font-size:12px">
                            <ul class="dejavu">
                                <li><a href="#role-tab">Role</a></li>
                                <li><a href="#acl-tab">Acl</a></li>
                            </ul>
                            <div id="role-tab">
                                <table id="userRoleGrid"></table>
                            </div>
                            <div id="acl-tab">
                                <table id="userAclGrid"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user._modal')
    @include('user.role._grid')
    @include('user.acl._grid')

    @push('scripts')
        <script>
            let indexRow = 0;
            let page = 0;
            let id = "";
            let triggerClick = true;
            let highlightSearch;
            let totalRecord
            let limit
            let postData
            let sortname = 'user'
            let sortorder = 'asc'
            let autoNumericElements = []
            let currentTab = 'role'

            $(document).ready(function() {
                $("#tabs").tabs()

                loadUserRoleGrid()
                loadUserAclGrid()

                jqGrid = $("#jqGrid")
                    .jqGrid({
                        url: `${apiUrl}user`,
                        mtype: "GET",
                        styleUI: 'Bootstrap4',
                        iconSet: 'fontAwesome',
                        datatype: "json",
                        colModel: [{
                                label: 'ID',
                                name: 'id',
                                align: 'right',
                                width: '70px',
                                search: false,
                                hidden: true
                            },
                            {
                                label: 'USER',
                                name: 'user',
                                align: 'left',
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                            },
                            {
                                label: 'NAMA USER',
                                name: 'name',
                                align: 'left',
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                            },
                            {
                                label: 'EMAIL',
                                name: 'email',
                                align: 'left',
                                width: (detectDeviceType() == "desktop") ?md_dekstop_4 : md_mobile_4,

                            },
                            {
                                label: 'DASHBOARD',
                                name: 'dashboard',
                                align: 'left',
                                hidden: true,
                                width: (detectDeviceType() == "desktop") ?sm_dekstop_2 : sm_mobile_2,

                            },
                          
                           

                            // {
                            //   label: 'ID KARYAWAN',
                            //   name: 'karyawan_id',
                            //   align: 'right'
                            // },

                            {
                                label: 'Cabang',
                                name: 'cabang_id',
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                                stype: 'select',

                                searchoptions: {
                                    value: `<?php
                                    $i = 1;
                                    
                                    foreach ($data['combocabang'] as $status):
                                        echo "$status[param]:$status[namacabang]";
                                        if ($i !== count($data['combocabang'])) {
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

                            },
                            {
                                label: 'Status',
                                name: 'statusaktif',
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                                stype: 'select',
                                searchoptions: {
                                    value: `<?php
                                    $i = 1;
                                    
                                    foreach ($data['combo'] as $status):
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
                                    let statusAktif = JSON.parse(value)

                                    let formattedValue = $(`
                                        <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                                        <span>${statusAktif.SINGKATAN}</span>
                                        </div>
                                    `)

                                    return formattedValue[0].outerHTML
                                },
                                cellattr: (rowId, value, rowObject) => {
                                    let statusAktif = JSON.parse(rowObject.statusaktif)

                                    return ` title="${statusAktif.MEMO}"`
                                }
                            },
                            {
                                label: 'Status AKSES',
                                name: 'statusakses',
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                                stype: 'select',
                                searchoptions: {
                                    value: `<?php
                                    $i = 1;
                                    
                                    foreach ($data['statusakses'] as $status):
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusakses'])) {
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
                                    let statusAkses = JSON.parse(value)

                                    let formattedValue = $(`
                                        <div class="badge" style="background-color: ${statusAkses.WARNA}; color: #fff;">
                                        <span>${statusAkses.SINGKATAN}</span>
                                        </div>
                                    `)

                                    return formattedValue[0].outerHTML
                                },
                                cellattr: (rowId, value, rowObject) => {
                                    let statusAkses = JSON.parse(rowObject.statusakses)

                                    return ` title="${statusAkses.MEMO}"`
                                }
                            },
                            {
                                label: 'MODIFIED BY',
                                name: 'modifiedby',
                                align: 'left',
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                            },
                            {
                                label: 'CREATED AT',
                                name: 'created_at',
                                align: 'right',
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,            
                                formatter: "date",
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                                formatoptions: {
                                    srcformat: "ISO8601Long",
                                    newformat: "d-m-Y H:i:s"
                                }
                            },
                            {
                                label: 'UPDATED AT',
                                name: 'updated_at',
                                align: 'right',
                                formatter: "date",
                                width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,            
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
                            let userId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
                            if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

                            loadUserRoleData(id)
                            loadUserAclData(id)
                        },
                        loadComplete: function(data) {
                            changeJqGridRowListText()

                            if (data.data.length === 0) {
                                $('#userRoleGrid, #userAclGrid').each((index, element) => {
                                abortGridLastRequest($(element))
                                clearGridData($(element))
                                })
                                $('#jqGrid').each((index, element) => {
                                abortGridLastRequest($(element))
                                clearGridHeader($(element))
                                })
                            }

                            $(document).unbind('keydown')
                            setCustomBindKeys($(this))

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

                            $('#left-nav').find('button').attr('disabled', false)
                            permission() 
                            setHighlight($(this))
                        }
                    })

                    .customPager({
                        buttons: [{
                                id: 'add',
                                innerHTML: '<i class="fa fa-plus"></i> ADD',
                                class: 'btn btn-primary btn-sm mr-1',
                                onClick: () => {
                                    createUser()
                                }
                            },
                            {
                                id: 'edit',
                                innerHTML: '<i class="fa fa-pen"></i> EDIT',
                                class: 'btn btn-success btn-sm mr-1',
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                                    editUser(selectedId)
                                }
                            },
                            {
                                id: 'delete',
                                innerHTML: '<i class="fa fa-trash"></i> DELETE',
                                class: 'btn btn-danger btn-sm mr-1',
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                                    deleteUser(selectedId)
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
                        ]
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

                /* Append clear filter button */
                loadClearFilter($('#jqGrid'))

                /* Append global search */
                loadGlobalSearch(jqGrid)

                $('#add .ui-pg-div')
                    .addClass(`btn-sm btn-primary`)
                    .parent().addClass('px-1')

                $('#edit .ui-pg-div')
                    .addClass('btn-sm btn-success')
                    .parent().addClass('px-1')

                $('#delete .ui-pg-div')
                    .addClass('btn-sm btn-danger')
                    .parent().addClass('px-1')

                $('#pilih .ui-pg-div')
                    .addClass(`btn-sm btn-primary`)
                    .parent().addClass('px-1')

                $('#report .ui-pg-div')
                    .addClass('btn-sm btn-info')
                    .parent().addClass('px-1')


                $('#export .ui-pg-div')
                    .addClass('btn-sm btn-warning')
                    .parent().addClass('px-1')

                    function permission() {
                if (!`{{ $myAuth->hasPermission('user', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('user', 'update') }}`) {
                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('user', 'destroy') }}`) {
                    $('#delete').attr('disabled', 'disabled')
                } }

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

                // MODAL HIDDEN, REMOVE KOTAK MERAH
                $('#rangeModal').on('hidden.bs.modal', function() {

                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                })

                $('#formRange').submit(function(event) {
                    event.preventDefault()

                    let params
                    let submitButton = $(this).find('button:submit')
                    $('#processingLoader').removeClass('d-none')

                    submitButton.attr('disabled', 'disabled')

                    /* Set params value */
                    for (var key in postData) {
                        if (params != "") {
                            params += "&";
                        }
                        params += key + "=" + encodeURIComponent(postData[key]);
                    }

                    let formRange = $('#formRange')
                    let offset = parseInt(formRange.find('[name=dari]').val()) - 1
                    let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
                    params += `&offset=${offset}&limit=${limit}`

                    getCekExport(params).then((response) => {
                        if ($('#rangeModal').data('action') == 'export') {
                            $.ajax({
                                url: `${apiUrl}user/export?${params}`,
                                type: 'GET',
                                beforeSend: function(xhr) {
                                    xhr.setRequestHeader('Authorization', `Bearer ${accessToken}`);
                                },
                                xhrFields: {
                                    responseType: 'arraybuffer'
                                },
                                success: function(response, status, xhr) {
                                    if (xhr.status === 200) {
                                        if (response !== undefined) {
                                            var blob = new Blob([response], {
                                                type: 'user/vnd.ms-excel'
                                            });
                                            var link = document.createElement('a');
                                            link.href = window.URL.createObjectURL(blob);
                                            link.download = 'user' + new Date().getTime() + '.xlsx';
                                            link.click();
                                        }
                                        $('#rangeModal').modal('hide')
                                    }
                                },
                                error: function(xhr, status, error) {
                                    $('#processingLoader').addClass('d-none')
                                    submitButton.prop('disabled',false)
                                }
                            }).always(() => {
                                $('#processingLoader').addClass('d-none')
                                submitButton.prop('disabled',false)
                            })
                        } else if ($('#rangeModal').data('action') == 'report') {
                            window.open(`{{ route('user.report') }}?${params}`)
                            submitButton.prop('disabled',false)
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
                            url: `${apiUrl}user/export?${params}`,
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
            })
        </script>
    @endpush()
@endsection

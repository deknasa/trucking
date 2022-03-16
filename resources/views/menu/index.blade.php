@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table id="jqGrid"></table>
            <div id="jqGridPager"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let indexUrl = "{{ route('menu.index') }}"
    let getUrl = "{{ route('menu.get') }}"
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
    let sortname = 'id'
    let sortorder = 'asc'

    $(document).ready(function() {
        /* Set page */
        <?php if (isset($_GET['page'])) { ?>
            page = "{{ $_GET['page'] }}"
        <?php } ?>

        /* Set id */
        <?php if (isset($_GET['id'])) { ?>
            id = "{{ $_GET['id'] }}"
        <?php } ?>

        /* Set indexRow */
        <?php if (isset($_GET['indexRow'])) { ?>
            indexRow = "{{ $_GET['indexRow'] }}"
        <?php } ?>

        /* Set sortname */
        <?php if (isset($_GET['sortname'])) { ?>
            sortname = "{{ $_GET['sortname'] }}"
        <?php } ?>

        /* Set sortorder */
        <?php if (isset($_GET['sortorder'])) { ?>
            sortorder = "{{ $_GET['sortorder'] }}"
        <?php } ?>

        $("#jqGrid").jqGrid({
                url: getUrl,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '70px'
                    },
                    {
                        label: 'NAMA MENU',
                        name: 'menuname',
                        align: 'left'
                    },
                    {
                        label: 'SEQ MENU',
                        name: 'menuseq',
                        align: 'left'
                    },

                    {
                        label: 'MENU PARENT',
                        name: 'menuparent',
                        width: 100,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combo'] as $status) :
                                        echo "$status[param]:$status[menuparent]";
                                        if ($i !== count($data['combo'])) {
                                            echo ";";
                                        }
                                        $i++;
                                    endforeach

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
                        label: 'MENU ICON',
                        name: 'menuicon',
                        align: 'left'
                    },
                    {
                        label: 'HEADER MENU',
                        name: 'aco_id',
                        align: 'left'
                    },
                    {
                        label: 'LINK',
                        name: 'link',
                        align: 'left'
                    },
                    {
                        label: 'MENU EXE',
                        name: 'menuexe',
                        align: 'left'
                    }, {
                        label: 'KODE MENU',
                        name: 'menukode',
                        align: 'left'
                    },
                    {
                        label: 'MODIFIEDBY',
                        name: 'modifiedby',
                        align: 'left'
                    },
                    {
                        label: 'UPDATEDAT',
                        name: 'updated_at',
                        align: 'right'
                    }, {
                        label: 'CREATEDAT',
                        name: 'created_at',
                        align: 'right'
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50],
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortname,
                sortorder: sortorder,
                page: page,
                pager: pager,
                viewrecords: true,
                onSelectRow: function(id) {
                    id = $(this).jqGrid('getCell', id, 'rn') - 1
                    indexRow = id
                    page = $(this).jqGrid('getGridParam', 'page')
                    let rows = $(this).jqGrid('getGridParam', 'postData').rows
                    if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
                },
                ondblClickRow: function(rowid) {

                },
                loadComplete: function(data) {
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').rows
                    postData = $(this).jqGrid('getGridParam', 'postData')

                    $('.clearsearchclass').click(function() {
                        highlightSearch = ''
                    })

                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }

                    if (triggerClick) {
                        if (id != '') {
                            indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                            $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                            id = ''
                        } else if (indexRow != undefined) {
                            $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                        }

                        if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                            $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                        }

                        triggerClick = false
                    } else {
                        $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                    }
                }
            })

            .jqGrid("navGrid", pager, {
                search: false,
                refresh: false,
                add: false,
                edit: false,
                del: false,
            })

            .navButtonAdd(pager, {
                caption: 'Add',
                title: 'Add',
                id: 'add',
                buttonicon: 'fas fa-plus',
                onClickButton: function() {
                    let limit = $(this).jqGrid('getGridParam', 'postData').rows

                    window.location.href = `{{ route('menu.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
                }
            })

            .navButtonAdd(pager, {
                caption: 'Edit',
                title: 'Edit',
                id: 'edit',
                buttonicon: 'fas fa-pen',
                onClickButton: function() {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                    window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
                }
            })

            .navButtonAdd(pager, {
                caption: 'Delete',
                title: 'Delete',
                id: 'delete',
                buttonicon: 'fas fa-trash',
                onClickButton: function() {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                    window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
                }
            })

            .navButtonAdd(pager, {
                caption: 'Resequence',
                title: 'Resequence',
                id: 'resequence',
                buttonicon: 'fas fa-sort',
                onClickButton: function() {
                    let actionUrl = `{{ route('menu.resequence') }}`
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                    window.location.href = actionUrl
                }
            })

            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {
                    clearGlobalSearch()
                },
            })

        /* Append clear filter button */
        loadClearFilter()

        /* Append global search */
        loadGlobalSearch()


        $('#add .ui-pg-div')
            .addClass(`btn-sm btn-primary`)
            .parent().addClass('px-1')

        $('#edit .ui-pg-div')
            .addClass('btn-sm btn-success')
            .parent().addClass('px-1')

        $('#delete .ui-pg-div')
            .addClass('btn-sm btn-danger')
            .parent().addClass('px-1')

        $('#resequence .ui-pg-div')
            .addClass('btn-sm btn-info')
            .parent().addClass('px-1')

        if (!`{{ $myAuth->hasPermission('menu', 'create') }}`) {
            $('#add').addClass('ui-disabled')
        }

        if (!`{{ $myAuth->hasPermission('menu', 'edit') }}`) {
            $('#edit').addClass('ui-disabled')
        }

        if (!`{{ $myAuth->hasPermission('menu', 'delete') }}`) {
            $('#delete').addClass('ui-disabled')
        }

        if (!`{{ $myAuth->hasPermission('menu', 'resequence') }}`) {
            $('#delete').addClass('ui-disabled')
        }
    })
</script>
@endpush()
@endsection
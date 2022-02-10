@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @if (@$_GET['popup']=="")
                <h1 class="m-0">{{ $title }} </h1>
                @else
                <h1 class="text-danger" class="m-0">Look Up {{ $title }} </h1>
                @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

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
    function dbclick(rowid) {
        var rowData = jQuery('#jqGrid').getRowData(rowid);
        localStorage.setItem('getUser_id', JSON.stringify(rowData));
        window.close();
    }

    $(document).ready(function() {
        let indexUrl = "{{ route('user.index') }}"
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
        popup = "<?= @$_GET['popup'] ?>" == "" ? "" : "ada";
        id = "<?= @$_GET['name'] ?>" == "" ? "undefined" : "<?= @$_GET['name'] ?>";

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
                url: indexUrl,
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
                        label: 'USER',
                        name: 'user',
                        align: 'left',
                        searchoptions: {
                            sopt: ['cn'],
                            defaultValue: "<?= @$_GET['user'] ?>"
                        }
                    },
                    {
                        label: 'NAMA USER',
                        name: 'name',
                        align: 'left'
                    },
                    {
                        label: 'DASHBOARD',
                        name: 'dashboard',
                        align: 'left'
                    },
                    {
                        label: 'ID KARYAWAN',
                        name: 'karyawan_id',
                        align: 'right'
                    },
                    {
                        label: 'Cabang',
                        name: 'cabang_id',
                        width: 100,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combocabang'] as $status) :
                                        echo "$status[param]:$status[namacabang]";
                                        if ($i !== count($data['combocabang'])) {
                                            echo ";";
                                        }
                                        $i++;
                                    endforeach

                                    ?>
            `
                        },
                    },
                    {
                        label: 'Status',
                        name: 'statusaktif',
                        width: 100,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combo'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combo'])) {
                                            echo ";";
                                        }
                                        $i++;
                                    endforeach

                                    ?>
            `
                        },
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
                    if (popup == "ada") {
                        var rowData = jQuery(this).getRowData(rowid);
                        localStorage.setItem('getUser_id', JSON.stringify(rowData));
                        window.close();
                    }
                },
                beforeRequest: function() {
                    var $requestGrid = $(this);
                    if ($requestGrid.data('areFiltersDefaulted') !== true) {
                        $requestGrid.data('areFiltersDefaulted', true);
                        setTimeout(function() {
                            $requestGrid[0].triggerToolbar();
                        }, 50);
                        return false;
                    }
                    // Subsequent runs are always allowed
                    return true;
                },



                loadComplete: function(data) {
                    console.log($(this).getGridParam('postData'));
                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').rows
                    postData = $(this).jqGrid('getGridParam', 'postData')

                    if (popup == "ada") {
                        $('#pilih').show();
                    } else {
                        $('#pilih').hide();
                    }
                    $('.clearsearchclass').click(function() {
                        highlightSearch = ''
                    })

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
                class: 'btn btn-primary',
                onClickButton: function() {
                    let limit = $(this).jqGrid('getGridParam', 'postData').rows

                    window.location.href = `{{ route('user.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
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
                caption: 'Pilih',
                title: 'Pilih',
                id: 'pilih',
                buttonicon: 'fas fa-check',
                class: 'btn btn-primary',
                onClickButton: function() {
                    var selRowId = $(this).jqGrid("getGridParam", "selrow");
                    var rowData = $(this).jqGrid("getRowData", selRowId)
                    // var rowData = jQuery(this).getRowData(rowid);
                    localStorage.setItem('getUser_id', JSON.stringify(rowData));
                    window.close();
                }
            })


            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                beforeSearch: function() {
                    clearGlobalSearch()
                }
            })

            .bindKeys() /

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

        $('#pilih .ui-pg-div')
            .addClass(`btn-sm btn-primary`)
            .parent().addClass('px-1')



    })

    /**
     * Custom Functions
     */
    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })()

    function clearColumnSearch() {
        $('input[id*="gs_"]').val("");
        $("#resetFilterOptions span#resetFilterOptions").removeClass('aktif');
        $('select[id*="gs_"]').val("");
        $("#resetdatafilter").removeClass("active");
    }

    function clearGlobalSearch() {
        $("#searchText").val("")
    }

    function loadClearFilter() {
        /* Append Button */
        $('#gsh_' + $.jgrid.jqID($('#jqGrid')[0].id) + '_rn').html(
            $("<div id='resetfilter' class='reset'><span id='resetdatafilter' class='btn btn-default'> X </span></div>")
        )

        /* Handle button on click */
        $("#resetdatafilter").click(function() {
            highlightSearch = '';

            clearGlobalSearch()
            clearColumnSearch()

            $("#jqGrid").jqGrid('setGridParam', {
                search: false,
                postData: {
                    "filters": ""
                }
            }).trigger("reloadGrid");
        })
    }

    function loadGlobalSearch() {
        /* Append global search textfield */
        $('#t_' + $.jgrid.jqID($('#jqGrid')[0].id)).html($('<form class="form-inline"><div class="form-group" id="titlesearch"><label for="searchText" style="font-weight: normal !important;">Search : </label><input type="text" class="form-control" id="searchText" placeholder="Search" autocomplete="off"></div></form>'));

        /* Handle textfield on input */
        $(document).on("input", "#searchText", function() {
            delay(function() {
                clearColumnSearch()

                var postData = $('#jqGrid').jqGrid("getGridParam", "postData"),
                    colModel = $('#jqGrid').jqGrid("getGridParam", "colModel"),
                    rules = [],
                    searchText = $("#searchText").val(),
                    l = colModel.length,
                    i,
                    cm;
                for (i = 0; i < l; i++) {
                    cm = colModel[i];
                    if (cm.search !== false && (cm.stype === undefined || cm.stype === "text" || cm.stype === "select")) {

                        rules.push({
                            field: cm.name,
                            op: "cn",
                            data: searchText.toUpperCase()
                        });
                    }
                }
                postData.filters = JSON.stringify({
                    groupOp: "OR",
                    rules: rules
                });

                $('#jqGrid').jqGrid("setGridParam", {
                    search: true
                });
                $('#jqGrid').trigger("reloadGrid", [{
                    page: 1,
                    current: true
                }]);
                return false;
            }, 500);
        });
    }
</script>
@endpush()
@endsection
@extends('layouts.master')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{ $title }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
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
  $(document).ready(function() {
    let indexUrl = "{{ route('parameter.index') }}"
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let selectID;
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'grp'
    let sortorder = 'asc'

    $("#jqGrid").jqGrid({
        url: indexUrl,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'center',
            width: '50px'
          },
          {
            label: 'GROUP',
            name: 'grp',
            align: 'center'
          },
          {
            label: 'SUBGROUP',
            name: 'subgrp',
            align: 'center'
          },
          {
            label: 'NAMA PARAMETER',
            name: 'text',
            align: 'center'
          },
          {
            label: 'MEMO',
            name: 'memo',
            align: 'center'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'center'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'center'
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
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          selectID = id
        },
        ondblClickRow: function(rowid) {

        },
        loadComplete: function(data) {
          $(`[id="` + $('#jqGrid').getDataIDs()[indexRow] + `"]`).click()
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
          window.location.href = "{{ route('parameter.create') }}"
        }
      })

      .navButtonAdd(pager, {
        caption: 'Edit',
        title: 'Edit',
        id: 'edit',
        buttonicon: 'fas fa-pen',
        onClickButton: function() {
          window.location.href = `${indexUrl}/${selectID}/edit`
        }
      })

      .navButtonAdd(pager, {
        caption: 'Delete',
        title: 'Delete',
        id: 'delete',
        buttonicon: 'fas fa-trash',
        onClickButton: function() {
          window.location.href = `${indexUrl}/${selectID}/delete`
        }
      })
  })
</script>
@endpush()
@endsection
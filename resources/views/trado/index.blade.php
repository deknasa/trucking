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
  $(document).ready(function() {
    let indexUrl = "{{ route('trado.index') }}"
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
    let sortname = 'keterangan'
    let sortorder = 'asc'

    /* Set page */
    <?php if (isset($_GET['page'])) {?>
      page = "{{ $_GET['page'] }}"
    <?php } ?>

    /* Set id */
    <?php if (isset($_GET['id'])) {?>
      id = "{{ $_GET['id'] }}"
    <?php } ?>

    /* Set indexRow */
    <?php if (isset($_GET['indexRow'])) {?>
      indexRow = "{{ $_GET['indexRow'] }}"
    <?php } ?>

    /* Set sortname */
    <?php if (isset($_GET['sortname'])) {?>
      sortname = "{{ $_GET['sortname'] }}"
    <?php } ?>

    /* Set sortorder */
    <?php if (isset($_GET['sortorder'])) {?>
      sortorder = "{{ $_GET['sortorder'] }}"
    <?php } ?>

    $("#jqGrid").jqGrid({
      url: `{{ config('app.api_url') . 'trado' }}`,
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
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'center'
          },
          {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            align: 'center'
          },
          {
            label: 'KM AWAL',
            name: 'kmawal',
            align: 'center'
          },
          {
            label: 'KM GANTI OLI AKHIR',
            name: 'kmakhirgantioli',
            align: 'center'
          },
          {
            label: 'TGL STNK MATI',
            name: 'tglmatistnk',
            align: 'center'
          },
          {
            label: 'TGL ASURANSI MATI',
            name: 'tglasuransimati',
            align: 'center'
          },
          {
            label: 'MEREK',
            name: 'merek',
            align: 'center'
          },
          {
            label: 'NO RANGKA',
            name: 'norangka',
            align: 'center'
          },
          {
            label: 'NO MESIN',
            name: 'nomesin',
            align: 'center'
          },
          {
            label: 'NAMA',
            name: 'nama',
            align: 'center'
          },
          {
            label: 'NO STNK',
            name: 'nostnk',
            align: 'center'
          },
          {
            label: 'ALAMAT STNK',
            name: 'alamatstnk',
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
          {
            label: 'TGL SERVICE OPNAME',
            name: 'tglserviceopname',
            align: 'center'
          },
          {
            label: 'STATUS STANDARISASI',
            name: 'statusstandarisasi',
            align: 'center'
          },
          {
            label: 'KET PROGRESS STANDARISASI',
            name: 'keteranganprogressstandarisasi',
            align: 'center'
          },
          {
            label: 'JENIS PLAT',
            name: 'jenisplat',
            align: 'center'
          },
          {
            label: 'TGL PAJAK STNK',
            name: 'tglpajakstnk',
            align: 'center'
          },
          {
            label: 'TGL GANTI AKI AKHIR',
            name: 'tglgantiakiterakhir',
            align: 'center'
          },
          {
            label: 'STATUS MUTASI',
            name: 'statusmutasi',
            align: 'center'
          },
          {
            label: 'STATUS VALIDASI KEND',
            name: 'statusvalidasikendaraan',
            align: 'center'
          },
          {
            label: 'TIPE',
            name: 'tipe',
            align: 'center'
          },
          {
            label: 'JENIS',
            name: 'jenis',
            align: 'center'
          },
          {
            label: 'ISI SILINDER',
            name: 'isisilinder',
            align: 'center'
          },
          {
            label: 'WARNA',
            name: 'warna',
            align: 'center'
          },
          {
            label: 'BAHAN BAKAR',
            name: 'bahanbakar',
            align: 'center'
          },
          {
            label: 'JLH SUMBU',
            name: 'jlhsumbu',
            align: 'center'
          },
          {
            label: 'JLH RODA',
            name: 'jlhroda',
            align: 'center'
          },
          {
            label: 'MODEL',
            name: 'model',
            align: 'center'
          },
          {
            label: 'BPKB',
            name: 'bpkb',
            align: 'center'
          },
          {
            label: 'STATUS MOBIL STORING',
            name: 'statusmobilstoring',
            align: 'center'
          },
          {
            label: 'MANDORID',
            name: 'mandor_id',
            align: 'center'
          },
          {
            label: 'JLH BAN SERAP',
            name: 'jlhbanserap',
            align: 'center'
          },
          {
            label: 'STATUS BAN EDIT',
            name: 'statusappeditban',
            align: 'center'
          },
          {
            label: 'STATUS LEWAT VALIDASI',
            name: 'statuslewatvalidasi',
            align: 'center'
          },
          {
            label: 'PHOTO STNK',
            name: 'photostnk',
            align: 'center'
          },
          {
            label: 'PHOTO BPKB',
            name: 'photobpkb',
            align: 'center'
          },
          {
            label: 'PHOTO TRADO',
            name: 'phototrado',
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        onSelectRow: function(id) {
          id = $(this).jqGrid('getCell', id, 'rn') - 1
          indexRow = id
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {
          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')

          $('.clearsearchclass').click(function() {
            highlightSearch = ''
          })

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
          let limit = $(this).jqGrid('getGridParam', 'postData').limit

          window.location.href = `{{ route('trado.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
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

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        beforeSearch: function() {
          clearGlobalSearch()
        }
      })

      .bindKeys()/

    /* Append clear filter button */
    loadClearFilter()

    /* Append global search */
    loadGlobalSearch()
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
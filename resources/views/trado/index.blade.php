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
      <div id="jqGridPager" class="row bg-white">
        <div id="buttonContainer" class="col-12 col-md-7 text-center text-md-left">
          <button id="add" class="btn btn-primary btn-sm mb-1">
            <i class="fa fa-plus"></i> ADD
          </button>
          <button id="edit" class="btn btn-success btn-sm mb-1">
            <i class="fa fa-pen"></i> EDIT
          </button>
          <button id="delete" class="btn btn-danger btn-sm mb-1">
            <i class="fa fa-trash"></i> DELETE
          </button>
        </div>
        <div id="pagerHandler" class="col-12 col-md-4 d-flex justify-content-center align-items-center"></div>
        <div id="pagerInfo" class="col-12 col-md-1 d-flex justify-content-end align-items-center"></div>
      </div>

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
            width: '50px'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
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
            label: 'KM AWAL',
            name: 'kmawal',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
                decimalSeparator: ',',
                thousandsSeparator: '.'
            }
          },
          {
            label: 'KM GANTI OLI AKHIR',
            name: 'kmakhirgantioli',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
                decimalSeparator: ',',
                thousandsSeparator: '.'
            }
          },
          // {
          //   label: 'TGL STNK MATI',
          //   name: 'tglmatistnk',
          //   formatter: "date",
          //   formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          // },
          {
            label: 'TGL ASURANSI MATI',
            name: 'tglasuransimati',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'MEREK',
            name: 'merek',
          },
          {
            label: 'NO RANGKA',
            name: 'norangka',
          },
          {
            label: 'NO MESIN',
            name: 'nomesin',
          },
          {
            label: 'NAMA',
            name: 'nama',
          },
          {
            label: 'NO STNK',
            name: 'nostnk',
          },
          {
            label: 'ALAMAT STNK',
            name: 'alamatstnk',
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y H:i:s" }
          },
          {
            label: 'TGL SERVICE OPNAME',
            name: 'tglserviceopname',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'STATUS STANDARISASI',
            name: 'statusstandarisasi',
          },
          {
            label: 'KET PROGRESS STANDARISASI',
            name: 'keteranganprogressstandarisasi',
          },
          {
            label: 'JENIS PLAT',
            name: 'jenisplat',
          },
          {
            label: 'TGL PAJAK STNK',
            name: 'tglpajakstnk',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'TGL GANTI AKI AKHIR',
            name: 'tglgantiakiterakhir',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'STATUS MUTASI',
            name: 'statusmutasi',
          },
          {
            label: 'STATUS VALIDASI KEND',
            name: 'statusvalidasikendaraan',
          },
          {
            label: 'TIPE',
            name: 'tipe',
          },
          {
            label: 'JENIS',
            name: 'jenis',
          },
          {
            label: 'ISI SILINDER',
            name: 'isisilinder',
          },
          {
            label: 'WARNA',
            name: 'warna',
          },
          {
            label: 'BAHAN BAKAR',
            name: 'jenisbahanbakar',
          },
          {
            label: 'JLH SUMBU',
            name: 'jlhsumbu',
          },
          {
            label: 'JLH RODA',
            name: 'jlhroda',
          },
          {
            label: 'MODEL',
            name: 'model',
          },
          {
            label: 'BPKB',
            name: 'nobpkb',
          },
          {
            label: 'STATUS MOBIL STORING',
            name: 'statusmobilstoring',
          },
          {
            label: 'MANDOR',
            name: 'mandor_id',
          },
          {
            label: 'JLH BAN SERAP',
            name: 'jlhbanserap',
          },
          {
            label: 'STATUS BAN EDIT',
            name: 'statusappeditban',
          },
          {
            label: 'STATUS LEWAT VALIDASI',
            name: 'statuslewatvalidasi',
          },
          {
            label: 'PHOTO STNK',
            name: 'photostnk',
            align: 'center',
            search: false
          },
          {
            label: 'PHOTO BPKB',
            name: 'photobpkb',
            align: 'center',
            search: false
          },
          {
            label: 'PHOTO TRADO',
            name: 'phototrado',
            align: 'center',
            search: false
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
          loadPagerHandler('#pagerHandler', $(this))
          loadPagerInfo('#pagerInfo', $(this))
          
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')

          $('.clearsearchclass').click(function() {
            clearColumnSearch()
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

          setHighlight($(this))
        }
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })

      // .navButtonAdd(pager, {
      //   caption: 'Add',
      //   title: 'Add',
      //   id: 'add',
      //   buttonicon: 'fas fa-plus',
      //   onClickButton: function() {
      //     let limit = $(this).jqGrid('getGridParam', 'postData').limit

      //     window.location.href = `{{ route('trado.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      //   }
      // })

      // .navButtonAdd(pager, {
      //   caption: 'Edit',
      //   title: 'Edit',
      //   id: 'edit',
      //   buttonicon: 'fas fa-pen',
      //   onClickButton: function() {
      //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          
      //     window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      //   }
      // })

      // .navButtonAdd(pager, {
      //   caption: 'Delete',
      //   title: 'Delete',
      //   id: 'delete',
      //   buttonicon: 'fas fa-trash',
      //   onClickButton: function() {
      //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          
      //     window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
      //   }
      // })

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
      .bindKeys()

    /* Append clear filter button */
    loadClearFilter()

    /* Append global search */
    loadGlobalSearch()


      /* Handle button add on click */
    $('#add').click(function() {
      let limit = $('#jqGrid').jqGrid('getGridParam', 'postData').limit

      window.location.href = `{{ route('trado.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
    })

    /* Handle button edit on click */
    $('#edit').click(function() {
      selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      if (selectedId == null || selectedId == '' || selectedId == undefined) {
        alert('please select a row')
      } else {
        window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      }
    })

    /* Handle button delete on click */
    $('#delete').click(function() {
      selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
    })



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
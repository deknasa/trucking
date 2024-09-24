<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-easyui bordered">
        <div class="card-header">
        </div>
        <form id="crudForm">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-12 col-sm-2 col-form-label mt-2">Bulan Job<span class="text-danger">*</span></label>
              <div class="col-sm-4 mt-2">
                <div class="input-group">
                  <input type="text" name="bulanjob" class="form-control monthpicker">
                </div>

              </div>
            </div>

            <div class="row">

              <div class="col-sm-6 mt-4">
                <a id="btnPreview" class="btn btn-primary mr-2 ">
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
</div>

<table id="orderanemklLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  initMonthpicker()

  $('[name=bulanjob]').val($.datepicker.formatDate('mm-yy', new Date())).trigger(
    'change');

  jobEmkl = $('#crudForm [name=nojobemkl]').val()
  // Promise.all([
  //   getTglJob(jobEmkl),
  //   showDefault()
  // ]).then((response) => {
  //   loadOrderanEmkl()
  // })
  $('#btnPreview').click(function(event) {
    loadOrderanEmkl()
  })
  $('#orderanemklLookup')
    .jqGrid({
      url: `${apiUrl}orderanemkl`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        container_id: `{!! $container_Id ?? '' !!}`,
        jenisorder_id: `{!! $jenisorder_Id ?? '' !!}`,
        aktif: `{!! $Aktif ?? '' !!}`,
        cabang: `{!! $cabang ?? '' !!}`,
        bulanjob: $('[name=bulanjob]').val(),
      },
      idPrefix: 'orderanemklLookup',
      colModel: [{
          label: 'NO JOB',
          name: 'nojob',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        {
          label: 'TANGGAL',
          name: 'tgl',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'NO CONTAINER',
          name: 'nocont',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'NO SEAL',
          name: 'noseal',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'NO SP FULL',
          name: 'nospfull',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true
        },
        {
          label: 'NO SP EMPTY',
          name: 'nospempty',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true
        },
        {
          label: 'JENIS ORDERAN',
          name: 'jenisorderan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'SHIPPER',
          name: 'pelanggan',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left',
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'nojob',
      sortorder: 'asc',
      page: 1,
      // pager: $('#orderanemklLookupPager'),
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
      onSelectRow: function(id) {
        activeGrid = $(this)
        id = $(this).jqGrid('getCell', id, 'rn') - 1
        indexRow = id
        page = $(this).jqGrid('getGridParam', 'page')
        let rows = $(this).jqGrid('getGridParam', 'postData').limit
        if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
      },
      loadBeforeSend: function(jqXHR) {
        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
        let isShowShipper = (`{!! $orderemklshipper ?? '' !!}`)
        if (isShowShipper == 'TIDAK') {
          $("#orderanemklLookup").jqGrid("hideCol", 'pelanggan');
        }
        changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))
          if (indexRow - 1 > $('#orderanemklLookup').getGridParam().reccount) {
            indexRow = $('#orderanemklLookup').getGridParam().reccount - 1
          }
          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#orderanemklLookup [id="${$('#orderanemklLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#orderanemklLookup [id="${$('#orderanemklLookup').getDataIDs()[indexRow]}"]`).click()
            }
            if ($('#orderanemklLookup').getDataIDs()[indexRow] == undefined) {
              $(`#orderanemklLookup [id="` + $('#orderanemklLookup').getDataIDs()[0] + `"]`).click()
            }
            triggerClick = false
          } else {
            $('#orderanemklLookup').setSelection($('#orderanemklLookup').getDataIDs()[indexRow])
          }
        }
        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')
        $('.clearsearchclass').click(function() {
          clearColumnSearch($(this))
        })
        $(this).setGridWidth($('#lookuporderanemkl').prev().width())
        setHighlight($(this))
      }
    })
    .jqGrid("setLabel", "rn", "No.")
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        abortGridLastRequest($(this))

        clearGlobalSearch($('#orderanemklLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#orderanemklLookup'))
  loadClearFilter($('#orderanemklLookup'))

  setbulanJobOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=bulanjob]').empty()
      relatedForm.find('[name=bulanjob]').append(
        new Option('-- PILIH BULAN1 JOB --', '', false, true)
      ).trigger('change')
      $.ajax({
        url: `${apiUrl}orderanemkl/getBulanJob`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(bulanJob => {
            let option = new Option(bulanJob.text, bulanJob.id)
            relatedForm.find('[name=bulanjob]').append(option).trigger('change')
          });
          resolve()
        }
      })
    })
  }

  function showDefault() {
    return new Promise(function(resolve, reject) {
      $('#lookupModal')
        .find('[name=bulanjob]')
        .val(
          $.datepicker.formatDate('mm-yy', new Date())
        )
        .trigger('change');
      let bulanJob = $('#lookupModal').find('[name=bulanjob]').val()
      $('#orderanemklLookup').jqGrid('setGridParam', {
        postData: {
          bulanjob: bulanJob,
        },
      }).trigger('reloadGrid');
      resolve('test');
    })
  }

  function getTglJob(job) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        url: `${apiUrl}orderanemkl/getTglJob`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        crossDomain: true,
        data: {
          'job': job
        },
        success: response => {
          let date = new Date(response.tgl)
          let formattedDate = date.toLocaleDateString(undefined, {
            year: 'numeric',
            month: '2-digit'
          }).replace('/', '-')
          $('[name=bulanjob]').first().val(formattedDate)
          resolve()
        },
        error: error => {
          showDialog(error.statusText)
          reject();
        }
      })
    })
  }

  function loadOrderanEmkl() {

    $('#orderanemklLookup')
      .jqGrid('setGridParam', {
        url: `${apiUrl}orderanemkl`,
        mtype: "GET",
        datatype: "json",
        postData: {
          container_id: `{!! $container_Id ?? '' !!}`,
          jenisorder_id: `{!! $jenisorder_Id ?? '' !!}`,
          aktif: `{!! $Aktif ?? '' !!}`,
          bulanjob: $('[name=bulanjob]').val(),
          proses: 'reload'
        },
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
      }).trigger('reloadGrid');
  }
</script>
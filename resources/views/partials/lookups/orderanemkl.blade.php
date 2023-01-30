<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
        </div>
        <form id="crudForm">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-12 col-sm-2 col-form-label mt-2">Bulan Job<span class="text-danger">*</span></label>
              <div class="col-sm-4 mt-2">
                <div class="input-group">
                  <input type="text" name="bulanjob" class="form-control datepicker">
                </div>

              </div>
            </div>

            <div class="row">

              <div class="col-sm-6 mt-4">
                <a id="btnPreview" class="btn btn-secondary mr-2 ">
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
<div id="orderanemklLookupPager"></div>

@push('scripts')
<script>
  $(document).ready(function() {
    // setbulanJobOptions($('#lookupModal'))

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
      .addClass("btn btn-primary").html(`
			<i class="fa fa-calendar-alt"></i>
		`);


    $('#btnPreview').click(function(event) {

      let bulan_job = $('#lookupModal').find('[name=bulanjob]').val()

      console.log(bulan_job)
      console.log('test')
      $('#orderanemklLookup').jqGrid('setGridParam', {
        postData: {
          bulanjob: bulan_job,
        },
      }).trigger('reloadGrid');



      // window.open(`{{ route('reportall.report') }}?tgl=${tanggal}&data=${data}`)
    })

    $('#orderanemklLookup').jqGrid({
        url: `{{ config('app.emkl_api_url') . 'orderanemkl' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
          container_id: `{!! $container_Id ?? '' !!}`,
          jenisorder_id: `{!! $jenisorder_Id ?? '' !!}`,
          aktif: `{!! $Aktif ?? '' !!}`,
          bulanjob: `{!! $bulan_job ?? '' !!}`,
        },
        colModel: [{
            label: 'NO JOB',
            name: 'nojob',
            align: 'left',
          },
          {
            label: 'NO CONTAINER',
            name: 'nocont',
            align: 'left'
          }, {
            label: 'NO SEAL',
            name: 'noseal',
            align: 'left'
          },
        ],
        autowidth: true,
        responsive: true,
        shrinkToFit: false,
        height: 450,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        sortname: 'id',
        sortorder: 'asc',
        page: 1,
        pager: $('#orderanemklLookupPager'),
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        loadComplete: function(data) {
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
            clearColumnSearch()
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
          clearGlobalSearch($('#orderanemklLookup'))
        },
      })

    loadGlobalSearch($('#orderanemklLookup'))
    loadClearFilter($('#orderanemklLookup'))

    const setbulanJobOptions = function(relatedForm) {
      return new Promise((resolve, reject) => {
        console.log('test');
        relatedForm.find('[name=bulanjob]').empty()
        relatedForm.find('[name=bulanjob]').append(
          new Option('-- PILIH BULAN1 JOB --', '', false, true)
        ).trigger('change')

        $.ajax({
          url: `${apiEmklUrl}orderanemkl/getBulanJob`,
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

  });
</script>
@push('scripts')
<script>
  let selectedRowsTambahan = [];

  function clearSelectedRowsTambahan() {
    selectedRowsTambahan = []

    $('#detailGrid').trigger('reloadGrid')
  }

  function selectAllRowsTambahan(id) {
    $.ajax({
      url: `${apiUrl}suratpengantarbiayatambahan`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        suratpengantar_id: $('#detailGrid').jqGrid('getGridParam', 'postData').suratpengantar_id,
        filters: $('#detailGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRowsTambahan = response.data.map((jurnal) => jurnal.id)
        $('#detailGrid').trigger('reloadGrid')
      }
    })
  }

  function checkboxHandlerTambahan(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRowsTambahan.push($(element).val())
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsTambahan.length; i++) {
        if (selectedRowsTambahan[i] == value) {
          selectedRowsTambahan.splice(i, 1);
        }
      }
    }

  }

  function loadDetailGrid() {
    let sortnameDetail = 'nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;
    $('#detailGrid')
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detailGrid',
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combotitipan'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combotitipan'])) {
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
            formatter: (value, options, rowData) => {
              if (!value) {
                return ''
              }
              let statusApprovalBiayaTambahan = JSON.parse(value)
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApprovalBiayaTambahan.WARNA}; color: #fff;">
                  <span>${statusApprovalBiayaTambahan.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statusapproval) {
                return ` title=""`
              }
              let statusApprovalBiayaTambahan = JSON.parse(rowObject.statusapproval)
              return ` title="${statusApprovalBiayaTambahan.MEMO}"`
            }
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'KETERANGAN BIAYA TAMBAHAN',
            name: 'keteranganbiaya',
            width: '200px'
          },
          {
            label: 'NOMINAL SUPIR',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'NOMINAL TAGIH',
            name: 'nominaltagih',
            align: 'right',
            formatter: currencyFormat,
          },


          {
            label: 'TGL APPROVAL',
            name: 'tglapproval',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'USER APPROVAL',
            name: 'userapproval',
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        viewrecords: true,
        postData: {
          suratpengantar_id: id
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
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))


          /* Set global variables */
          sortnameDetail = $(this).jqGrid("getGridParam", "sortname")
          sortorderDetail = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordDetail = $(this).getGridParam("records")
          limitDetail = $(this).jqGrid('getGridParam', 'postData').limit
          postDataDetail = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowDetail > $(this).getDataIDs().length - 1) {
            indexRowDetail = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominal,
              nominaltagih: data.attributes.totalNominalTagih,
            }, true)
          }

          $('#gs_detailGrid').attr('disabled', false)
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

          clearGlobalSearch($('#detailGrid'))
        },
      })
      .customPager({})

    /* Append clear filter button */
    loadClearFilter($('#detailGrid'))

    /* Append global search */
    loadGlobalSearch($('#detailGrid'))
  }


  function loadDetailData(id) {
    abortGridLastRequest($('#detailGrid'))

    $('#detailGrid').setGridParam({
      url: `${apiUrl}suratpengantarbiayatambahan`,
      datatype: "json",
      postData: {
        suratpengantar_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }

  function approveBiayaTambahan() {
    event.preventDefault()
    $.ajax({
      url: `${apiUrl}suratpengantarbiayatambahan/approval`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: selectedRowsTambahan
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')
        selectedRowsTambahan = []
        $('#detailGrid').jqGrid().trigger('reloadGrid');
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }
</script>
@endpush

@push('scripts')
<script>
  function loadStokGrid() {
    let sortnameDetail = 'namastok'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detailstok").jqGrid({
      datatype: 'local',
      data: [],
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      idPrefix: 'detail',
      colModel: [
        {
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true

        },
        {
          label: 'NAMA',
          name: 'namastok',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2
        },
        {
          label: 'Keterangan',
          name: 'keterangan',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2
        },
        {
          label: 'nama terpusat',
          name: 'namaterpusat',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'kelompok',
          name: 'kelompok',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'satuan',
          name: 'satuan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'statusban',
          name: 'statusban',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'jenistrado',
          name: 'jenistrado',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'subkelompok',
          name: 'subkelompok',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'kategori',
          name: 'kategori',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'merk',
          name: 'merk',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: false
        },

        {
          label: 'total vulkanisir',
          name: 'vulkan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'kelompok_id',
          name: 'kelompok_id',
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'statusban_id',
          name: 'statusban_id',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'vulkanplus',
          name: 'vulkanplus',
          align: 'left',
          search: false,
          hidden: false
        },
        {
          label: 'vulkanminus',
          name: 'vulkanminus',
          align: 'left',
          search: false,
          hidden: false
        },
        
        {
          label: 'Status Service Rutin',
          name: 'statusservicerutin',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          stype: 'select',
          hidden: false,
          search: false,
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'STATUS SERVICE RUTIN',
                    subgrp: 'STATUS SERVICE RUTIN'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.id,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
          formatter: (value, options, rowData) => {
            let statusService = JSON.parse(value)
            if (!statusService) {
              return ''
            }
            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusService.WARNA}; color: #fff;">
                  <span>${statusService.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusService = JSON.parse(rowObject.statusservicerutin)
            if (!statusService) {
              return ` title=" "`
            }
            return ` title="${statusService.MEMO}"`
          }
        },
        {
          label: 'service',
          name: 'servicerutin_text',
          align: 'left',
          hidden: false,
          search: false
        },

      ],
      autowidth: true,
      shrinkToFit: false,
      height: 350,
      rowNum: 10,
      rownumbers: true,
      footerrow: true,
      userDataOnFooter: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: sortnameDetail,
      sortorder: sortorderDetail,
      page: pageDetail,
      prmNames: {
        sort: 'sortIndex',
        order: 'sortOrder',
        rows: 'limit'
      },
      viewrecords: true,
      // postData: {
      //   penerimaanstokheader_id: id
      // },
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
        // console.log(id);
        let detail_id = $(`#detailstok tr#${id}`).find(`td[aria-describedby="detailstok_id"]`).attr('title') ?? '';
        // console.log(nobukti);
        
        loadSPBData(detail_id)
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
        
              // if (data.attributes) {
            //   $(this).jqGrid('footerData', 'set', {
            //     nobukti: 'Total:',
          //     total: data.attributes.totalNominal,
          //   }, true)
        // }
            
      }
    })
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        abortGridLastRequest($(this))
        
        clearGlobalSearch($('#detailstok'))
      },
    })
    .jqGrid("navGrid", pager, {
      
      search: false,
      refresh: false,
      add: false,
      edit: false,
      del: false,
    })
    
    
    /* Append clear filter button */
    loadClearFilter($('#detailstok'))
    
    /* Append global search */
    loadGlobalSearch($('#detailstok'))
  }
      

  function loadStokData(supplier_id) {
    abortGridLastRequest($('#detailstok'))
    // console.log(tradoHeader);
    $('#detailstok').setGridParam({
      url: `${apiUrl}stoks/supplier/${supplier_id}`,
      datatype: "json",
      page:1
    }).trigger('reloadGrid')
  }
  
</script>
@endpush
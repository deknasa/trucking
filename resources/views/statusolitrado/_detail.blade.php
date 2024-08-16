
@push('scripts')
<script>
  function loadDetailGrid() {
    let sortnameDetail = 'nopol'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detail").jqGrid({
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
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'trado_id',
            name: 'trado_id',
            align: 'right',
            hidden:true
          },
          
          {
            label: 'TANGGAL',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
            
          {
            label: 'stok_id',
            name: 'stok_id',
            align: 'right',
            hidden:true
          },
          {
            label: 'stok',
            name: 'namastok',
            align: 'left',
          },
          
          {
            label: 'nobukti',
            name: 'nobukti',
            align: 'left',
          },
          
          {
            label: 'QTY',
            name: 'qty',
            align: 'right',
            formatter: currencyFormat,
            width:(detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,

          },
          
          {
            label: 'keterangan',
            name: 'keterangan',
            align: 'left',
            width:(detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          },
          
          {
            label: 'urut',
            name: 'urut',
            align: 'right',
            formatter: currencyFormat,
            width:(detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,

          },
          
          {
            label: 'jarak',
            name: 'jarak',
            align: 'right',
            formatter: currencyFormat,
          },
          
          {
            label: 'selisih',
            name: 'selisih',
            align: 'right',
            formatter: currencyFormat,
          },
          
          {
            label: 'keterangantambahan',
            name: 'keterangantambahan',
            align: 'left',
            width:(detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
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
          
          clearGlobalSearch($('#detail'))
        },
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })
      .customPager({
        buttons: [{
          id: 'export_Detail',
          title: 'Export Detail',
          caption: 'Export',
          innerHTML: '<i class="fas fa-file-export"></i> EXPORT Detail',
          class: 'btn btn-warning btn-sm mr-1',
          onClick: () => {
            if (tradoHeader) {
              let status = $('#crudForm').find('[name=status]').val();
              let statustext = $('#crudForm').find('[name=status] option:selected').text();
              let dari = $('#crudForm').find('[name=dari]').val();
              let sampai = $('#crudForm').find('[name=sampai]').val();
              let trado = tradoHeaderKode
              $.ajax({
                url: `{{ route('statusolitrado.exportdetail') }}?trado_id=${tradoHeader}&status=${status}&dari=${dari}&sampai=${sampai}&trado=${trado}&statustext=${statustext}`,
                type: 'GET',
                beforeSend: function(xhr) {
                  xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                },
                xhrFields: {
                  responseType: 'arraybuffer'
                },
                success: function(response, status, xhr) {
                  if (xhr.status === 200) {
                    if (response !== undefined) {
                      var blob = new Blob([response], {
                        type: 'cabang/vnd.ms-excel'
                      });
                      var link = document.createElement('a');
                      link.href = window.URL.createObjectURL(blob);
                      link.download = 'REMINDER STATUS OLI TRADO DETAIL' + new Date().getTime() + '.xlsx';
                      link.click();
                    }
                  }
                  
                  $('#processingLoader').addClass('d-none')
                },
                error: function(xhr, status, error) {
                  $('#processingLoader').addClass('d-none')
                  showDialog('TIDAK ADA DATA')
                }
              })    
            }

           
          }
        }, 
      ]
        
      })      
            
    /* Append clear filter button */
    loadClearFilter($('#detail'))
    
    /* Append global search */
    loadGlobalSearch($('#detail'))
  }

  function loadDetailData(trado_id,status) {
    abortGridLastRequest($('#detail'))
    // console.log(tradoHeader);
    $('#detail').setGridParam({
      url: `${apiUrl}statusolitradodetail`,
      datatype: "json",
      postData: {
        trado_id: trado_id,
        status: status,
      },
      page:1
    }).trigger('reloadGrid')
  }
  
</script>
@endpush
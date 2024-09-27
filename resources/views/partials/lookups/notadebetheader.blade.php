
<table id="notaDebetHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="notaDebetHeaderLookupPager"></div> --}}

<script>
  // var sendedFilters = `{!! $filters ?? '' !!}`
  // setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('notadebetheader', 'notaDebetHeaderLookup',{
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
    })
  })

  $('#notaDebetHeaderLookup').jqGrid({
      url: `{!! $url ?? config('app.api_url')  !!}`+'notadebetheader',
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        // tgldari: $('#tgldariheaderlookup').val(),
        // tglsampai: $('#tglsampaiheaderlookup').val(),
        panjar: `{!! $Panjar ?? '' !!}`,
        agen_id: `{!! $agen_Id ?? '' !!}`,
        pelanggan_id: `{!! $pelanggan_Id ?? '' !!}`,
      },
      idPrefix: 'notaDebetHeaderLookup',
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
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'SISA PANJAR',
            name: 'nominal',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'CUSTOMER',
            name: 'agen',
            align: 'left',
          },
          {
            label: 'SHIPPER',
            name: 'pelanggan',
            align: 'left',
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            align: 'right',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
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
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#notaDebetHeaderLookupPager'),
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
        cab = `{!! $cabang ?? '' !!}`;
        if(cab == 'TNL'){
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenTnl}`)
        }else{
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        }
        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
          changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#notaDebetHeaderLookup').getGridParam().reccount) {
            indexRow = $('#notaDebetHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#notaDebetHeaderLookup [id="${$('#notaDebetHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#notaDebetHeaderLookup [id="${$('#notaDebetHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#notaDebetHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#notaDebetHeaderLookup [id="` + $('#notaDebetHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#notaDebetHeaderLookup').setSelection($('#notaDebetHeaderLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupNotaDebet').prev().width())
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

        clearGlobalSearch($('#notaDebetHeaderLookup'))
        // let currentFilters = JSON.parse($(this).jqGrid('getGridParam').postData.filters)
        // if (JSON.parse(sendedFilters).rules[0]) {
        //   currentFilters.rules.push(JSON.parse(sendedFilters).rules[0])
        //   console.log(currentFilters);
        // }else{
        //   console.log('das');
        // }

        // $(this).jqGrid('setGridParam', {
        //   postData: {
        //     filters: JSON.stringify(currentFilters),
        //   }
        // })
      },
    })
    .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })
    .customPager()
  loadGlobalSearch($('#notaDebetHeaderLookup'))
  // additionalRulesGlobalSearch(sendedFilters)

  loadClearFilter($('#notaDebetHeaderLookup'))

  
</script>


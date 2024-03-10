@include('layouts._rangeheaderlookup')
<table id="notaDebetHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="notaDebetHeaderLookupPager"></div> --}}

<script>
  // var sendedFilters = `{!! $filters ?? '' !!}`
  setRangeLookup()
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
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
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
            label: 'status approval',
            name: 'statusapproval_memo',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
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
                      grp: 'STATUS APPROVAL',
                      subgrp: 'STATUS APPROVAL'
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
                        id: row.text,
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
              if (!value) {
                return ''
              }
              let statusAktif = JSON.parse(value)
              
              let formattedValue = $(`
              <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)
              
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statusaktif) {
                return ''
              }
              let statusAktif = JSON.parse(rowObject.statusaktif)
              
              return ` title="${statusAktif.MEMO}"`
            }
          },
          {
            label: 'STATUS CETAK',  
            name: 'statuscetak_memo',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
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
                      grp: 'STATUSCETAK',
                      subgrp: 'STATUSCETAK'
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
                        id: row.text,
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
              if (!value) {
                return ''
              }
              let statusAktif = JSON.parse(value)
              
              let formattedValue = $(`
              <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)
              
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statusaktif) {
                return ''
              }
              let statusAktif = JSON.parse(rowObject.statusaktif)
              
              return ` title="${statusAktif.MEMO}"`
            }
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
            label: 'tgl lunas',
            name: 'tgllunas',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'CUSTOMER',
            name: 'agen',
            align: 'left',
          },
          {
            label: 'NO BUKTI PELUNASAN PIUTANG',
            width: 250,
            name: 'pelunasanpiutang_nobukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpelunasanpiutangheader
              let tglsampai = rowData.tglsampaiheaderpelunasanpiutangheader
              let url = "{{route('pelunasanpiutangheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'BANK',
            name: 'bank',
            align: 'left',
          },
          {
            label: 'ALAT BAYAR',
            name: 'alatbayar',
            align: 'left',
          },
          {
            label: 'NO BUKTI PENERIMAAN',
            name: 'penerimaan_nobukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpenerimaanheader
              let tglsampai = rowData.tglsampaiheaderpenerimaanheader
              let url = "{{route('penerimaanheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'user approval',
            name: 'userapproval',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL APPROVAL',
            name: 'tglapproval',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'user buka cetak',
            name: 'userbukacetak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL BUKA CETAK',
            name: 'tglbukacetak',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'posting dari',
            name: 'postingdari',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
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


@extends('layouts.master')

@section('content')

<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

@push('scripts')
<script>
  
 
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
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false
  let selectedRows = [];
  
  function checkboxHandler(element) {
      let value = $(element).val();
      if (element.checked) {
          selectedRows.push($(element).val())
      } else {
          for (var i = 0; i < selectedRows.length; i++) {
              if (selectedRows[i] == value) {
                  selectedRows.splice(i, 1);
              }
          }
      }
  }
  
  $(document).ready(function() {
    let indexUrl = `${apiUrl}listtrip`
    initLookup()


      $("#jqGrid").jqGrid({
        url: `${apiUrl}listtrip`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          hidden: true
        },

        {
          label: 'NO. BUKTI',
          name: 'nobukti',
        },
        {
          label: 'TANGGAL BUKTI',
          name: 'tglbukti',
        },
        {
          label: 'PELANGGAN',
          name: 'pelanggan_id',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
        },
        {
          label: 'DARI',
          name: 'dari_id',
        },
        {
          label: 'SAMPAI',
          name: 'sampai_id',
        },
        {
          label: 'CONTAINER',
          name: 'container_id'
        },
        // {
        //   label: 'NO CONT',
        //   name: 'nocont'
        // },
        // {
        //   label: 'NO CONT2',
        //   name: 'nocont2'
        // },
        {
          label: 'STATUS CONTAINER',
          name: 'statuscontainer_id',
        },
        {
          label: 'TRADO',
          name: 'trado_id',
        },
        {
          label: 'SUPIR',
          name: 'supir_id',
        },
        // {
        //   label: 'NOJOB',
        //   name: 'nojob',
        // },
        // {
        //   label: 'NOJOB2',
        //   name: 'nojob2',
        // },
        {
          label: 'STATUSLONGTRIP',
          name: 'statuslongtrip',
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
                    grp: 'STATUS LONGTRIP',
                    subgrp: 'STATUS LONGTRIP'
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
            let statusLongTrip = JSON.parse(value)
            if (!statusLongTrip) {
              return '';
            }
            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLongTrip.WARNA}; color: #fff;">
                  <span>${statusLongTrip.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLongTrip = JSON.parse(rowObject.statuslongtrip)
            if (!statusLongTrip) {
              return '';
            }
            return ` title="${statusLongTrip.MEMO}"`
          }
        },
        // {
        //   label: 'GAJI SUPIR',
        //   name: 'gajisupir',
        //   formatter: 'currency',
        //   formatoptions: {
        //     decimalSeparator: ',',
        //     thousandsSeparator: '.'
        //   }
        // },
        // {
        //   label: 'GAJI KENEK',
        //   name: 'gajikenek',
        //   formatter: 'currency',
        //   formatoptions: {
        //     decimalSeparator: ',',
        //     thousandsSeparator: '.'
        //   }
        // },
        {
          label: 'AGEN',
          name: 'agen_id',
        },
        {
          label: 'JENIS ORDER',
          name: 'jenisorder_id',
        },
        // {
        //   label: 'STATUS PERALIHAN',
        //   name: 'statusperalihan',
        //   stype: 'select',
        //   searchoptions: {
        //     dataInit: function(element) {
        //       $(element).select2({
        //         width: 'resolve',
        //         theme: "bootstrap4",
        //         ajax: {
        //           url: `${apiUrl}parameter/combo`,
        //           dataType: 'JSON',
        //           headers: {
        //             Authorization: `Bearer ${accessToken}`
        //           },
        //           data: {
        //             grp: 'STATUS PERALIHAN',
        //             subgrp: 'STATUS PERALIHAN'
        //           },
        //           beforeSend: () => {
        //             // clear options
        //             $(element).data('select2').$results.children().filter((index, element) => {
        //               // clear options except index 0, which
        //               // is the "searching..." label
        //               if (index > 0) {
        //                 element.remove()
        //               }
        //             })
        //           },
        //           processResults: (response) => {
        //             let formattedResponse = response.data.map(row => ({
        //               id: row.text,
        //               text: row.text
        //             }));

        //             formattedResponse.unshift({
        //               id: '',
        //               text: 'ALL'
        //             });

        //             return {
        //               results: formattedResponse
        //             };
        //           },
        //         }
        //       });
        //     }
        //   },
        //   formatter: (value, options, rowData) => {
        //     let statusPeralihan = JSON.parse(value)
        //     if (!statusPeralihan) {
        //       return '';
        //     }
        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusPeralihan.WARNA}; color: #fff;">
        //           <span>${statusPeralihan.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusPeralihan = JSON.parse(rowObject.statusperalihan)
        //     if (!statusPeralihan) {
        //       return '';
        //     }
        //     return ` title="${statusPeralihan.MEMO}"`
        //   }
        // },
        {
          label: 'TARIF',
          name: 'tarif_id',
        },
        // {
        //   label: 'NOMINAL PERALIHAN',
        //   name: 'nominalperalihan',
        //   formatter: 'currency',
        //   formatoptions: {
        //     decimalSeparator: ',',
        //     thousandsSeparator: '.'
        //   }
        // },
        // {
        //   label: 'NO SP',
        //   name: 'nosp',
        // },
        // {
        //   label: 'TANGGAL SP',
        //   name: 'tglsp',
        // },
        {
          label: 'MODIFIEDBY',
          name: 'modifiedby',
        },
          {
            label: 'CREATEDAT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
      ],
      autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: rowNum,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
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
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
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
        },
      })

      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        beforeSearch: function() {
          clearGlobalSearch($('#jqGrid'))
        }
      })

      .customPager()
      
      
      
      
      /* Append clear filter button */
      loadClearFilter($('#jqGrid'))
    
      /* Append global search */
      loadGlobalSearch($('#jqGrid'))



        

  })
  
  function initLookup() {
    $('.supir-lookup').lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $('#crudForm [name=supir_id]').first().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
        $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    supir_id: $('#crudForm').find('[name=supir_id]').val(),
                },
            }).trigger('reloadGrid');
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=supir_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        // getGaji()
      }
    })
  }
    
</script>
@endpush()
@endsection
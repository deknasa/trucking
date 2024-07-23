@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
    </div>
  </div>
</div>

<!-- Detail -->
@include('upahsupir._detail')

@include('upahsupir._modal')

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
  let sortname = 'kotasampai_id'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false
  let selectedRows = [];
  let selectedRowsUpahSupir = [];


  function checkboxHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRows.push($(element).val())
      selectedRowsUpahSupir.push($(element).parents('tr').find(`td[aria-describedby="jqGrid_kotadari_id"]`).text())
      $(element).parents('tr').addClass('bg-light-blue')


    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
          selectedRowsUpahSupir.splice(i, 1);
        }
      }
    }

  }

  function clearSelectedRows() {
    selectedRows = []
    selectedRowsUpahSupir = []
    $('#gs_check').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}upahsupir`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((upahsupir) => upahsupir.id)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }


  $(document).ready(function() {
    setTampilanIndex()

    function createColModel() {
      return [{
          label: '',
          name: 'check',
          width: 30,
          align: 'center',
          sortable: false,
          clear: false,
          stype: 'input',
          searchable: false,
          searchoptions: {
            type: 'checkbox',
            clearSearch: false,
            dataInit: function(element) {
              $(element).removeClass('form-control')
              $(element).parent().addClass('text-center')

              $(element).on('click', function() {

                $(element).attr('disabled', true)
                if ($(this).is(':checked')) {
                  selectAllRows()
                } else {
                  clearSelectedRows()
                }
              })

            }
          },
          formatter: (value, rowOptions, rowData) => {
            return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
          },
        },
        {
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'PARENT',
          name: 'parent_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'TARIF',
          name: 'tarif',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'DARI',
          name: 'kotadari_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'TUJUAN',
          name: 'kotasampai_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          align: 'left'
        },
        {
          label: 'ZONA DARI',
          name: 'zonadari_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'ZONA SAMPAI',
          name: 'zonasampai_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'JARAK',
          name: 'jarak',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'right',
        },
        {
          label: 'JARAK FULL/EMPTY',
          name: 'jarakfullempty',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'right',
        },
        {
          label: 'ZONA',
          name: 'zona_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'STATUS',
          name: 'statusaktif',
          stype: 'select',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
          label: 'STATUS UPAH ZONA',
          name: 'statusupahzona',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
          formatter: (value, options, rowData) => {
            if (!value) {
              return ''
            }
            let statusUpahZona = JSON.parse(value)

            let formattedValue = $(`
              <div class="badge" style="background-color: ${statusUpahZona.WARNA}; color: #fff;">
                <span>${statusUpahZona.SINGKATAN}</span>
              </div>
            `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            if (!rowObject.statusupahzona) {
              return ''
            }
            let statusUpahZona = JSON.parse(rowObject.statusupahzona)

            return ` title="${statusUpahZona.MEMO}"`
          }
        },
        {
          label: 'TGL MULAI BERLAKU',
          name: 'tglmulaiberlaku',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },

        {
          label: 'Keterangan',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          name: 'keterangan',
        },
        {
          label: 'STATUS POSTING TNL',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          name: 'statuspostingtnl',
          width: 230,
          stype: 'select',
          searchoptions: {
            value: `<?php
                    $i = 1;

                    foreach ($data['combopostingtnl'] as $status) :
                      echo "$status[param]:$status[parameter]";
                      if ($i !== count($data['combopostingtnl'])) {
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
            let statusPostingTnl = JSON.parse(value)
            if (!statusPostingTnl) {
              return ''
            }

            let formattedValue = $(`
              <div class="badge" style="background-color: ${statusPostingTnl.WARNA}; color: #fff;">
                <span>${statusPostingTnl.SINGKATAN}</span>
              </div>
            `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            if (!rowObject.statuspostingtnl) {
              return ` title=""`
            }
            let statusPostingTnl = JSON.parse(rowObject.statuspostingtnl)
            return ` title="${statusPostingTnl.MEMO}"`
          }
        },

        {
          label: 'MAP',
          name: 'gambar',
          align: 'center',
          search: false,
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,

          formatter: (value, row) => {
            let images = []

            if (value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                if (file == '') {
                  file = 'no-image'
                }
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src =
                  `${apiUrl}upahsupir/${encodeURI(file)}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            } else {
              let image = new Image()
              image.width = 25
              image.height = 25
              image.src = `${apiUrl}upahsupir/no-image/small`
              return image.outerHTML
            }
          }
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
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatter: "date",
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
      ];
    }

    function getSavedColumnOrder() {
      return JSON.parse(localStorage.getItem(`tas${window.location.href}`));
    }
    // Menyimpan urutan kolom ke local storage
    function saveColumnOrder() {
      var colOrder = $("#jqGrid").jqGrid("getGridParam", "colModel").map(function(col) {
        return col.name;
      });
      localStorage.setItem(`tas${window.location.href}`, JSON.stringify(colOrder));
    }
    // Mengatur ulang urutan colModel berdasarkan urutan yang disimpan
    function reorderColModel(colModel, colOrder) {
      if (!colOrder) return colModel;
      var orderedColModel = [];
      colOrder.forEach(function(colName) {
        var col = colModel.find(function(c) {
          return c.name === colName;
        });
        if (col) orderedColModel.push(col);
      });
      return orderedColModel;
    }
    var colModel = createColModel();
    var savedColOrder = getSavedColumnOrder();
    var orderedColModel = reorderColModel(colModel, savedColOrder);



    $("#jqGrid").jqGrid({
        url: `${apiUrl}upahsupir`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: orderedColModel,
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        ajaxRowOptions: {
          async: false,
        },
        onSelectRow: function(id) {
          activeGrid = $(this)

          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          if (!hasDetail) {
            loadDetailGrid(id)
            hasDetail = true
          }

          loadDetailData(id)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            abortGridLastRequest($('#detail'))
            clearGridData($('#detail'))
            $('#jqGrid').each((index, element) => {
              abortGridLastRequest($(element))
              clearGridHeader($(element))
            })
          }

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))
          $.each(selectedRows, function(key, value) {

            $('#jqGrid tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).find(`td input:checkbox`).prop('checked', true)
                $(this).addClass('bg-light-blue')
              }
            })

          });

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
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
              $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
          }

          $('#left-nav').find('button').attr('disabled', false)
          permission()
          $('#gs_check').attr('disabled', false)
          setHighlight($(this))
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
          $('#jqGrid').setGridParam({
            postData: {
              proses: "page"
            }
          })
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn add btn-primary btn-sm mr-1',
            onClick: () => {
              createUpahSupir()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasidelete(selectedId, 'EDIT')
              }
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn delete btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasidelete(selectedId, 'DELETE')
              }
            }
          },
          {
            id: 'view',
            innerHTML: '<i class="fa fa-eye"></i> VIEW',
            class: 'btn btn-orange btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                viewUpahSupir(selectedId)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              // if (selectedId == null || selectedId == '' || selectedId == undefined) {
              //   showDialog('Harap pilih salah satu record')
              // } else {
              //   window.open(`{{ route('upahsupir.report') }}?id=${selectedId}`)
              // }

              $('#formRangeTgl').data('action', 'report')
              $('#rangeTglModal').find('button:submit').html(`Report`)
              $('#rangeTglModal').modal('show')
            }
          },
          {
            id: 'export',
            title: 'Export',
            caption: 'Export',
            innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              // if (selectedId == null || selectedId == '' || selectedId == undefined) {
              //   showDialog('Harap pilih salah satu record')
              // } else {
              //   window.open(`{{ route('upahsupir.export') }}?id=${selectedId}`)
              // }
              $('#formRangeTgl').data('action', 'export')
              $('#rangeTglModal').find('button:submit').html(`Export`)
              $('#rangeTglModal').modal('show')
            }
          },
          {
            id: 'import',
            innerHTML: '<i class="fas fa-file-upload"></i> IMPORT',
            class: 'btn btn-purple btn-sm mr-1',
            onClick: () => {
              // $('#importModal').data('action', 'import')
              $('#importModal').find('button:submit').html(`Import`)
              $('#importModal').modal('show')
            }
          },
        ],
        modalBtnList: [{
          id: 'approve',
          title: 'Approve',
          caption: 'Approve',
          innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
          class: 'btn btn-purple btn-sm mr-1 ',
          item: [{
              id: 'approval',
              text: "APPROVAL AKTIF",
              color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('upahsupir', 'approvalaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('upahsupir', 'approvalaktif') }}`) {
                  approvalAktif('upahsupir')

                }
              }
            },
            {
              id: 'approveun',
              text: "APPROVAL NON AKTIF",
              color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('upahsupir', 'approvalnonaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('upahsupir', 'approvalnonaktif') }}`) {
                  approvalNonAktif('upahsupir')
                }
              }
            },

          ],
        }]
      })
    $("thead tr.ui-jqgrid-labels").sortable({
      stop: function(event, ui) {
        saveColumnOrder();
        console.log("Column order updated!");
      }
    });

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

    $('#add .ui-pg-div')
      .addClass(`btn-sm btn-primary`)
      .parent().addClass('px-1')

    $('#edit .ui-pg-div')
      .addClass('btn-sm btn-success')
      .parent().addClass('px-1')

    $('#delete .ui-pg-div')
      .addClass('btn-sm btn-danger')
      .parent().addClass('px-1')

    $('#report .ui-pg-div')
      .addClass('btn-sm btn-info')
      .parent().addClass('px-1')

    $('#export .ui-pg-div')
      .addClass('btn-sm btn-warning')
      .parent().addClass('px-1')

    $('#importModal').on('shown.bs.modal', function() {
      $('#formImport [name]:not(:hidden)').first().focus()
    })

    function permission() {

      if (cabangTnl == 'YA') {
        $('#add').attr('disabled', 'disabled')
        $('#edit').attr('disabled', 'disabled')
        $('#delete').attr('disabled', 'disabled')
      } else {
        if (!`{{ $myAuth->hasPermission('upahsupir', 'store') }}`) {
          $('#add').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('upahsupir', 'update') }}`) {
          $('#edit').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('upahsupir', 'destroy') }}`) {
          $('#delete').attr('disabled', 'disabled')
        }

      }
      if (!`{{ $myAuth->hasPermission('upahsupir', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('upahsupir', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('upahsupir', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('upahsupir', 'import') }}`) {
        $('#import').attr('disabled', 'disabled')
      }

      let hakApporveCount = 0;

      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('upahsupir', 'approvalaktif') }}`) {
        hakApporveCount--
        $('#approval').hide()
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('upahsupir', 'approvalnonaktif') }}`) {
        hakApporveCount--
        $('#approveun').hide()
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
      }
    }

    $('#rangeTglModal').on('shown.bs.modal', function() {


      initDatepicker()

      $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
      $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $('#formRangeTgl').submit(event => {
      event.preventDefault()

      getCekExport()
        .then((response) => {
          if ($('#formRangeTgl').data('action') == 'export') {
            actionUrl = `{{ route('upahsupir.export') }}`
          } else {
            actionUrl = `{{ route('upahsupir.report') }}`
          }

          /* Clear validation messages */
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()


          window.open(`${actionUrl}?${$('#formRangeTgl').serialize()}`)
        })
        .catch((error) => {

          setErrorMessages($('#formRangeTgl'), error.responseJSON.errors);
        })
    })

    function getCekExport() {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}upahsupir/export`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: {
            dari: $('#formRangeTgl').find('[name=dari]').val(),
            sampai: $('#formRangeTgl').find('[name=sampai]').val()
          },
          success: (response) => {
            resolve(response);
          },
          error: error => {
            reject(error)

          },
        });
      });
    }



    $('#btnImport').click(function(event) {
      event.preventDefault()

      let url = `${apiUrl}upahsupir/import`
      let form_data = new FormData(document.getElementById('formImport'))
      let form = $('#formImport')

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: form_data,
        success: response => {
          var kondisi = response.kondisi
          console.log(kondisi)
          if (kondisi == false) {
            $('#formImport').trigger('reset')
            $('#importModal').modal('hide')
            $('#jqGrid').jqGrid().trigger('reloadGrid');

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
          } else {

            showDialog(response.message['keterangan'])
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })

    $('#rangeModal').on('shown.bs.modal', function() {
      if (autoNumericElements.length > 0) {
        $.each(autoNumericElements, (index, autoNumericElement) => {
          autoNumericElement.remove()
        })
      }

      $('#formRange [name]:not(:hidden)').first().focus()

      $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
      $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
      if (page == 0) {
        $('#formRange [name=dari]').val(page)
        $('#formRange [name=sampai]').val(totalRecord)
      } else {
        $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
        $('#formRange [name=sampai]').val(totalRecord)
      }

      autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
        digitGroupSeparator: ',',
        decimalCharacter: '.',
        decimalPlaces: 0,
        allowDecimalPadding: false,
        minimumValue: 1,
        maximumValue: totalRecord
      })
    })

    $('#formRange').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``

      if ($('#rangeModal').data('action') == 'export') {
        actionUrl = `{{ route('upahsupir.export') }}`
      } else if ($('#rangeModal').data('action') == 'report') {
        actionUrl = `{{ route('upahsupir.report') }}`
      }

      /* Clear validation messages */
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()

      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
    })
  })

  const setTampilanIndex = function() {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'UBAH TAMPILAN'
      })
      data.push({
        name: 'text',
        value: 'UPAHSUPIR'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparambytext`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          memo = JSON.parse(response.memo)
          memo = memo.INPUT
          if (memo != '') {
            input = memo.split(',');
            input.forEach(field => {
              field = field.toLowerCase();
              $(`.${field}`).hide()
              $("#jqGrid").jqGrid("hideCol", field);
            });
          }

        }
      })
    })
  }
</script>
@endpush()
@endsection
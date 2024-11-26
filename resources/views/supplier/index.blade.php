@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12">
      <table id="detailstok"></table>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <table id="detailSPB"></table>
    </div>
  </div>
  

</div>

</div>
</div>

@include('supplier._modal')
@include('supplier._detailstok')
@include('supplier._detailSPB')

@push('scripts')
<script>
  let indexRow = 0;
  let page = 1;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let masterSupplierId =""
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let limit
  let postData
  let sortname = 'namasupplier'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let selectedRows = [];
  let selectedRowsSupplier = [];

  function checkboxHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRows.push($(element).val())
      selectedRowsSupplier.push($(element).parents('tr').find(`td[aria-describedby="jqGrid_namasupplier"]`).text())
      $(element).parents('tr').addClass('bg-light-blue')


    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
          selectedRowsSupplier.splice(i, 1);
        }
      }
    }

  }



  $(document).ready(function() {
    loadStokGrid()
    loadSPBGrid()
    // setTampilanIndex()
    $("#jqGrid").jqGrid({
        url: `${apiUrl}supplier`,
        mtype: "GET",
        styleUI: 'Bootstrap4', 
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
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
              // console.log(value, rowOptions, rowData);
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
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;
                      foreach ($data['comboapproval'] as $status) :
                        // dd($data, $data['comboapproval'], $status, $status['param'], $status['parameter']);
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboapproval'])) {
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
              // console.log(value, options, rowData);
              let statusApproval = JSON.parse(value)

              if (statusApproval == null) {
                return '';
              }

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; 
                // color: #ffc0cb;
                color: #fff;
                ">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              // console.log(rowId, value, rowObject);
              
              let statusApproval = JSON.parse(rowObject.statusapproval)
              if (statusApproval == null) {
                return '';
              }
              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'nama supplier',
            name: 'namasupplier',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'nama kontak',
            name: 'namakontak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: 'alamat',
            name: 'alamat',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
          },

          {
            label: 'kota',
            name: 'kota',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'kode pos',
            name: 'kodepos',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          },
          {
            label: 'NO TELEPON/HANDPHONE (1)',
            name: 'notelp1',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: 'NO TELEPON/HANDPHONE (2)',
            name: 'notelp2',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: 'email',
            name: 'email',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },

          {
            label: 'web',
            name: 'web',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'nama pemilik',
            name: 'namapemilik',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: 'jenis usaha',
            name: 'jenisusaha',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          // {
          //   label: 'top',
          //   name: 'top',
          // },
          {
            label: 'bank',
            name: 'bank',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'rekening bank',
            name: 'rekeningbank',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },

          {
            label: 'jabatan',
            name: 'jabatan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'keterangan',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'syarat pembayaran',
            name: 'top',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'status daftar harga',
            name: 'statusdaftarharga',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combodaftarharga'] as $status) :
                        // dd($data, $data['combodaftarharga'], $data['comboaktif']);
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combodaftarharga'])) {
                          echo ";";
                        }
                        $i++;
                      endforeach
                      ?>`,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusDaftarHarga = JSON.parse(value)
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusDaftarHarga.WARNA}; color: #fff;">
                  <span>${statusDaftarHarga.SINGKATAN}</span>
                </div>
              `)
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusDaftarHarga = JSON.parse(rowObject.statusdaftarharga)
              return ` title="${statusDaftarHarga.MEMO}"`
            }
          },
          {
            label: 'status aktif',
            name: 'statusaktif',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;
                      foreach ($data['comboaktif'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboaktif'])) {
                          echo ';';
                        }
                        $i++;
                      endforeach;
                      ?>`,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusAktif = JSON.parse(value)
              
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                  <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusAktif = JSON.parse(rowObject.statusaktif)
              return ` title="${statusAktif.MEMO}"`
            }
          },
          {
            label: 'kategori usaha',
            name: 'kategoriusaha',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },

          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
          // console.log(jqXHR);
          
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        }, 
        onSelectRow: function(id) {
          activeGrid = $(this)
          
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
//           loadStokGrid
// loadSPBGrid
          loadStokData(id)
          masterSupplierId = id
        },
        loadComplete: function(data) {
          // console.log(data);
          
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#jqGrid').each((index, element) => {
              // console.log(index, element);
              
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
          $('#left-nav').find('button').attr('disabled', false)
          $('#gs_check').prop('disabled', false)
          permission()
          setHighlight($(this))
        },
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
              createSupplier()
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
                cekValidasidelete(selectedId, 'edit')
                // editSupplier(selectedId)
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
                cekValidasidelete(selectedId, 'delete')
              }
            }
          },
          {
            id: 'view',
            innerHTML: '<i class="fa fa-eye"></i> VIEW',
            class: 'btn btn-orange btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              viewSupplier(selectedId)
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              $('#rangeModal').data('action', 'report')
              $('#rangeModal').find('button:submit').html(`Report`)
              $('#rangeModal').modal('show')
            }
          },
          {
            id: 'export',
            innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              $('#rangeModal').data('action', 'export')
              $('#rangeModal').find('button:submit').html(`Export`)
              $('#rangeModal').modal('show')
            }
          },

        ],
        modalBtnList: [{
          id: 'approve',
          title: 'Approve',
          caption: 'Approve',
          innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
          class: 'btn btn-purple btn-sm mr-1',
          item: [{
              id: 'approveun',
              text: "APPROVAL/UN Data",
              color: `<?php echo $data['listbtn']->btn->approvaldata; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('supplier', 'approval') }}`),
              onClick: () => {

                if (`{{ $myAuth->hasPermission('supplier', 'approval') }}`) {
                  approve()
                }
              }
            },
            {
              id: 'approvalaktif',
              text: "APPROVAL AKTIF",
              color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('supplier', 'approvalaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('supplier', 'approvalaktif') }}`) {
                  approvalAktif('supplier')

                }
              }
            },
            {
              id: 'approvalnonaktif',
              text: "Approval Non Aktif",
              color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('supplier', 'approvalnonaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('supplier', 'approvalnonaktif') }}`) {
                  approvenonaktif('supplier')
                }

              }
            },

          ],
        }]
      })

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

    function permission() {

      if (cabangTnl == 'YA') {
        $('#add').attr('disabled', 'disabled')
        $('#edit').attr('disabled', 'disabled')
        $('#delete').attr('disabled', 'disabled')
      } else {
        if (!`{{ $myAuth->hasPermission('supplier', 'store') }}`) {
          $('#add').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('supplier', 'update') }}`) {
          $('#edit').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('supplier', 'destroy') }}`) {
          $('#delete').attr('disabled', 'disabled')
        }

      }

      if (!`{{ $myAuth->hasPermission('supplier', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }


      if (!`{{ $myAuth->hasPermission('supplier', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('supplier', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('supplier', 'approval') }}`) {
        $('#approval').addClass('ui-disabled')
      }

      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('supplier', 'approval') }}`) {
        hakApporveCount--
        $('#approveun').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('upahsupir', 'approvalaktif') }}`) {
        hakApporveCount--
        $('#approvalaktif').hide()
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('supplier', 'approvalnonaktif') }}`) {
        hakApporveCount--
        $('#approvalnonaktif').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
      }

    }
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
        maximumValue: totalRecord,
      })
    })

    $('#rangeModal').on('hidden.bs.modal', function() {

      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()
    })

    $('#formRange').submit(function(event) {
      event.preventDefault()

      let params
      let submitButton = $(this).find('button:submit')

      submitButton.attr('disabled', 'disabled')
      $('#processingLoader').removeClass('d-none')

      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      let formRange = $('#formRange')
      let offset = parseInt(formRange.find('[name=dari]').val()) - 1
      let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
      params += `&offset=${offset}&limit=${limit}`


      getCekExport(params).then((response) => {
          if ($('#rangeModal').data('action') == 'export') {
            $.ajax({
              url: `${apiUrl}supplier/export?${params}`,
              type: 'GET',
              beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', `Bearer ${accessToken}`);
              },
              xhrFields: {
                responseType: 'arraybuffer'
              },
              success: function(response, status, xhr) {
                if (xhr.status === 200) {
                  if (response !== undefined) {
                    var blob = new Blob([response], {
                      type: 'supplier/vnd.ms-excel'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'supplier' + new Date().getTime() + '.xlsx';
                    link.click();
                  }
                  $('#rangeModal').modal('hide')
                }
              },
              error: function(xhr, status, error) {
                $('#processingLoader').addClass('d-none')
                submitButton.prop('disabled', false)
              }
            }).always(() => {
              $('#processingLoader').addClass('d-none')
              submitButton.prop('disabled', false)
            })
          } else if ($('#rangeModal').data('action') == 'report') {
            window.open(`{{ route('supplier.report') }}?${params}`)
            submitButton.prop('disabled', false)
            $('#processingLoader').addClass('d-none')
            $('#rangeModal').modal('hide')
          }

        })
        .catch((error) => {

          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            errors = error.responseJSON.errors

            $.each(errors, (index, error) => {
              let indexes = index.split(".");
              indexes[0] = 'sampai'
              let element;
              element = $('#rangeModal').find(`[name="${indexes[0]}"]`)[0];

              $(element).addClass("is-invalid");
              $(`
              <div class="invalid-feedback">
              ${error[0].toLowerCase()}
              </div>
			    `).appendTo($(element).parent());

            });

            $(".is-invalid").first().focus();
            $('#processingLoader').addClass('d-none')
          } else {
            showDialog(error.statusText)
          }
        })
        .finally(() => {
          $('.ui-button').click()

          submitButton.removeAttr('disabled')
        })
    })


    function handleApproval(id) {
      $.ajax({
        url: `${apiUrl}supplier/${id}/approval`,
        method: 'POST',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        success: response => {
          $('#jqGrid').trigger('reloadGrid')
        }
      }).always(() => {
        $('#processingLoader').addClass('d-none')
      })
    }

    function clearSelectedRows() {
      selectedRows = []

      $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
      $.ajax({
        url: `${apiUrl}supplier`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: (response) => {
          selectedRows = response.data.map((supplier) => supplier.id)
          $('#jqGrid').trigger('reloadGrid')
        }
      })
    }


    function getCekExport(params) {


      params += `&cekExport=true`

      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}supplier/export?${params}`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
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
        value: 'SUPPLIER'
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
              field = $.trim(field.toLowerCase());
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
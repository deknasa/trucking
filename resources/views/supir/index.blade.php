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

@include('supir._modal')

@push('scripts')
<script>
  let indexUrl = "{{ route('supir.index') }}"
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
  let sortname = 'namasupir'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  var statusTidakBolehLuarkota;
  var statusBukanBlackList;

  $(document).ready(function() {
    $("#jqGrid").jqGrid({
        url: `${apiUrl}supir`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            width: '50px',
            hidden: true
          },
          {
            label: 'NAMA',
            name: 'namasupir',
          },
          {
            label: 'TGL LAHIR',
            name: 'tgllahir',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'ALAMAT',
            name: 'alamat',
          },
          {
            label: 'KOTA',
            name: 'kota',
          },
          {
            label: 'TELP',
            name: 'telp',
          },
          {
            label: 'STATUS',
            name: 'statusaktif',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statusaktif'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusaktif'])) {
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
              let statusAktif = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: #fff;">
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
            label: 'NOM. DEPOSIT SALDO AWAL',
            name: 'nominaldepositsa',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'DEPOSIT KE',
            name: 'depositke',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'NOM. PINJ SALDO AWAL',
            name: 'nominalpinjamansaldoawal',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'SUPIR LAMA',
            name: 'supirold_id',
          },
          {
            label: 'SIM',
            name: 'nosim',
          },
          {
            label: 'TGL EXP SIM',
            name: 'tglexpsim',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL TERBIT SIM',
            name: 'tglterbitsim',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'KTP',
            name: 'noktp',
          },
          {
            label: 'KK',
            name: 'nokk',
          },
          // {
          //   label: 'UPDATE GBR',
          //   name: 'statusadaupdategambar',
          //   stype: 'select',
          //   searchoptions: {
          //     value: `<?php
          //             $i = 1;

          //             foreach ($data['statusadaupdategambar'] as $status) :
          //               echo "$status[param]:$status[parameter]";
          //               if ($i !== count($data['statusadaupdategambar'])) {
          //                 echo ";";
          //               }
          //               $i++;
          //             endforeach

          //             ?>
          // `,
          //     dataInit: function(element) {
          //       $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //       });
          //     }
          //   },
          //   formatter: (value, options, rowData) => {
          //     let statusAdaupdategambar = JSON.parse(value)

          //     let formattedValue = $(`
          //       <div class="badge" style="background-color: ${statusAdaupdategambar.WARNA}; color: #fff;">
          //         <span>${statusAdaupdategambar.SINGKATAN}</span>
          //       </div>
          //     `)

          //     return formattedValue[0].outerHTML
          //   },
          //   cellattr: (rowId, value, rowObject) => {
          //     let statusAdaupdategambar = JSON.parse(rowObject.statusadaupdategambar)

          //     return ` title="${statusAdaupdategambar.MEMO}"`
          //   }
          // },
          // {
          //   label: 'LUAR KOTA',
          //   name: 'statusluarkota',
          //   stype: 'select',
          //   searchoptions: {
          //     value: `<?php
          //             $i = 1;

          //             foreach ($data['statusluarkota'] as $status) :
          //               echo "$status[param]:$status[parameter]";
          //               if ($i !== count($data['statusluarkota'])) {
          //                 echo ";";
          //               }
          //               $i++;
          //             endforeach

          //             ?>
          // `,
          //     dataInit: function(element) {
          //       $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //       });
          //     }
          //   },
          //   formatter: (value, options, rowData) => {
          //     let statusLuarkota = JSON.parse(value)

          //     let formattedValue = $(`
          //       <div class="badge" style="background-color: ${statusLuarkota.WARNA}; color: #fff;">
          //         <span>${statusLuarkota.SINGKATAN}</span>
          //       </div>
          //     `)

          //     return formattedValue[0].outerHTML
          //   },
          //   cellattr: (rowId, value, rowObject) => {
          //     let statusLuarkota = JSON.parse(rowObject.statusluarkota)

          //     return ` title="${statusLuarkota.MEMO}"`
          //   }
          // },
          // {
          //   label: 'ZONA TERTENTU',
          //   name: 'statuszonatertentu',
          //   stype: 'select',
          //   searchoptions: {
          //     value: `<?php
          //             $i = 1;

          //             foreach ($data['statuszonatertentu'] as $status) :
          //               echo "$status[param]:$status[parameter]";
          //               if ($i !== count($data['statuszonatertentu'])) {
          //                 echo ";";
          //               }
          //               $i++;
          //             endforeach

          //             ?>
          // `,
          //     dataInit: function(element) {
          //       $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //       });
          //     }
          //   },
          //   formatter: (value, options, rowData) => {
          //     let statusZonatertentu = JSON.parse(value)

          //     let formattedValue = $(`
          //       <div class="badge" style="background-color: ${statusZonatertentu.WARNA}; color: #fff;">
          //         <span>${statusZonatertentu.SINGKATAN}</span>
          //       </div>
          //     `)

          //     return formattedValue[0].outerHTML
          //   },
          //   cellattr: (rowId, value, rowObject) => {
          //     let statusZonatertentu = JSON.parse(rowObject.statuszonatertentu)

          //     return ` title="${statusZonatertentu.MEMO}"`
          //   }
          // },
          // {
          //   label: 'ZONA',
          //   name: 'zona_id',
          // },
          {
            label: 'angsuranpinjaman',
            name: 'angsuranpinjaman',
          },
          {
            label: 'plafondeposito',
            name: 'plafondeposito',
          },
          {
            label: 'PHOTO SUPIR',
            name: 'photosupir',
            search: false,
            align: 'center',
            formatter: (value, row) => {
              let images = []
              if(value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/supir/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
              return 'NO PHOTOS'
            }
          },
          {
            label: 'PHOTO KTP',
            name: 'photoktp',
            align: 'center',
            search: false,
            formatter: (value, row) => {
              let images = []
              if(value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/ktp/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
              return 'NO PHOTOS'
            }
          },
          {
            label: 'PHOTO SIM',
            name: 'photosim',
            align: 'center',
            search: false,
            formatter: (value, row) => {
              let images = []
              if(value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/sim/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
              return 'NO PHOTOS'
            }
          },
          {
            label: 'PHOTO KK',
            name: 'photokk',
            align: 'center',
            search: false,
            formatter: (value, row) => {
              let images = []
              if(value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/kk/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
              return 'NO PHOTOS'
            }
          },
          {
            label: 'PHOTO SKCK',
            name: 'photoskck',
            search: false,
            align: 'center',
            formatter: (value, row) => {
              let images = []
              if(value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/skck/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
              }
              return 'NO PHOTOS'
            }
          },
          {
            label: 'PHOTO DOMISILI',
            name: 'photodomisili',
            search: false,
            align: 'center',
            formatter: (value, row) => {
              let images = []
              if (value) {
                let files = JSON.parse(value)

                files.forEach(file => {
                  let image = new Image()
                  image.width = 25
                  image.height = 25
                  image.src = `${apiUrl}supir/image/domisili/${file}/small`

                  images.push(image.outerHTML)
                });

                return images.join(' ')
              }
              return 'NO PHOTOS'
            }
          },
          // {
          //   label: 'TGL BERHENTI SUPIR',
          //   name: 'tglberhentisupir',
          //   formatter: "date",
          //   formatoptions: {
          //     srcformat: "ISO8601Long",
          //     newformat: "d-m-Y"
          //   }
          // },
          // {
          //   label: 'KET RESIGN',
          //   name: 'keteranganresign',
          // },
          // {
          //   label: 'STATUS BLACKLIST',
          //   name: 'statusblacklist',
          //   stype: 'select',
          //   searchoptions: {
          //     value: `<?php
          //             $i = 1;

          //             foreach ($data['statusblacklist'] as $status) :
          //               echo "$status[param]:$status[parameter]";
          //               if ($i !== count($data['statusblacklist'])) {
          //                 echo ";";
          //               }
          //               $i++;
          //             endforeach

          //             ?>
          // `,
          //     dataInit: function(element) {
          //       $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //       });
          //     }
          //   },
          //   formatter: (value, options, rowData) => {
          //     let statusBlacklist = JSON.parse(value)

          //     let formattedValue = $(`
          //       <div class="badge" style="background-color: ${statusBlacklist.WARNA}; color: #fff;">
          //         <span>${statusBlacklist.SINGKATAN}</span>
          //       </div>
          //     `)

          //     return formattedValue[0].outerHTML
          //   },
          //   cellattr: (rowId, value, rowObject) => {
          //     let statusBlacklist = JSON.parse(rowObject.statusblacklist)

          //     return ` title="${statusBlacklist.MEMO}"`
          //   }
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
        rowList: [10, 20, 50],
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
            clearColumnSearch()
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
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: () => {
              createSupir()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

              editSupir(selectedId)
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasidelete(selectedId)
              }
             
            }
          },
        ],
        approveBtn:[{
          id: 'approve',
          title: 'Approve',
          caption: 'Approve',
          innerHTML: '<i class="fa fa-check"></i> APPROVE',
          class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
          dropmenuHTML: [
            {
              id:'approvalBlackListSupir',
              text:"Approval Black List Supir",
              onClick: () => {
                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                approvalBlackListSupir(selectedId)
              }
            },
            {
              id:'approvalSupirLuarKota',
              text:"Approval Supir Luar Kota",
              onClick: () => {
                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                approvalSupirLuarKota(selectedId)
              }
            },
            {
              id:'approvalSupirResign',
              text:"Approval Supir Resign",
              onClick: () => {
                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                approvalSupirResign(selectedId)
                
              }
            },
          ]
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

    if (!`{{ $myAuth->hasPermission('supir', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('supir', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('supir', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    getTidakBolehLuarkota()
    getBukanBlackList()
    $('#tglModal').on('shown.bs.modal', function(id) {
      $('#tglModal [name]:not(:hidden)').first().focus()
      initDatepicker()
      $('#tglModal').find('[name=tgl]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    })

    $('#tglModal').submit(event => {
      event.preventDefault()
      let form = $('#formTgl')
      let id = form.find('[name=id]').val()
      let url = `${apiUrl}supir/${id}/approvalresign`

      $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        data: {tanggalberhenti:form.find('[name=tgl]').val()},
         headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $('#tglModal').trigger('reset')
          $('#tglModal').modal('hide')
          id = response.data.id          
        },
        error: error => {
          console.error(error);
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            setErrorMessages(form, error.responseJSON.errors);
          }
        }
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
      $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
      $('#formRange [name=sampai]').val(totalRecord)

      autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        allowDecimalPadding: false,
        minimumValue: 1,
        maximumValue: totalRecord
      })
    })

    $('#formRange').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``

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


    function approvalBlackListSupir(supirId){
      
      $.ajax({
        url: `${apiUrl}supir/${supirId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let msg = `YAKIN approved Black List Supir ${response.data.namasupir}`
          if (response.data.statusblacklist === statusBukanBlackList) {
            msg = `YAKIN Unapproved Black List Supir ${response.data.namasupir}`
          }
          showConfirm(msg,"",`supir/${response.data.id}/approvalblacklist`)
        },
      })
    }
    function approvalSupirLuarKota(supirId){
      $.ajax({
        url: `${apiUrl}supir/${supirId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          console.log(statusTidakBolehLuarkota);
          let msg = ` YAKIN approved STATUS Luar Kota Supir ${response.data.namasupir} ?`
          if (response.data.statusluarkota === statusTidakBolehLuarkota) {
            msg = `YAKIN UNapproved STATUS Luar Kota Supir ${response.data.namasupir} ?`
          }
          showConfirm(msg,"",`supir/${response.data.id}/approvalluarkota`)
        },
      })
    }
    function approvalSupirResign(supirId){
      $.ajax({
        url: `${apiUrl}supir/${supirId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if (response.data.tglberhentisupir == "1900-01-01") {
            $('#tglModal').find('button:submit').html(`Approve Resign`)
            $('#tglModal').find('label').html(`Tgl Supir Resign`)
            $('#tglModalLabel').html(`PILIH TANGGAL Supir Resign`)
                $('#tglModal').find('[name=id]').val(`${selectedId}`)
                $('#tglModal').modal('show')
          }else{
            showConfirm("unapproval Supir Resign",response.data.namasupir,`supir/${response.data.id}/approvalresign`)
          }
        },
      })
    }
    
  })
  function getTidakBolehLuarkota() {
    
    $.ajax({
      url: `${apiUrl}parameter`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        filters: JSON.stringify({
          "groupOp": "AND",
          "rules": [{
            "field": "grp",
            "op": "cn",
            "data": "STATUS LUAR KOTA"
          },{
            "field": "text",
            "op": "cn",
            "data": "TIDAK BOLEH LUAR KOTA"
          }]
        })
      },
      success: response => {
        statusTidakBolehLuarkota =  response.data[0].id;
      }
    })
  }
  function getBukanBlackList() {
    
    $.ajax({
      url: `${apiUrl}parameter`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        filters: JSON.stringify({
          "groupOp": "AND",
          "rules": [{
            "field": "grp",
            "op": "cn",
            "data": "BLACKLIST SUPIR"
          },{
            "field": "text",
            "op": "cn",
            "data": "BUKAN SUPIR BLACKLIST"
          }]
        })
      },
      success: response => {
        statusBukanBlackList =  response.data[0].id;
      }
    })
  }
    
    
</script>
@endpush()
@endsection
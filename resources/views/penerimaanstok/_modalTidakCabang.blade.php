<div class="modal modal-fullscreen" id="activeCabang" tabindex="-1" aria-labelledby="activeCabangLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="listCabang">
      <div class="modal-content">

        <div class="modal-header">
          <p class="modal-title" id="activeCabangTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <table id="nonCabangGrid"></table>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmitCabang" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
            </button>
            <button class="btn btn-secondary" data-dismiss="modal">
              <i class="fa fa-times"></i>
              Cancel
            </button>
          </div>
        </form>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  hasFormBindKeys = false
  let modalBodyCabang = $('#activeCabang').find('.modal-body').html()

  dataMaxLength = []
  let selectedRowsCabang = [];

  $(document).ready(function() {
    $('#btnSubmitCabang').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#listCabang')
      let penerimaanstokId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = []

      data.push({
        name: 'sortIndex',
        value: $('#jqGrid').getGridParam().sortname
      })
      data.push({
        name: 'sortOrder',
        value: $('#jqGrid').getGridParam().sortorder
      })
      data.push({
        name: 'filters',
        value: $('#jqGrid').getGridParam('postData').filters
      })
      data.push({
        name: 'info',
        value: info
      })
      let selectedRows = $("#nonCabangGrid").getGridParam("selectedRowIds");
      
      method = 'POST'
      url = `${apiUrl}penerimaanstok/approvalberlakucabang`

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')
      console.log(selectedRows,selectedRowsCabang);
      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedRows,
        },
        success: response => {
          $('#listCabang').trigger('reset')
          $('#activeCabang').modal('hide')

          $('#jqGrid').trigger('reloadGrid')

        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  $('#activeCabang').on('shown.bs.modal', () => {
    let form = $('#listCabang')

    setFormBindKeys(form)

    activeGrid = null
    form.find('#btnSubmitCabang').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmitCabang').prop('disabled', true)
    }
  })

  $('#activeCabang').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#activeCabang').find('.modal-body').html(modalBodyCabang)
  })

  function listCabang() {
    let form = $('#listCabang')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmitCabang').html(`<i class="fa fa-save"></i>Save`)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#activeCabangTitle').text('List Penerimaan stok tidak berlaku di cabang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
    .all([
      loadPelunasanGrid()
    ])
    .then(() => {
      getDatPeneimaanstok()
      .then((response) => {
        console.log(response);
        let selectedId = []
        
        setTimeout(() => {
          
          $("#nonCabangGrid")
          .jqGrid("setGridParam", {
            datatype: "local",
            data: response.data,
            originalData: response.data,
            rowNum: response.data.length,
            selectedRowIds: selectedId
          })
          .trigger("reloadGrid");
        }, 100);
        
      });
      if (selectedRowsCabang.length > 0) {
        clearSelectedRowsCabang()
      }
      $('#activeCabang').modal('show')
    })
    .catch((error) => {
      showDialog(error.statusText)
    })
    .finally(() => {
      $('.modal-loader').addClass('d-none')
    })
  }
  
  function checkboxHandlerCabang(element,rowId) {
    let isChecked = $(element).is(":checked");
    let editableColumns = $("#nonCabangGrid").getGridParam("editableColumns");
    let selectedRowIds = $("#nonCabangGrid").getGridParam("selectedRowIds");
    let originalGridData = $("#nonCabangGrid")
      .jqGrid("getGridParam", "originalData")
      .find((row) => row.id == rowId);

    if (element.checked) {
      selectedRowsCabang.push($(element).val())
      selectedRowIds.push(rowId);
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowIds.length; i++) {
        if (selectedRowIds[i] == rowId) {
          selectedRowsCabang.splice(i, 1);
          selectedRowIds.splice(i, 1);
        }
      }
      
      
    }
    $("#nonCabangGrid").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });
    console.log($("#nonCabangGrid").getGridParam("selectedRowIds"));

  }

  function clearSelectedRowsCabang() {
    selectedRowsCabang = []
    $('#gs_').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }
  
  function selectAllRowsCabang() {
    let getSelectedRows = [];
    let originalData = $("#nonCabangGrid").getGridParam("data");
    $.each(originalData, function(index, value) {
      getSelectedRows.push(value.id);
    })
    $("#nonCabangGrid")[0].p.selectedRowIds = [];
    $("#nonCabangGrid")
    .jqGrid("setGridParam", {
      selectedRowIds: getSelectedRows
    })
    .trigger("reloadGrid");
    
  }

  function clearSelectedRowsCabang() {
    getSelectedRows = $("#nonCabangGrid").getGridParam("selectedRowIds");
    $("#nonCabangGrid")[0].p.selectedRowIds = [];
    $('#nonCabangGrid').trigger('reloadGrid');
  }
  
  
    

  function loadPelunasanGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }

    $("#nonCabangGrid")
    .jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          {
            label: '',
            name: '',
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
                    selectAllRowsCabang()
                    $(element).attr('disabled', false)
                  } else {
                    clearSelectedRowsCabang()
                    $(element).attr('disabled', false)
                  }
                })
              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandlerCabang(this,${rowData.id})">`
            },
          },
          {
            label: 'ID',
            name: 'id',
            
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'kode penerimaan',
            name: 'kodepenerimaan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'keterangan',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'KODE PERKIRAAN',
            name: 'coa',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: 'Format',
            name: 'format',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: (value, options, rowData) => {
              let Format = JSON.parse(value)
              return Format.SINGKATAN
            },
            cellattr: (rowId, value, rowObject) => {
              let Format = JSON.parse(rowObject.format)    
              return ` title="${Format.MEMO}"`
            }
          },
          {
            label: 'status hitung stok',
            name: 'statushitungstok',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            stype: 'select',
            
            searchoptions: {
              
              value: `<?php
              $i = 1;
              
              foreach ($data['combohitungstok'] as $status):
                echo "$status[param]:$status[parameter]";
                if ($i !== count($data['combohitungstok'])) {
                  echo ';';
                }
                $i++;
              endforeach;
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
              let statusHitungStok = JSON.parse(value)
              
              let formattedValue = $(`
              <div class="badge" style="background-color: ${statusHitungStok.WARNA}; color: #fff;">
                <span>${statusHitungStok.SINGKATAN}</span>
              </div>
              `)
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusHitungStok = JSON.parse(rowObject.statushitungstok)
              
              return ` title="${statusHitungStok.MEMO}"`
            }
            
          },
          {
            label: 'Status',
            name: 'statusaktif',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
              $i = 1;
              
              foreach ($data['combo'] as $status):
                echo "$status[param]:$status[parameter]";
                if ($i !== count($data['combo'])) {
                  echo ';';
                }
                $i++;
              endforeach;
              
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
      height: 400,
      rownumbers: true,
      rownumWidth: 45,
      footerrow: true,
      userDataOnFooter: true,
      toolbar: [true, "top"],
      pgbuttons: false,
      pginput: false,
      cellEdit: true,
      cellsubmit: "clientArray",
      selectedRowIds: [],
      loadComplete: function() {
        setTimeout(() => {
          $(this)
          .getGridParam("selectedRowIds")
          .forEach((selectedRowId) => {
            $(this)
            .find(`tr input[value=${selectedRowId}]`)
            .prop("checked", true);
          });
        }, 100);
        
     
        setHighlight($(this))
      }
    })
    .jqGrid("setLabel", "rn", "No.")
    .jqGrid("navGrid", "#tablePager", {
      add: false,
      edit: false,
      del: false,
      refresh: false,
      search: false,
    })
    
    .jqGrid("filterToolbar", {
      searchOnEnter: false,
    })
  }
  
  function getDatPeneimaanstok(agenId, id) {
    
    url = `${apiUrl}penerimaanstok`
    

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data:{cabang:'kosong'},
        success: (response) => {
          resolve(response);
        },
        error: error => {
          reject(error)
        }
      });
    });
  }
  

  </script>
@endpush()

                          
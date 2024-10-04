<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        
        <form action="" method="post">

          <div class="modal-body">
            <div class="master">
              <input type="hidden" name="id">

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="nobukti" class="form-control" readonly>
                </div>

                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    TGL BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tglbukti" class="form-control datepicker">
                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                    GUDANG <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="hidden" name="gudang_id">
                  <input type="text" name="gudang" id="gudang" class="form-control gudang-lookup">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                    kelompok
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="hidden" name="kelompok_id">
                  <input type="text" name="kelompok" id="kelompok" class="form-control kelompok-lookup">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                    KETERANGAN
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>

              <div class="row form-group mb-5">
                <div class="col-md-2">
                  <button class="btn btn-primary" id="btnTampil"><i class="fas fa-sync"></i> RELOAD</button>
                </div>
              </div>

            </div>

            <table id="tableOpname"></table>

          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
            </button>
            <button id="btnSaveAdd" class="btn btn-success">
              <i class="fas fa-file-upload"></i>
              Save & Add
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  let selectedIdOpname = []

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");


    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })
    $('#btnSaveAdd').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })
    
    function submit(button) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')

      let selectedRowsStok = $("#tableOpname").getGridParam("selectedRowIds");
      dataQty = []
      dataStokId = []
      dataTanggal = []
      dataQtyFisik = []
      $.each(selectedRowsStok, function(index, value) {
        dataOpname = $("#tableOpname").jqGrid("getLocalRow", value);
        let selectedQty = dataOpname.qty
        let selectedTanggal = dataOpname.tanggal
        let selectedQtyFisik = (dataOpname.qtyfisik == undefined) ? 0 : dataOpname.qtyfisik;

        dataTanggal.push(selectedTanggal)
        dataQty.push((isNaN(selectedQty)) ? parseFloat(selectedQty.replaceAll(',', '')) : selectedQty)
        dataQtyFisik.push((isNaN(selectedQtyFisik)) ? parseFloat(selectedQtyFisik.replaceAll(',', '')) : selectedQtyFisik)
        dataStokId.push(dataOpname.id)
      });

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}opnameheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}opnameheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}opnameheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}opnameheader`
          break;
      }

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')
      let requestData = {
        'qty': dataQty,
        'qtyfisik': dataQtyFisik,
        'tglbuktimasuk': dataTanggal,
        'stok_id': dataStokId
      };

      let jsonData = JSON.stringify(requestData);
      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          id: form.find(`[name="id"]`).val(),
          nobukti: form.find(`[name="nobukti"]`).val(),
          tglbukti: form.find(`[name="tglbukti"]`).val(),
          gudang: form.find(`[name="gudang"]`).val(),
          gudang_id: form.find(`[name="gudang_id"]`).val(),
          gkelompokg: form.find(`[name="kelompok"]`).val(),
          kelompok_id: form.find(`[name="kelompok_id"]`).val(),
          keterangan: form.find(`[name="keterangan"]`).val(),
          detail: jsonData,
          sortIndex: $('#jqGrid').getGridParam().sortname,
          sortOrder: $('#jqGrid').getGridParam().sortorder,
          filters: $('#jqGrid').getGridParam('postData').filters,
          info: info,
          indexRow: indexRow,
          page: page,
          limit: limit,
          button: button,
          tgldariheader: $('#tgldariheader').val(),
          tglsampaiheader: $('#tglsampaiheader').val()
        },
        success: response => {
          id = response.data.id

          $('#crudModal').find('#crudForm').trigger('reset')
          if (button == 'btnSubmit') {
            $('#crudModal').modal('hide')
  
            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page,
              postData: {
                tgldari: dateFormat(response.data.tgldariheader),
                tglsampai: dateFormat(response.data.tglsampaiheader)
              }
            }).trigger('reloadGrid');
  
            if (id == 0) {
              $('#detail').jqGrid().trigger('reloadGrid')
            }
  
            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          }else{
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            $("#tableOpname")[0].p.selectedRowIds = [];
            $('#tableOpname').jqGrid("clearGridData");
            $("#tableOpname")
            .jqGrid("setGridParam", {
              selectedRowIds: []
            })
            showSuccessDialog(response.message, response.data.nobukti)
            createOpname();
            $('#crudForm').find('[name=tglbukti]').val(dateFormat(response.data.tglbukti)).trigger('change');
          }
        },
        error: error => {
          console.log('error ', error.responseText)
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            errors = error.responseJSON.errors
            $(".ui-state-error").removeClass("ui-state-error");
            $.each(errors, (index, error) => {
              let indexes = index.split(".");
              let angka = indexes[1]

              let element;
              if (indexes[0] == 'sp') {
                return showDialog(error);
              } else if (indexes[0] == 'nominalretribusi') {
                selectedRowsInvoice = $("#tableOpname").getGridParam("selectedRowIds");
                row = parseInt(selectedRowsInvoice[angka]) - 1;

                element = $(`#tableOpname tr#${parseInt(selectedRowsInvoice[angka])}`).find(`td[aria-describedby="tableOpname_${indexes[0]}"]`)
                $(element).addClass("ui-state-error");
                $(element).attr("title", error[0].toLowerCase())

              } else {

                element = form.find(`[name="${indexes[0]}"]`)[0];

                if ($(element).length > 0 && !$(element).is(":hidden")) {
                  $(element).addClass("is-invalid");
                  $(`
                      <div class="invalid-feedback">
                      ${error[0].toLowerCase()}
                      </div>
                      `).appendTo($(element).parent());
                } else {
                  return showDialog(error);
                }
              }
            });
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    }
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    initLookup()
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function createOpname() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Opname')
    if (selectedRows.length > 0) {
              clearSelectedRows()
            }
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    initDatepicker()
    loadOpnameGrid();
  }

  function editOpname(opnameId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Opname')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showOpname(form, opnameId, 'edit')
      ])
      .then(() => {
        if (selectedRows.length > 0) {
              clearSelectedRows()
            }
        $('#crudModal').modal('show')
        $('#crudForm').find("[name=gudang]").parents('.input-group').find('.input-group-append').hide()
        $('#crudForm').find("[name=gudang]").parents('.input-group').find('.button-clear').hide()
        $('#crudForm').find("[name=kelompok]").parents('.input-group').find('.input-group-append').hide()
        $('#crudForm').find("[name=kelompok]").parents('.input-group').find('.button-clear').hide()

      }).catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })


  }

  function deleteOpname(opnameId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Opname')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    Promise
      .all([
        showOpname(form, opnameId, 'delete')
      ])
      .then(() => {
        if (selectedRows.length > 0) {
              clearSelectedRows()
            }
        $('#crudModal').modal('show')
        $('#crudForm').find("[name=gudang]").parents('.input-group').find('.input-group-append').hide()
        $('#crudForm').find("[name=gudang]").parents('.input-group').find('.button-clear').hide()
        $('#crudForm').find("[name=kelompok]").parents('.input-group').find('.input-group-append').hide()
        $('#crudForm').find("[name=kelompok]").parents('.input-group').find('.button-clear').hide()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  $(document).on('click', '#btnTampil', function(event) {
    event.preventDefault()

    if ($('#crudForm').data('action') == 'add') {
      url = `getstok`
    } else if ($('#crudForm').data('action') == 'edit') {
      invId = $(`#crudForm`).find(`[name="id"]`).val()
      url = `${invId}/getEdit`
    }

    if (($('#crudForm').find(`[name="gudang_id"]`).val() != '') ) {

      $('#loaderGrid').removeClass('d-none')
      getDataOpname(url).then((response) => {
        setTimeout(() => {

          $("#tableOpname")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: selectedIdOpname
            })
            .trigger("reloadGrid");
        }, 100);

      }).finally(() => {
        $('#processingLoader').addClass('d-none')
        $('#loaderGrid').addClass('d-none')
      });
    } else {
      showDialog('Harap memilih gudang ')
    }
  })


  function loadOpnameGrid() {
    $("#tableOpname")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "ID",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "NAMA BARANG",
            name: "namabarang",
            sortable: true,
            width: '500px'

          },
          {
            label: "TANGGAL",
            name: "tanggal",
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: "QTY Admin",
            name: "qty",
            sortable: true,
            align: "right",
            formatter: currencyFormat,
            hidden: true,
            search: false,
          },

          {
            label: "QTY",
            name: "qtyfisik",
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tableOpname")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);
                  let localRow = $("#tableOpname").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );

                  localRow.qtyfisik = event.target.value;
                  let qtyFisiks = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  if (qtyFisiks < 0) {
                    showDialog('tidak boleh minus')
                    $("#tableOpname").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "qtyfisik",
                      0
                    );
                  }
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
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
        editableColumns: ["qtyfisik"],
        selectedRowIds: [],
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tableOpname")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableOpname").jqGrid("getLocalRow", rowId);
          // if (indexColumn == 5) {
          //   $("#tableOpname").jqGrid(
          //     "setCell",
          //     rowId,
          //     "total",
          //     total
          //     // sisa - bayar - potongan
          //   );
          // }

        },
        // isCellEditable: function(cellname, iRow, iCol) {
        //   let rowData = $(this).jqGrid("getRowData")[iRow - 1];
        //   if ($('#crudForm').data('action') != 'delete') {
        //     return $(this)
        //       .find(`tr input[value=${rowData.id}]`)
        //       .is(":checked");
        //   }
        // },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
          $('#loaderGrid').addClass('d-none')

          setHighlight($(this))
        },
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
        beforeSearch: function() {
          postData = $.parseJSON($('#tableOpname').jqGrid('getGridParam', 'postData').filters)
          $.each(postData.rules, function(key, val) {
            if (val.field == 'omset') {
              return initAutoNumeric($('#gsh_tableOpname_omset').find('#gs_omset'))
            }
          })
        },
      })
      .jqGrid("excelLikeGrid", {
        beforeDeleteCell: function(rowId, iRow, iCol, event) {
          let localRow = $("#tableOpname").jqGrid("getLocalRow", rowId);

          $("#tableOpname").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.bayar)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableOpname'))

    /* Append global search */
    // loadGlobalSearch($('#tableOpname'))
  }

  function getDataOpname(url, id) {

    let form = $('#crudForm')
    let data = []

    data.push({
      name: 'gudang_id',
      value: form.find(`[name="gudang_id"]`).val()
    })
    data.push({
      name: 'kelompok_id',
      value: form.find(`[name="kelompok_id"]`).val()
    })
    data.push({
      name: 'tglbukti',
      value: form.find(`[name="tglbukti"]`).val()
    })
    data.push({
      name: 'limit',
      value: 0
    })
    data.push({
      name: 'aksi',
      value: form.data('action')
    })

    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}opnameheader/${url}`,
        dataType: "JSON",
        data: data,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: (response) => {
          selectedIdOpname = []
          $.each(response.data, (index, value) => {
            selectedIdOpname.push(value.id)
          })
          resolve(response);
        },
        error: error => {
          showDialog(error.responseJSON)
          
          reject(error)
        }
      });
    });
  }


  function checkboxHandlerInvoice(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tableOpname").getGridParam("editableColumns");
    let selectedRowIds = $("#tableOpname").getGridParam("selectedRowIds");
    let originalGridData = $("#tableOpname")
      .jqGrid("getGridParam", "originalData")
      .find((row) => row.id == rowId);

    editableColumns.forEach((editableColumn) => {

      if (!isChecked) {
        for (var i = 0; i < selectedRowIds.length; i++) {
          if (selectedRowIds[i] == rowId) {
            selectedRowIds.splice(i, 1);
          }
        }
        total = 0
        if ($('#crudForm').data('action') == 'edit') {
          total = parseFloat(originalGridData.omset) + parseFloat(originalGridData.nominalextra) + parseFloat(originalGridData.nominalretribusi)
        } else {
          total = parseFloat(originalGridData.omset) + parseFloat(originalGridData.nominalextra)
        }

        $("#tableOpname").jqGrid(
          "setCell",
          rowId,
          "total",
          total
        );

        $("#tableOpname").jqGrid("setCell", rowId, "nominalretribusi", 0);
        $(`#tableOpname tr#${rowId}`).find(`td[aria-describedby="tableOpname_nominalretribusi"]`).attr("value", 0)
      } else {
        selectedRowIds.push(rowId);
      }
    });

    $("#tableOpname").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });


    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableOpname_potongan"]`).text(totalPotongan))
    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableOpname_nominallebihbayar"]`).text(totalNominalLebih))

  }

  function showOpname(form, opnameId, aksi) {
    return new Promise((resolve, reject) => {


      $.ajax({
        url: `${apiUrl}opnameheader/${opnameId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $('#btnTampil').hide()
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

          })

          if (aksi == 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          $('#crudForm').find("[name=gudang]").prop('readonly', true);
          $('#crudForm').find("[name=kelompok]").prop('readonly', true);

          loadOpnameGrid();

          getDataOpname(`${opnameId}/getEdit`).then((response) => {
            $("#tableOpname")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: selectedIdOpname
              })
              .trigger("reloadGrid");

            resolve()
          });
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  function getStatusApproval() {
      return new Promise((resolve, reject) => {
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
                "data": "STATUS APPROVAL"
              }, {
                "field": "text",
                "op": "cn",
                "data": "APPROVAL"
              }]
            })
          },
          success: response => {
            statusApproval = response.data[0].id;
            resolve(statusApproval)
          },
          error:error=>{
            reject(error)
          }
        })
      })
    }
  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}opnameheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
                aksi: Aksi
            },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response.message)
        } else {
          if(Aksi == 'EDIT'){
            editOpname(Id)
          }
          if(Aksi == 'DELETE') {
            deleteOpname(Id)
          }
          if (Aksi == 'Stok Bukti') {
            window.open(`{{ route('opnameheader.report') }}?id=${selectedId}&report=stokBukti`)
          }
          if (Aksi == 'Stok Opname') {
            window.open(`{{ route('opnameheader.report') }}?id=${selectedId}&report=stokOpname`)
          }
        }
      }
    })
  }
  function cekValidasiReportBanding(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}opnameheader/${Id}`,
      method: 'get',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        getStatusApproval()
        .then(statusApproval=>{
          if (response.data.statusapproval === statusApproval) {
            if (Aksi == "export") {
              window.open(`{{ route('opnameheader.export') }}?id=${selectedId}&export=stokBanding`)
            }else{
              window.open(`{{ route('opnameheader.report') }}?id=${selectedId}&report=stokBanding`)
            }
          }else{
            showDialog('Data Belum di Approval');
          }

        })
      }
    })
  }

  function initLookup() {
    $('.gudang-lookup').lookupMaster({
      title: 'gudang Lookup',
      fileName: 'gudangMaster',
      typeSearch: 'ALL',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'gudang_id',
          searchText: 'gudang-lookup',
          title: 'Gudang',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (gudang, element) => {
        $('#crudForm [name=gudang_id]').first().val(gudang.id)
        element.val(gudang.gudang)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=gudang_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.kelompok-lookup').lookupMaster({
      title: 'kelompok Lookup',
      fileName: 'kelompokMaster',
      typeSearch: 'ALL',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'kelompok_id',
          searchText: 'kelompok-lookup',
          title: 'kelompok',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (kelompok, element) => {
        $('#crudForm [name=kelompok_id]').first().val(kelompok.id)
        element.val(kelompok.kodekelompok)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kelompok_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

  }
</script>
@endpush()
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
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    SUPIR <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-10">
                  <input type="hidden" name="supir_id">
                  <input type="text" name="supir" class="form-control supir-lookup">
                </div>
              </div>

              <div class="border p-3 mt-3">
                <h6>Posting Penerimaan</h6>

                <div class="row form-group">
                  <div class="col-12 col-md-2">
                    <label class="col-form-label">
                      POSTING </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <input type="hidden" name="bank_id">
                    <input type="text" name="bank" class="form-control bank-lookup">
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-12 col-md-2">
                    <label class="col-form-label">
                      NO BUKTI KAS MASUK </label>
                  </div>
                  <div class="col-12 col-md-4">
                    <input type="text" name="penerimaan_nobukti" id="penerimaan_nobukti" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-12">
                  <div id="tabs" class="dejavu" style="font-size:12px">
                    <ul>
                      <li><a href="#tabs-1">Posting</a></li>
                      <li><a href="#tabs-2">Non Posting</a></li>
                    </ul>
                    <div id="tabs-1">
                      <table id="posting"></table>
                    </div>
                    <div id="tabs-2">
                      <table id="nonposting"></table>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()

  let sortnamePosting = 'nobukti_posting';
  let sortorderPosting = 'asc';
  let pagePosting = 0;
  let totalRecordPosting
  let limitPosting
  let postDataPosting
  let triggerClickPosting
  let indexRowPosting
  let isEditTgl

  let sortnameNonPosting = 'nobukti_nonposting';
  let sortorderNonPosting = 'asc';
  let pageNonPosting = 0;
  let totalRecordNonPosting
  let limitNonPosting
  let postDataNonPosting
  let triggerClickNonPosting
  let indexRowNonPosting

  let selectedRowsPosting = [];
  let selectedNominalPosting = [];
  let selectedSisaPosting = [];
  let selectedBuktiPosting = [];
  let selectedKeteranganPosting = [];

  let selectedRowsNonPosting = [];
  let selectedNominalNonPosting = [];
  let selectedSisaNonPosting = [];
  let selectedBuktiNonPosting = [];
  let selectedKeteranganNonPosting = [];

  function checkboxHandlerPosting(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRowsPosting.push($(element).val())
      selectedBuktiPosting.push($(element).parents('tr').find(`td[aria-describedby="posting_nobukti_posting"]`).text())
      selectedKeteranganPosting.push($(element).parents('tr').find(`td[aria-describedby="posting_keterangan_posting"]`).text())
      selectedNominalPosting.push($(element).parents('tr').find(`td[aria-describedby="posting_nominal_posting"]`).text())
      selectedSisaPosting.push($(element).parents('tr').find(`td[aria-describedby="posting_sisa_posting"]`).text())
      hitungNominalPosting()

      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsPosting.length; i++) {
        if (selectedRowsPosting[i] == value) {
          selectedRowsPosting.splice(i, 1);
          selectedBuktiPosting.splice(i, 1);
          selectedKeteranganPosting.splice(i, 1);
          selectedNominalPosting.splice(i, 1);
          selectedSisaPosting.splice(i, 1);
        }
      }
      hitungNominalPosting()
    }

  }

  function hitungNominalPosting() {
    nominalPosting = 0;
    sisaPosting = 0;
    $.each(selectedNominalPosting, function(index, item) {
      nominalPosting = nominalPosting + parseFloat(item.replace(/,/g, ''))
    });
    $.each(selectedSisaPosting, function(index, item) {
      sisaPosting = sisaPosting + parseFloat(item.replace(/,/g, ''))
    });

    initAutoNumeric($('.footrow').find(`td[aria-describedby="posting_nominal_posting"]`).text(nominalPosting))
    initAutoNumeric($('.footrow').find(`td[aria-describedby="posting_sisa_posting"]`).text(sisaPosting))
  }

  function checkboxHandlerNonPosting(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRowsNonPosting.push($(element).val())
      selectedBuktiNonPosting.push($(element).parents('tr').find(`td[aria-describedby="nonposting_nobukti_nonposting"]`).text())
      selectedKeteranganNonPosting.push($(element).parents('tr').find(`td[aria-describedby="nonposting_keterangan_nonposting"]`).text())
      selectedNominalNonPosting.push($(element).parents('tr').find(`td[aria-describedby="nonposting_nominal_nonposting"]`).text())
      selectedSisaNonPosting.push($(element).parents('tr').find(`td[aria-describedby="nonposting_sisa_nonposting"]`).text())
      hitungNominalNonPosting()

      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsNonPosting.length; i++) {
        if (selectedRowsNonPosting[i] == value) {
          selectedRowsNonPosting.splice(i, 1);
          selectedBuktiNonPosting.splice(i, 1);
          selectedKeteranganNonPosting.splice(i, 1);
          selectedNominalNonPosting.splice(i, 1);
          selectedSisaNonPosting.splice(i, 1);
        }
      }
      hitungNominalNonPosting()
    }

  }

  function hitungNominalNonPosting() {
    nominalNonPosting = 0;
    sisaNonPosting = 0;
    $.each(selectedNominalNonPosting, function(index, item) {
      nominalNonPosting = nominalNonPosting + parseFloat(item.replace(/,/g, ''))
    });
    $.each(selectedSisaNonPosting, function(index, item) {
      sisaNonPosting = sisaNonPosting + parseFloat(item.replace(/,/g, ''))
    });

    initAutoNumeric($('.footrow').find(`td[aria-describedby="nonposting_nominal_nonposting"]`).text(nominalNonPosting))
    initAutoNumeric($('.footrow').find(`td[aria-describedby="nonposting_sisa_nonposting"]`).text(sisaNonPosting))
  }


  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = []

      data.push({
        name: 'id',
        value: form.find(`[name="id"]`).val()
      })
      data.push({
        name: 'nobukti',
        value: form.find(`[name="nobukti"]`).val()
      })
      data.push({
        name: 'tglbukti',
        value: form.find(`[name="tglbukti"]`).val()
      })
      data.push({
        name: 'supir',
        value: form.find(`[name="supir"]`).val()
      })
      data.push({
        name: 'supir_id',
        value: form.find(`[name="supir_id"]`).val()
      })
      data.push({
        name: 'bank',
        value: form.find(`[name="bank"]`).val()
      })
      data.push({
        name: 'bank_id',
        value: form.find(`[name="bank_id"]`).val()
      })
      data.push({
        name: 'penerimaan_nobukti',
        value: form.find(`[name="penerimaan_nobukti"]`).val()
      })


      let rowLength = 0
      $.each(selectedRowsPosting, function(index, item) {
        data.push({
          name: 'postingId[]',
          value: item
        })
        rowLength++
      });
      $.each(selectedBuktiPosting, function(index, item) {
        data.push({
          name: 'posting_nobukti[]',
          value: item
        })
      });
      $.each(selectedSisaPosting, function(index, item) {
        data.push({
          name: 'posting_nominal[]',
          value: parseFloat(item.replaceAll(',', ''))
        })
      });
      $.each(selectedKeteranganPosting, function(index, item) {
        data.push({
          name: 'posting_keterangan[]',
          value: item
        })
      });

      $.each(selectedRowsNonPosting, function(index, item) {
        data.push({
          name: 'nonpostingId[]',
          value: item
        })
        rowLength++
      });
      $.each(selectedBuktiNonPosting, function(index, item) {
        data.push({
          name: 'nonposting_nobukti[]',
          value: item
        })
      });
      $.each(selectedSisaNonPosting, function(index, item) {
        data.push({
          name: 'nonposting_nominal[]',
          value: parseFloat(item.replaceAll(',', ''))
        })
      });
      $.each(selectedKeteranganNonPosting, function(index, item) {
        data.push({
          name: 'nonposting_keterangan[]',
          value: item
        })
      });

      data.push({
        name: 'jumlahdetail',
        value: rowLength
      })
      data.push({
        name: 'jumlahposting',
        value: selectedRowsPosting.length
      })
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
      data.push({
        name: 'indexRow',
        value: indexRow
      })
      data.push({
        name: 'page',
        value: page
      })
      data.push({
        name: 'limit',
        value: limit
      })
      data.push({
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pemutihansupir`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pemutihansupir/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pemutihansupir/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pemutihansupir`
          break;
      }

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          id = response.data.id

          $('#crudModal').find('#crudForm').trigger('reset')
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
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            // if (error.responseJSON.errors) {
            //   showDialog(error.responseJSON.errors)
            // } else if (error.responseJSON.message) {
            //   showDialog(error.responseJSON)
            // } else {
            showDialog(error.responseJSON)
            // }
            // if (error.responseJSON.message) {
            //   showDialog(error.responseJSON)
            // }
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')
    $('#tabs').tabs();
    setFormBindKeys(form)

    activeGrid = null
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    getMaxLength(form)
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })


  function createPemutihanSupir() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    $('#crudModalTitle').text('add Pemutihan Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')

    initDatepicker()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    tablePost('getPost')
    tableNonPost('getNonPost')
  }

  async function editPemutihanSupir(pemutihanId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pemutihan Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setTglBukti(form),
        showPemutihanSupir(form, pemutihanId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        if (isEditTgl == 'TIDAK') {
          form.find(`[name="tglbukti"]`).prop('readonly', true)
          form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        }
        $('#crudForm [name=supir]').siblings('.input-group-append').remove()
        $('#crudForm [name=supir]').siblings('.button-clear').remove()
        $('#crudForm [name=bank]').siblings('.button-clear').remove()
        $('#crudForm [name=bank]').siblings('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function deletePemutihanSupir(pemutihanId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pemutihan Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPemutihanSupir(form, pemutihanId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function viewPemutihanSupir(pemutihanId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pemutihan Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPemutihanSupir(form, pemutihanId)
      ])
      .then(() => {
        form.find('[name]').attr('disabled', 'disabled').css({
          background: '#fff'
        })
        form.find('[name=id]').prop('disabled', false)

        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        name.attr('disabled', true)
        name.find('.lookup-toggler').attr('disabled', true)
        name.find('.lookup-toggler').attr('disabled', true)

      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function tablePost(url) {
    $("#posting").jqGrid({
        url: `${apiUrl}pemutihansupir/${url}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: '',
            name: '',
            width: 30,
            align: 'center',
            sortable: false,
            clear: false,
            stype: 'input',
            search: false,
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="postId[]" value="${rowData.id_posting}" disabled onchange="checkboxHandlerPosting(this)">`
            },
          },
          {
            label: 'ID',
            name: 'id_posting',
            align: 'right',
            width: '50px',
            hidden: true
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti_posting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti_posting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'NO BUKTI pengeluaran',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'pengeluaran_posting',
            align: 'left'
          },
          {
            label: 'NOMINAL PINJAMAN',
            name: 'nominal_posting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'SISA PINJAMAN',
            name: 'sisa_posting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan_posting',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 400,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnamePosting,
        sortorder: sortorderPosting,
        page: pagePosting,
        viewrecords: true,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        jsonReader: {
          root: 'post',
          total: 'attributes.totalPages',
          records: 'attributes.totalRows',
        },
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },

        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          let grid = $(this)
          changeJqGridRowListText()

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))


          $.each(selectedRowsPosting, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });

          /* Set global variables */
          sortnamePosting = $(this).jqGrid("getGridParam", "sortname")
          sortorderPosting = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPosting = $(this).getGridParam("records")
          limitPosting = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPosting = $(this).jqGrid('getGridParam', 'postData')
          triggerClickPosting = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPosting > $(this).getDataIDs().length - 1) {
            indexRowPosting = $(this).getDataIDs().length - 1;
          }

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

          clearGlobalSearch($('#posting'))
        },
      })

      .customPager({})



    /* Append clear filter button */
    loadClearFilter($('#posting'))

    /* Append global search */
    loadGlobalSearch($('#posting'))
  }

  function tableNonPost(url) {
    console.log(url)
    $("#nonposting").jqGrid({
        url: `${apiUrl}pemutihansupir/${url}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: '',
            name: '',
            width: 30,
            align: 'center',
            sortable: false,
            clear: false,
            stype: 'input',
            search: false,
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="nonpostId[]" value="${rowData.id_nonposting}" disabled onchange="checkboxHandlerNonPosting(this)">`
            },
          },
          {
            label: 'ID',
            name: 'id_nonposting',
            align: 'right',
            width: '50px',
            hidden: true
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti_nonposting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti_nonposting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'NO BUKTI pengeluaran',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'pengeluaran_nonposting',
            align: 'left'
          },
          {
            label: 'NOMINAL PINJAMAN',
            name: 'nominal_nonposting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'SISA PINJAMAN',
            name: 'sisa_nonposting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan_nonposting',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 400,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameNonPosting,
        sortorder: sortorderNonPosting,
        page: pageNonPosting,
        viewrecords: true,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        jsonReader: {
          root: 'non',
          total: 'attributesNon.totalPages',
          records: 'attributesNon.totalRows',
        },
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },

        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          let grid = $(this)
          changeJqGridRowListText()

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))


          $.each(selectedRowsNonPosting, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });

          /* Set global variables */
          sortnameNonPosting = $(this).jqGrid("getGridParam", "sortname")
          sortorderNonPosting = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordNonPosting = $(this).getGridParam("records")
          limitNonPosting = $(this).jqGrid('getGridParam', 'postData').limit
          postDataNonPosting = $(this).jqGrid('getGridParam', 'postData')
          triggerClickNonPosting = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowNonPosting > $(this).getDataIDs().length - 1) {
            indexRowNonPosting = $(this).getDataIDs().length - 1;
          }

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

          clearGlobalSearch($('#nonposting'))
        },
      })

      .customPager({})



    /* Append clear filter button */
    loadClearFilter($('#nonposting'))

    /* Append global search */
    loadGlobalSearch($('#nonposting'))
  }

  function showPemutihanSupir(form, pemutihanId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}pemutihansupir/${pemutihanId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
            if (index == 'supir') {
              element.data('current-value', value).prop('readonly', true)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
            if (index == 'bank') {
              element.data('current-value', value).prop('readonly', true)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }

          })


          if (form.data('action') == 'delete' || form.data('action') == 'view') {
            form.find('[name]').addClass('disabled')
            initDisabled()
            tablePost(`${pemutihanId}/getDeletePost`)
            selectAllRowsPosting(response.data.supir_id)
            tableNonPost(`${pemutihanId}/getDeleteNonPost`)
            selectAllRowsNonPosting(response.data.supir_id)
          } else {
            tablePost(`${pemutihanId}/getEditPost`)
            selectAllRowsPosting(response.data.supir_id)
            tableNonPost(`${pemutihanId}/getEditNonPost`)
            selectAllRowsNonPosting(response.data.supir_id)
          }
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pemutihansupir/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {

          if (Aksi == 'EDIT') {
            editPemutihanSupir(Id)
          }
          if (Aksi == 'DELETE') {
            deletePemutihanSupir(Id)
          }
        } else {
          showDialog(response.message['keterangan'])
        }

      }
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pemutihansupir/field_length`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            if (value !== null && value !== 0 && value !== undefined) {
              form.find(`[name=${index}]`).attr('maxlength', value)
            }
          })

          form.attr('has-maxlength', true)
        },
        error: error => {
          showDialog(error.responseJSON)
        }
      })
    }
  }

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
        selectAllRowsPosting(supir.id)
        selectAllRowsNonPosting(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=supir_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        this.postData = {

          Aktif: 'AKTIF',
          withPusat: 0
        }
      },
      onSelectRow: (bank, element) => {
        $('#crudForm [name=bank_id]').first().val(bank.id)
        element.val(bank.namabank)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=bank_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function selectAllRowsPosting(supirId) {
    let aksi = $('#crudForm').data('action')
    if (aksi == 'edit') {
      pemutihanId = $(`#crudForm`).find(`[name="id"]`).val()
      url = `${pemutihanId}/getEditPost`
    } else if (aksi == 'delete' || aksi == 'view') {
      pemutihanId = $(`#crudForm`).find(`[name="id"]`).val()
      url = `${pemutihanId}/getDeletePost`
    } else {
      url = 'getPost'
    }
    $.ajax({
      url: `${apiUrl}pemutihansupir/${url}`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        supir_id: supirId,
        sortIndex: sortnamePosting,
        aksi: aksi
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        selectedRowsPosting = response.post.map((post) => post.id_posting)
        selectedBuktiPosting = response.post.map((post) => post.nobukti_posting)
        selectedKeteranganPosting = response.post.map((post) => post.keterangan_posting)
        selectedNominalPosting = response.post.map((post) => post.nominal_posting)
        selectedSisaPosting = response.post.map((post) => post.sisa_posting)

        $('#posting').jqGrid('setGridParam', {
          url: `${apiUrl}pemutihansupir/${url}`,
          postData: {
            supir_id: $('#crudForm').find('[name=supir_id]').val(),
            aksi: aksi
          },
        }).trigger('reloadGrid');
        hitungNominalPosting()

      }
    })

  }

  async function getEditPost(pemutihanId) {
    return await $.ajax({
      url: `${apiUrl}pemutihansupir/${pemutihanId}/getEditPost`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        supir_id: $(`#crudForm`).find(`[name="supir_id"]`),
        sortIndex: sortnamePosting,
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        return response
      },
      error: (error) => {
        showDialog(error.responseJSON.message)
      }
    })
  }

  function clearSelectedRowsPosting() {
    selectedRowsPosting = []
    selectedBuktiPosting = []
    selectedKeteranganPosting = []
    selectedNominalPosting = []
    selectedSisaPosting = []
    $('#posting').trigger('reloadGrid')
  }

  function selectAllRowsNonPosting(supirId) {

    let aksi = $('#crudForm').data('action')
    if (aksi == 'edit') {
      pemutihanId = $(`#crudForm`).find(`[name="id"]`).val()
      urlNon = `${pemutihanId}/getEditNonPost`
    } else if (aksi == 'delete' || aksi == 'view') {
      pemutihanId = $(`#crudForm`).find(`[name="id"]`).val()
      urlNon = `${pemutihanId}/getDeleteNonPost`
    } else {
      urlNon = 'getNonPost'
    }
    $.ajax({
      url: `${apiUrl}pemutihansupir/${urlNon}`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        supir_id: supirId,
        sortIndex: sortnameNonPosting,
        aksi: aksi
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        selectedRowsNonPosting = response.non.map((non) => non.id_nonposting)
        selectedBuktiNonPosting = response.non.map((non) => non.nobukti_nonposting)
        selectedKeteranganNonPosting = response.non.map((non) => non.keterangan_nonposting)
        selectedNominalNonPosting = response.non.map((non) => non.nominal_nonposting)
        selectedSisaNonPosting = response.non.map((non) => non.sisa_nonposting)

        $('#nonposting').jqGrid('setGridParam', {
          url: `${apiUrl}pemutihansupir/${urlNon}`,
          postData: {
            supir_id: $('#crudForm').find('[name=supir_id]').val(),
            aksi: aksi
          },
        }).trigger('reloadGrid');
        hitungNominalNonPosting()

      }
    })

  }

  async function getEditNonPost(pemutihanId) {
    return await $.ajax({
      url: `${apiUrl}pemutihansupir/${pemutihanId}/getEditNonPost`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        supir_id: $(`#crudForm`).find(`[name="supir_id"]`),
        sortIndex: sortnameNonPosting,
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        return response
      },
      error: (error) => {
        showDialog(error.responseJSON.message)
      }
    })
  }

  function clearSelectedRowsNonPosting() {
    selectedRowsNonPosting = []
    selectedBuktiNonPosting = []
    selectedKeteranganNonPosting = []
    selectedNominalNonPosting = []
    selectedSisaNonPosting = []
    $('#nonposting').trigger('reloadGrid')
  }

  function getDataPemutihan(supirId) {

    $.ajax({
      url: `${apiUrl}pemutihansupir/${supirId}/getdatapemutihan`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {

        initAutoNumeric($('#crudForm [name=pengeluaransupir]').val(response.data.pengeluaran))
        initAutoNumeric($('#crudForm [name=penerimaansupir]').val(response.data.penerimaan))
        console.log(response.data)
      }
    })
  }

  const setTglBukti = function(form) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'EDIT TANGGAL BUKTI'
      })
      data.push({
        name: 'subgrp',
        value: 'PEMUTIHAN SUPIR'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparamfirst`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          isEditTgl = $.trim(response.text);
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
</script>
@endpush()
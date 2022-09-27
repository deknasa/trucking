<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">

          <div class="modal-body">
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>

              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                  TANGGAL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                @php
                $tglbukti = date('d-m-Y');
                @endphp
                <input type="text" name="tglbukti" value="{{$tglbukti}}" id="tglbukti" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  KETERANGAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  BANK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="hidden" name="bank_id" class="form-control">
                  <input type="text" name="bank" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupBankToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupBank" style="z-index: 3;">
                  <div class="col-12">
                    <div id="lookupBank" class="shadow-lg">
                      @include('partials.lookups.bank')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  AGEN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="hidden" name="agen_id" class="form-control">
                  <input type="text" name="agen" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupAgenToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupAgen" style="z-index: 3;">
                  <div class="col-12">
                    <div id="lookupAgen" class="shadow-lg">
                      @include('partials.lookups.agen')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  CABANG <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="hidden" name="cabang_id" class="form-control">
                  <input type="text" name="cabang" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupCabangToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupCabang" style="z-index: 3;">
                  <div class="col-12">
                    <div id="lookupCabang" class="shadow-lg">
                      @include('partials.lookups.cabang')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row form-group">
                      <div class="col-md-2">
                        <label>
                          PELANGGAN <span class="text-danger">*</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="hidden" name="pelanggan_id" class="form-control">
                          <input type="text" name="pelanggan" class="form-control">
                          <div class="input-group-append">
                            <button id="lookupPelangganToggler" class="btn btn-secondary" type="button">...</button>
                          </div>
                        </div>
                        <div class="row position-absolute" id="lookupPelanggan" style="z-index: 3;">
                          <div class="col-12">
                            <div id="lookupPelanggan" class="shadow-lg">
                              @include('partials.lookups.pelanggan')
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-1 offset-md-1">
                        <label>
                          AGEN <span class="text-danger">*</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="hidden" name="agendetail_id" class="form-control">
                          <input type="text" name="agendetail" class="form-control">
                          <div class="input-group-append">
                            <button id="lookupAgenDetailToggler" class="btn btn-secondary" type="button">...</button>
                          </div>
                        </div>
                        <div class="row position-absolute" id="lookupAgenDetail" style="z-index: 3;">
                          <div class="col-12">
                            <div id="lookupAgenDetail" class="shadow-lg">
                              @include('partials.lookups.agendetail')
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="piutangrow">

                    </div>
                    <div class="row mt-5" id="piutang">
                      <div class="col-12 col-md-12">
                        <table id="gridPiutang" style="width: 80%;"></table>
                        <div id="gridPiutangPager"></div>
                      </div>
                    </div>
                    <div class="row mt-5" id="editpiutang">
                      <div class="col-12 col-md-12" id="gridEditPiutangWrapper">
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Simpan
            </button>
            <button id="btnBatal" class="btn btn-secondary" data-dismiss="modal">
              <i class="fa fa-times"></i>
              Batal
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

  $(document).ready(function() {

    $('#btnBatal').click(function(event) {
      $('#gridPiutang').jqGrid('clearGridData')
      $('#piutang').hide()

      $('#gridEditPiutang').jqGrid('clearGridData')


    })

    $('#btnSubmit').click(function(event) {

      let method
      let url
      let form = $('#crudForm')

      if (form.data('action') == 'add') {
        var grid = $("#gridPiutang");
        var rowKey = grid.getGridParam("selrow");
      }
      if (form.data('action') == 'edit') {
        var grid = $("#gridEditPiutang");
        var rowKey = grid.getGridParam("selrow");
      }

      if (form.data('action') != 'delete') {
        if (!rowKey) {
          showDialog("Pilih Row!");
        } else {

          if (form.data('action') == 'add') {
            var selectedIDs = grid.getGridParam("selarrrow");
            for (var i = 0; i < selectedIDs.length; i++) {

              var bayar = jQuery('#' + selectedIDs[i] + '_' + 'bayar').val();
              var keterangandetail = jQuery('#' + selectedIDs[i] + '_' + 'keterangandetail').val();
              var penyesuaian = jQuery('#' + selectedIDs[i] + '_' + 'penyesuaian').val();
              var keteranganpenyesuaian = jQuery('#' + selectedIDs[i] + '_' + 'keteranganpenyesuaian').val();
              var nominallebihbayar = jQuery('#' + selectedIDs[i] + '_' + 'nominallebihbayar').val();

              $('#piutangrow').append("<input type='hidden' name='piutang_id[]' value='" + selectedIDs[i] + "'>");
              $('#piutangrow').append("<input type='hidden' name='bayarppd[]' value='" + bayar + "'>");
              $('#piutangrow').append("<input type='hidden' name='keterangandetailppd[]' value='" + keterangandetail + "'>");
              $('#piutangrow').append("<input type='hidden' name='penyesuaianppd[]' value='" + penyesuaian + "'>");
              $('#piutangrow').append("<input type='hidden' name='keteranganpenyesuaianppd[]' value='" + keteranganpenyesuaian + "'>");
              $('#piutangrow').append("<input type='hidden' name='nominallebihbayarppd[]' value='" + nominallebihbayar + "'>");

              jQuery('#' + selectedIDs[i] + '_' + 'bayar').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'keterangandetail').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'penyesuaian').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'keteranganpenyesuaian').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'nominallebihbayar').remove()
            }
          }

          if (form.data('action') == 'edit') {
            var selectedIDs = grid.getGridParam("selarrrow");

            for (var i = 0; i < selectedIDs.length; i++) {

              let nobukti = $('#gridEditPiutang').jqGrid('getCell', selectedIDs[i], 'piutang_nobukti');
              var bayar = jQuery('#' + selectedIDs[i] + '_' + 'nominal').val();
              var keterangan = jQuery('#' + selectedIDs[i] + '_' + 'keterangan').val();
              var penyesuaian = jQuery('#' + selectedIDs[i] + '_' + 'penyesuaian').val();
              var keteranganpenyesuaian = jQuery('#' + selectedIDs[i] + '_' + 'keteranganpenyesuaian').val();
              var nominallebihbayar = jQuery('#' + selectedIDs[i] + '_' + 'nominallebihbayar').val();

              $('#piutangrow').append("<input type='hidden' name='pelunasan_id[]' value='" + selectedIDs[i] + "'>");
              $('#piutangrow').append("<input type='hidden' name='nobuktippd[]' value='" + nobukti + "'>");
              $('#piutangrow').append("<input type='hidden' name='bayarppd[]' value='" + bayar + "'>");
              $('#piutangrow').append("<input type='hidden' name='keteranganppd[]' value='" + keterangan + "'>");
              $('#piutangrow').append("<input type='hidden' name='penyesuaianppd[]' value='" + penyesuaian + "'>");
              $('#piutangrow').append("<input type='hidden' name='keteranganpenyesuaianppd[]' value='" + keteranganpenyesuaian + "'>");
              $('#piutangrow').append("<input type='hidden' name='nominallebihbayarppd[]' value='" + nominallebihbayar + "'>");

              jQuery('#' + selectedIDs[i] + '_' + 'nominal').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'keterangan').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'penyesuaian').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'keteranganpenyesuaian').remove()
              jQuery('#' + selectedIDs[i] + '_' + 'nominallebihbayar').remove()
            }
          }

        }

      }

      event.preventDefault()

      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
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
      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pelunasanpiutangheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pelunasanpiutangheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pelunasanpiutangheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pelunasanpiutangheader`
          break;
      }

      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

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
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')
          $('#piutangrow').html('')
          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })
          $('#gridPiutang').jqGrid('clearGridData')
          $('#gridEditPiutang').jqGrid('clearGridData')

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
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })

    })
  })

  function createPelunasanPiutangHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)

    $('#gridEditPiutang').jqGrid('clearGridData')
    $('#editpiutang').hide()

    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editPelunasanPiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        $.each(response.detail, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        let agenId = response.detail.agendetail_id
        $('#editpiutang').show()

        getEditPiutang(Id, agenId)
        let tglbukti = response.data.tglbukti
        $('#tglbukti').val($.datepicker.formatDate("dd-mm-yy", new Date(tglbukti)));
      }
    })
  }

  function deletePelunasanPiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        $.each(response.detail, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        let agenId = response.detail.agendetail_id

        $('#gridEditPiutang').trigger('reloadGrid')
        getEditPiutang(Id, agenId)
        let tglbukti = response.data.tglbukti
        $('#tglbukti').val($.datepicker.formatDate("dd-mm-yy", new Date(tglbukti)));
      }
    })
  }

  $(window).on("load", function() {
    var $grid = $("#gridPiutang"),
      newWidth = $grid.closest(".ui-jqgrid").parent().width();
    $grid.jqGrid("setGridWidth", newWidth, true);
  });

  function getPiutang(id) {
    console.log('getpiutang');
    $('#piutang').show()
    let lastsel
    $('#gridPiutang').jqGrid({
      url: `${apiUrl}pelunasanpiutangheader/${id}/getpiutang`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      multiselect: true,
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px'
        },
        {
          label: 'NO BUKTI',
          name: 'nobukti',
          align: 'left'
        },
        {
          label: 'TANGGAL BUKTI',
          name: 'tglbukti',
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
          label: 'NOMINAL PIUTANG',
          name: 'nominal',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalPlaces: 0
          },
          align: "right",
        },
        {
          label: 'SISA',
          name: 'sisa',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalPlaces: 0
          },
          align: "right",
        },
        {
          label: 'BAYAR',
          name: 'bayar',
          editable: true,
          edittype: 'text',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalSeparator: ".",
            decimalPlaces: 2,
            defaultValue: '0.00'
          },
          align: "right",
          editoptions: {
            type: "number",
            dataInit: function(e) {
              e.style.textAlign = 'right';
              e.min = "0";
            }
          }
        },
        {
          label: 'NO BUKTI INVOICE',
          name: 'invoice_nobukti',
          align: 'left'
        },
        {
          label: 'KETERANGAN',
          name: 'keterangandetail',
          editable: true,
          edittype: 'text',
          cellEdit: true,
        },
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          editable: true,
          edittype: 'text',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalSeparator: ".",
            decimalPlaces: 2,
            defaultValue: '0.00'
          },
          align: "right",
          editoptions: {
            type: "number",
            dataInit: function(e) {
              e.style.textAlign = 'right';
              e.min = "0";
            }
          }
        },
        {
          label: 'KETERANGAN PENYESUAIAN',
          name: 'keteranganpenyesuaian',
          editable: true,
          edittype: 'text',
          cellEdit: true,
        },

        {
          label: 'NOMINAL LEBIH BAYAR',
          name: 'nominallebihbayar',
          editable: true,
          edittype: 'text',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalSeparator: ".",
            decimalPlaces: 2,
            defaultValue: '0.00'
          },
          align: "right",
          editoptions: {
            type: "number",
            dataInit: function(e) {
              e.style.textAlign = 'right';
              e.min = "0";
            }
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
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#gridPiutangPager'),
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
        jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      onSelectRow: function(id) {
        if (id && id !== lastsel) {
          // jQuery('#gridPiutang').jqGrid('restoreRow',lastsel);
          jQuery('#gridPiutang').jqGrid('editRow', id, true);
          lastsel = id;

        }

      },
      loadComplete: function(data) {

        if (detectDeviceType() == 'desktop') {
          var $grid = $("#gridPiutang"),
            newWidth = $grid.closest(".ui-jqgrid").parent().width();
          $grid.jqGrid("setGridWidth", newWidth, true);

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#gridPiutang').getGridParam().reccount) {
            indexRow = $('#gridPiutang').getGridParam().reccount - 1
          }
          triggerClick = true

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#gridPiutang [id="${$('#gridPiutang').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#gridPiutang [id="${$('#gridPiutang').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#gridPiutang').getDataIDs()[indexRow] == undefined) {
              $(`#gridPiutang [id="` + $('#gridPiutang').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#gridPiutang').setSelection($('#gridPiutang').getDataIDs()[indexRow])
          }
        }

        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')

        $('.clearsearchclass').click(function() {
          clearColumnSearch()
        })

        // $(this).setGridWidth($('#gridPiutang').prev().width('100%'))
        setHighlight($(this))
      }
    })

    jQuery("#gridPiutang").jqGrid('navGrid', "#gridPiutangPager", {
      edit: false,
      add: false,
      del: false
    });
  }

  function loadDetailPiutang(id) {
    $('#gridPiutang').setGridParam({
      url: `${apiUrl}pelunasanpiutangheader/${id}/getpiutang`,
    }).trigger('reloadGrid')
  }


  function getEditPiutang(Id, agenId) {
    $('#gridEditPiutangWrapper').html(`
      <table id="gridEditPiutang"></table>
      <div id="gridEditPiutangPager"></div>
    `)
    
    // $('#editpiutang').show()
    let lastsel

    $('#gridEditPiutang').jqGrid({
      url: `${apiUrl}pelunasanpiutangheader/${Id}/${agenId}/getpelunasanpiutang`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      multiselect: true,
      colModel: [
        {
          label: 'ID PIUTANG',
          name: 'pelunasanpiutang_id',
          align: 'left',
          hidden: true
        },
        {
          label: 'NO BUKTI',
          name: 'piutang_nobukti',
          align: 'left'
        },
        {
          label: 'TANGGAL BUKTI',
          name: 'tglbukti',
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        
        {
          label: 'NOMINAL PIUTANG',
          name: 'nominalpiutang',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalPlaces: 0
          },
          align: "right",
        },
        {
          label: 'SISA',
          name: 'sisa',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalPlaces: 0
          },
          align: "right",
        },

        {
          label: 'TANGGAL BAYAR',
          name: 'tglbayar',
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'BAYAR',
          name: 'nominal',
          editable: true,
          edittype: 'text',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalSeparator: ".",
            decimalPlaces: 2,
            defaultValue: '0.00'
          },
          align: "right",
          editoptions: {
            type: "number",
            dataInit: function(e) {
              e.style.textAlign = 'right';
              e.min = "0";
            }
          }
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          editable: true,
          edittype: 'text',
          cellEdit: true,
        },
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          editable: true,
          edittype: 'text',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalSeparator: ".",
            decimalPlaces: 2,
            defaultValue: '0.00'
          },
          align: "right",
          editoptions: {
            type: "number",
            dataInit: function(e) {
              e.style.textAlign = 'right';
              e.min = "0";
            }
          }
        },
        {
          label: 'KETERANGAN PENYESUAIAN',
          name: 'keteranganpenyesuaian',
          editable: true,
          edittype: 'text',
          cellEdit: true,
        },

        {
          label: 'NOMINAL LEBIH BAYAR',
          name: 'nominallebihbayar',
          editable: true,
          edittype: 'text',
          formatter: 'number',
          formatoptions: {
            thousandsSeparator: ",",
            decimalSeparator: ".",
            decimalPlaces: 2,
            defaultValue: '0.00'
          },
          align: "right",
          editoptions: {
            type: "number",
            dataInit: function(e) {
              e.style.textAlign = 'right';
              e.min = "0";
            }
          },
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#gridEditPiutangPager'),
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
        jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      onSelectRow: function(id) {
        if (id && id !== lastsel) {
          // jQuery('#gridEditPiutang').jqGrid('restoreRow',lastsel);
          jQuery('#gridEditPiutang').jqGrid('editRow', id, true);
          lastsel = id;

        }

      },
      loadComplete: function(data) {
        if (detectDeviceType() == 'desktop') {
          var $grid = $("#gridEditPiutang"),
            newWidth = $grid.closest(".ui-jqgrid").parent().width();
          $grid.jqGrid("setGridWidth", newWidth, true);

          
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $(this).reccount) {
            indexRow = $(this).reccount - 1
          }
          triggerClick = true

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#gridPiutang [id="${$('#gridPiutang').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#gridPiutang [id="${$('#gridPiutang').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#gridPiutang').getDataIDs()[indexRow] == undefined) {
              $(`#gridPiutang [id="` + $('#gridPiutang').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#gridPiutang').setSelection($('#gridPiutang').getDataIDs()[indexRow])
          }

          
        }

        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')

        $('.clearsearchclass').click(function() {
          clearColumnSearch()
        })

        $(this).setGridWidth($('#gridEditPiutang').prev().width())
        setHighlight($(this))

        let idPelunasan = $("#gridEditPiutang").jqGrid("getCol", "pelunasanpiutang_id");
          for (i = 0; i < idPelunasan.length; i++) { 
              if(idPelunasan[i] != '') {
                var row = $('#gridEditPiutang').getDataIDs()[i]
                    // $('#'+firstRow).click();
                      $('#gridEditPiutang').jqGrid('setSelection', row);
              }
          }
      }
    })

    jQuery("#gridEditPiutang").jqGrid('navGrid', "#gridEditPiutangPager", {
      edit: false,
      add: false,
      del: false
    });
  }

  $('#crudModal').on('hidden.bs.modal', function(event) {
    $('#gridEditPiutangWrapper').html('')
  })
</script>
@endpush()
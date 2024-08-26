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
            <input type="hidden" name="id">

            <!-- <div class="row form-group">
            <div class="row form-group" style="display: none;">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> -->

            <div class="row form-group jenisorder">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JENIS ORDER </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="jenisorder_id">
                <input type="text" name="jenisorder" id="jenisorder" class="form-control jenisorder-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PARENT
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="parent_id">
                <input type="text" name="parent" id="parent" class="form-control parent-lookup" autofocus>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  pelabuhan <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="pelabuhan_id">
                <input type="text" name="pelabuhan" id="pelabuhan" class="form-control pelabuhan-lookup">
              </div>
            </div>

            <div class="row form-group ">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  UPAH SUPIR
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="upah_id">
                <input type="text" name="upah" id="upah" class="form-control upahsupir-lookup">
              </div>
            </div>

            <div class="row form-group ">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PENYESUAIAN
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="penyesuaianupah" id="penyesuaian" class="form-control" readonly>
              </div>
            </div>

            <div class="row form-group ">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  DARI
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="dari_id">
                <input type="text" name="dari" id="dari" class="form-control kotadari-lookup" readonly>
              </div>
            </div>

            <div class="row form-group ">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  SAMPAI
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="sampai_id">
                <input type="text" name="sampai" id="sampai" class="form-control kotasampai-lookup" readonly>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  KOTA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="kota_id">
                <input type="text" name="kota" id="kota" class="form-control kota-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TUJUAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tujuan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PENYESUAIAN
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="penyesuaian" class="form-control">
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  CONTAINER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="container_id">
                <input type="text" name="container" class="form-control container-lookup">
              </div>
            </div>
             <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NOMINAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominal" class="form-control text-right">
              </div>
            </div>--}}
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
              </div>
            </div>
            <div class="row form-group statussistemton">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  SISTEM TON <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statussistemton">
                <input type="text" name="statussistemtonnama" id="statussistemtonnama" class="form-control lg-form statussistemton-lookup">
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NOMINAL TON
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominalton" class="form-control text-right">
              </div>
            </div>--}}
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TGL MULAI BERLAKU <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglmulaiberlaku" class="form-control datepicker">
                </div>
              </div>
            </div>

            <div class="row form-group statuspostingtnl">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS POSTING TNL <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuspostingtnl" class="form-select select2bs4" style="width: 100%;" z-index='3'>
                  <option value="">-- PILIH STATUS POSTING TNL --</option>

                </select>
                <!-- <input type="hidden" name="statuspostingtnl_id" class="filled-row">
                <input type="text" name="statuspostingtnl_name" id="statuspostingtnl_name" class="form-control lg-form statuspostingtnl-lookup filled-row" autocomplete="off"> -->

              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS LANGSIR
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statuslangsir">
                <input type="text" name="statuslangsirnama" id="statuslangsirnama" class="form-control lg-form statuslangsir-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  ZONA </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="zona_id">
                <input type="text" name="zona" id="zona" class="form-control zona-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  Keterangan </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="keterangan">
                <input type="text" name="keterangan" class="form-control keterangan">
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered mt-3 table-bindkeys" id="detailList" style="width:500px">
                <thead class="table-secondary">
                  <tr>
                    <th width="5%">NO</th>
                    <th width="55%">CONTAINER</th>
                    <th width="40%">NOMINAL</th>
                    {{-- <th width="5%">AKSI</th> --}}
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">
                  {{--<tr>
                    <td>1</td>
                    <td>
                      <input type="hidden" name="container_id[]">
                      <input type="text" name="container[]" class="form-control container-lookup">
                    </td>
                    <td>
                      <input type="text" name="nominal[]" class="form-control autonumeric">
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                    </td> 
                  </tr>--}}
                </tbody>
                <tfoot>
                  <tr style="display: none;">
                    <td colspan="2">
                      <p class="text-right font-weight-bold"></p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="nominal"></p>
                    </td>

                    {{-- <td>
                      <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button>
                    </td> --}}
                  </tr>
                </tfoot>
              </table>
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
  let aksiEdit = true;
  let statusAktif
  let statusSistemTon
  let statusPenyesuaianHarga
  let dataMaxLength = []
  var data_id

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', '#addRow', function(event) {
      addRow()
    });

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setNominal()
    })


    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })



    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let tarifId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      let formData = data


      $('#crudForm').find(`[name="nominal[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
      })

      if (aksiEdit == false) {
        // data.push({
        //   name: 'statusaktif',
        //   value: statusAktif
        // })
        data.push({
          name: 'statussistemton',
          value: statusSistemTon
        })
        data.push({
          name: 'statuspenyesuaianharga',
          value: statusPenyesuaianHarga
        })
      }


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
        name: 'accessTokenTnl',
        value: accessTokenTnl
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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}tarif`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}tarif/${tarifId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}tarif/${tarifId}`

          break;
        default:
          method = 'POST'
          url = `${apiUrl}tarif`
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
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
            postData: {
              proses: 'reload'
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
            showDialog(error.responseJSON)
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

    setFormBindKeys(form)

    activeGrid = null
    data_id = $('#crudForm').find('[name=id]').val();

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }


    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()

  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy(data_id)
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function removeEditingBy(id) {
    $.ajax({
      url: `{{ config('app.api_url') }}bataledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: id,
        aksi: 'BATAL',
        table: 'tarif'

      },
      success: response => {
        $("#crudModal").modal("hide")
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
    })
  }

  function createTarif() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    // form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Tarif')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglmulaiberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    setUpRow()

    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusPenyesuaianHargaOptions(form),
        // setStatusSistemTonOptions(form),
        setStatusPostingTnlOptions(form),
        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

    initAutoNumeric(form.find(`[name="nominal[]"]`), {
      minimumValue: 0
    })
    initAutoNumeric(form.find(`[name="nominalton"]`), {
      minimumValue: 0
    })
  }

  function editTarif(tarifId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Tarif')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusPenyesuaianHargaOptions(form),
        // setStatusSistemTonOptions(form),
        // setStatusAktifOptions(form),
        setStatusPostingTnlOptions(form),
        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showTarif(form, tarifId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            if (aksiEdit == false) {
              // form.find('select').each((index, select) => {
              //   let element = $(select)

              //   if (element.data('select2')) {
              //     element.select2('destroy')
              //   }
              // })

              statusAktif = form.find(`[name="statusaktif"]`).val()
              statusSistemTon = form.find(`[name="statussistemton"]`).val()
              statusPenyesuaianHarga = form.find(`[name="statuspenyesuaianharga"]`).val()
              $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)
              let name = $('#crudForm').find(`[name]`).parents('.input-group')
              name.find('.button-clear').attr('disabled', true)
              name.children().find('.lookup-toggler').attr('disabled', true)
              console.log(form.find(`[name="statusaktif"]`).val())
              // form.find(`[name="statusaktif"]`).prop('disabled', 'disabled')
              form.find(`[name="statussistemton"]`).prop('disabled', 'disabled')
              form.find(`[name="statuspenyesuaianharga"]`).prop('disabled', 'disabled')
              // form.find(`[name="tglmulaiberlaku"]`).prop('readonly', true)
              form.find(`[name="zona"]`).prop('readonly', true)
              form.find(`[name="penyesuaian"]`).prop('readonly', true)
              form.find(`[name="tujuan"]`).prop('readonly', true)
              form.find(`[name="kota"]`).prop('readonly', true)
              form.find(`[name="parent"]`).prop('readonly', true)
              form.find(`[name="upahsupir"]`).prop('readonly', true)
            } else {
              $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)

              let name = $('#crudForm').find(`[name]`).parents('.input-group')
              name.find('.button-clear').attr('disabled', false)
              name.children().find('.lookup-toggler').attr('disabled', false)
            }
            // form.find(`[name="kota"]`).parent('.input-group').find('.button-clear').remove()
            // form.find(`[name="kota"]`).parent('.input-group').find('.input-group-append').remove()

            // form.find(`[name="zona"]`).parent('.input-group').find('.button-clear').remove()
            // form.find(`[name="zona"]`).parent('.input-group').find('.input-group-append').remove()

            // form.find(`[name="parent"]`).parent('.input-group').find('.button-clear').remove()
            // form.find(`[name="parent"]`).parent('.input-group').find('.input-group-append').remove()

            // form.find(`[name="upahsupir"]`).parent('.input-group').find('.button-clear').remove()
            // form.find(`[name="upahsupir"]`).parent('.input-group').find('.input-group-append').remove()

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteTarif(tarifId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Tarif')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusPenyesuaianHargaOptions(form),
        // setStatusSistemTonOptions(form),
        // setStatusAktifOptions(form),
        setStatusPostingTnlOptions(form),
        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showTarif(form, tarifId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')

            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)
            $('#crudForm').find(`.ui-datepicker-trigger.btn.btn-easyui.text-easyui-dark`).attr('disabled', true)
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewTarif(tarifId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Tarif')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusPenyesuaianHargaOptions(form),
        // setStatusSistemTonOptions(form),
        // setStatusAktifOptions(form),
        setStatusPostingTnlOptions(form),
        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showTarif(form, tarifId)
          .then(SuratPengantarApprovalInputTripId => {
            form.find('[name]').removeAttr('disabled')
            form.find('select').each((index, select) => {
              let element = $(select)
              if (element.data('select2')) {
                element.select2('destroy')
              }
            })
            form.find('[name]').attr('disabled', 'disabled').css({
              background: '#fff'
            })
            form.find('[name=id]').prop('disabled', false)
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')

            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)
            $('#crudForm').find(`.ui-datepicker-trigger.btn.btn-easyui.text-easyui-dark`).attr('disabled', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  const setTampilan = function(relatedForm) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'UBAH TAMPILAN'
      })
      data.push({
        name: 'text',
        value: 'TARIF'
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
            });
          }
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}tarif/field_length`,
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

            dataMaxLength = response.data
            form.attr('has-maxlength', true)
            resolve()
          },
          error: error => {
            showDialog(error.statusText)
            reject()
          }
        })
      })
    } else {
      return new Promise((resolve, reject) => {
        $.each(dataMaxLength, (index, value) => {
          if (value !== null && value !== 0 && value !== undefined) {
            form.find(`[name=${index}]`).attr('maxlength', value)


          }
        })
        resolve()
      })
    }
  }

  const setStatusPenyesuaianHargaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuspenyesuaianharga]').empty()
      relatedForm.find('[name=statuspenyesuaianharga]').append(
        new Option('-- PILIH STATUS PENYESUAIAN HARGA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "PENYESUAIAN HARGA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPenyesuaianHarga => {
            let option = new Option(statusPenyesuaianHarga.text, statusPenyesuaianHarga.id)

            relatedForm.find('[name=statuspenyesuaianharga]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }

      })
    })
  }


  // const setStatusSistemTonOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statussistemton]').empty()
  //     relatedForm.find('[name=statussistemton]').append(
  //       new Option('-- PILIH SISTEM TON --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "SISTEM TON"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statussistemTon => {
  //           let option = new Option(statussistemTon.text, statussistemTon.id)

  //           relatedForm.find('[name=statussistemton]').append(option).trigger('change')
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  const setStatusPostingTnlOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuspostingtnl]').empty()
      relatedForm.find('[name=statuspostingtnl]').append(
        new Option('-- PILIH POSTING TNL --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS POSTING TNL"
            }]
          })
        },
        success: response => {
          response.data.forEach(statuspostingTnl => {
            let option = new Option(statuspostingTnl.text, statuspostingTnl.id)

            relatedForm.find('[name=statuspostingtnl]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  // const setStatusAktifOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusaktif]').empty()
  //     relatedForm.find('[name=statusaktif]').append(
  //       new Option('-- PILIH STATUS AKTIF --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS AKTIF"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statusAktif => {
  //           let option = new Option(statusAktif.text, statusAktif.id)

  //           relatedForm.find('[name=statusaktif]').append(option).trigger('change')
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  function showTarif(form, tarifId, parent = false) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}tarif/${tarifId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if (parent) {
            delete response.data['id'];
            delete response.data['parent_id'];
            delete response.data['parent'];
            delete response.data['upah_id'];
            delete response.data['upah'];
            delete response.data['dari'];
            delete response.data['sampai'];
            delete response.data['penyesuaianupah'];
            delete response.data['penyesuaian'];
            delete response.data['statuspostingtnl'];
            delete response.data['tglmulaiberlaku'];
            delete response.data['jenisorder_id'];
            delete response.data['jenisorder'];
          }

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            if (index == 'kota') {
              element.data('current-value', value)
            }
            if (index == 'zona') {
              element.data('current-value', value)
            }
            if (index == 'parent') {
              element.data('current-value', value)
            }
            if (index == 'upahsupir') {
              element.data('current-value', value)
            }
            if (index == 'statusaktifnama') {
              element.data('current-value', value)
            }
            if (index == 'statussistemtonnama') {
              element.data('current-value', value)
            }
            if (!parent) {
              if (index == 'statuspostingtnl') {
                element.prop('disabled', true)

              }
            }
            // TAMBAH INI
            if (index == 'statuslangsirnama') {
              element.data('current-value', value)
            }
          })

          if (parent) {
            $('#crudForm').find('[name=tglmulaiberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change')
          }
          if (!parent) {
            $('#detailList tbody').html('')
            $.each(response.detail, (index, detail) => {
              // $.each(response.data.upahsupir_rincian, (index, detail) => {
              let detailRow = $(`
                <tr>
                  <td></td>
                  
                  
                  <input type="hidden" name="detail_id[]" value="${detail.id}">
                  <td>
                    <input type="hidden" name="container_id[]">
                    <input type="text" name="container[]" data-current-value="${detail.container}" class="form-control " readonly>
                  </td>
                  <td>
                    <input type="text" name="nominal[]" class="form-control autonumeric">
                  </td>
                  
                </tr>
              `)

              detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
              detailRow.find(`[name="container[]"]`).val(detail.container)
              detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

              $('#detailList tbody').append(detailRow)

              initAutoNumeric(detailRow.find('.autonumeric'), {
                minimumValue: 0
              })

            })
          } else {
            setUpRow()
          }
          // setuprowshow(userId);

          setRowNumbers()

          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function initLookup() {
    $('.statuspenyesuaianharga-lookup').lookupMaster({
      title: 'Penyesuaian Harga Lookup',
      fileName: 'parameterMaster',
      beforeProcess: function(test) {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'PENYESUAIAN HARGA',
          subgrp: 'PENYESUAIAN HARGA',
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'statuspenyesuaianharga_id',
          searchText: 'statuspenyesuaianharga-lookup',
          singleColumn: true,
          hideLabel: true,
          title: 'Penyesuaian Harga',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (statuspenyesuaianharga, element) => {
        $('#crudForm [name=statuspenyesuaianharga_id]').first().val(statuspenyesuaianharga.id)
        element.val(statuspenyesuaianharga.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=statuspenyesuaianharga_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.statuspostingtnl-lookup').lookupMaster({
      title: 'Posting TNL Lookup',
      fileName: 'parameterMaster',
      beforeProcess: function(test) {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS POSTING TNL',
          subgrp: 'STATUS POSTING TNL',
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'statuspostingtnl_id',
          searchText: 'statuspostingtnl-lookup',
          singleColumn: true,
          hideLabel: true,
          title: 'Posting TNL',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (statuspostingtnl, element) => {
        $('#crudForm [name=statuspostingtnl_id]').first().val(statuspostingtnl.id)
        element.val(statuspostingtnl.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=statuspostingtnl_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.container-lookup').lookup({
      title: 'Container Lookup',
      fileName: 'container',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (container, element) => {
        $('#crudForm [name=container_id]').first().val(container.id)
        element.val(container.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=container_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.kota-lookup').lookupMaster({
      title: 'Kota Lookup',
      fileName: 'kotaMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'kota_id',
          searchText: 'kota-lookup',
          singleColumn: '',
          hideLabel: '',
          title: 'kota',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudForm [name=kota_id]').first().val(kota.id)
        element.val(kota.keterangan)
        element.data('currentValue', element.val())
        $('#crudForm [name=tujuan]').val(kota.keterangan)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kota_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pelabuhan-lookup').lookup({
      title: 'pelabuhan Lookup',
      fileName: 'kota',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          StatusPelabuhan : 'PELABUHAN',
        }
      },
      onSelectRow: (pelabuhan, element) => {
        $('#crudForm [name=pelabuhan_id]').first().val(pelabuhan.id)
        element.val(pelabuhan.kodekota)
        element.data('currentValue', element.val())
        $('#crudForm [name=tujuan]').val(pelabuhan.kodekota)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pelabuhan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    

    $('.zona-lookup').lookupMaster({
      title: 'Zona Lookup',
      fileName: 'zonaMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'zona_id',
          searchText: 'zona-lookup',
          singleColumn: '',
          hideLabel: '',
          title: 'zona Lookup',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (zona, element) => {
        $('#crudForm [name=zona_id]').first().val(zona.id)
        element.val(zona.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=zona_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.jenisorder-lookup').lookupMaster({
      title: 'Jenis Order Lookup',
      fileName: 'jenisorderMaster',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'jenisorder_id',
          searchText: 'jenisorder-lookup',
          singleColumn: '',
          hideLabel: '',
          title: 'jenisorder',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (jenisorder, element) => {
        $('#crudForm [name=jenisorder_id]').first().val(jenisorder.id)
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=jenisorder_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.parent-lookup').lookupMaster({
      title: 'Tarif Lookup',
      fileName: 'tarifMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          jenisOrder: $('#crudForm [name=jenisorder]').val(),
          isParent: true,
          searching: 1,
          valueName: 'parent_id',
          searchText: 'parent-lookup',
          singleColumn: '',
          hideLabel: '',
          title: 'parent',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (tarif, element) => {
        let form = $('#crudForm')
        showTarif(form, tarif.id, true)
        element.val(tarif.tujuan)
        element.data('currentValue', element.val())
        $('#crudForm [name=parent_id]').first().val(tarif.id)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=parent_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.upahsupir-lookup').lookupMaster({
      title: 'Upah Supir Lookup',
      fileName: 'upahsupirMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {


          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'upahsupir_id',
          searchText: 'upahsupir-lookup',
          singleColumn: '',
          hideLabel: '',
          title: 'upahsupir',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (upahsupir, element) => {
        $('#crudForm [name=upah_id]').val(upahsupir.id)

        $('#crudForm [name=penyesuaianupah]').val(upahsupir.penyesuaian)
        $('#crudForm [name=dari]').val(upahsupir.kotadari_id)
        $('#crudForm [name=sampai]').val(upahsupir.kotasampai_id)
        element.val(`${upahsupir.kotadari_id} - ${upahsupir.kotasampai_id}`)

        element.data('currentValue', element.val())
        // clearTrado()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        tarifrincianId = 0
        $('#crudForm [name=upah_id]').val('')
        clearUpahSupir()
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.statuslangsir-lookup`).lookupMaster({
      title: 'Status Langsir Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS langsir',
          subgrp: 'STATUS langsir',
          searching: 1,
          valueName: `statuslangsir`,
          searchText: `status-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status langsir'
        };
      },
      onSelectRow: (status, element) => {
        $('#crudForm [name=statuslangsir]').first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = $('#crudForm [name=statuslangsir]').first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    })
    $(`.statusaktif-lookup`).lookupMaster({
      title: 'Status Aktif Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
          searching: 1,
          valueName: `statusaktif`,
          searchText: `statusaktif-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Aktif'
        };
      },
      onSelectRow: (status, element) => {
        $('#crudForm [name=statusaktif]').first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusaktif"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statussistemton-lookup`).lookupMaster({
      title: 'Status Sistem Ton Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'SISTEM TON',
          subgrp: 'SISTEM TON',
          searching: 1,
          valueName: `statussistemton`,
          searchText: `statussistemton-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Sistem Ton'
        };
      },
      onSelectRow: (statussistemton, element) => {
        $('#crudForm [name=statussistemton]').first().val(statussistemton.id)
        element.val(statussistemton.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statussistemton"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });
  }

  function clearUpahSupir() {

    $('#crudForm [name=upah_id]').val('')
    $('#crudForm [name=upah]').data('currentValue', '')
    $('#crudForm [name=dari_id]').val('')
    $('#crudForm [name=sampai_id]').val('')
    $('#crudForm [name=dari]').val('')
    $('#crudForm [name=sampai]').val('')
    $('#crudForm [name=penyesuaian]').val('')
  }


  function setUpRow() {
    $.ajax({
      url: `${apiUrl}tarif/default`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')
        $.each(response.detail, (index, detail) => {

          let detailRow = $(`
            <tr>
              <td></td>
              <input type="hidden" name="detail_id[]" value="0">
              
              <td>
                <input type="hidden" name="container_id[]">
                <input type="text" name="container[]" data-current-value="${detail.container}" class="form-control" readonly>
              </td>
              <td>
                <input type="text" name="nominal[]" class="form-control autonumeric">
              </td>
            </tr>
            `)
          detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
          detailRow.find(`[name="container[]"]`).val(detail.container)

          // initAutoNumeric(detailRow.find('.autonumeric'))
          // setNominal()

          $('#detailList tbody').append(detailRow)
          initAutoNumeric(detailRow.find('.autonumeric'), {
            minimumValue: 0
          })
        })
        setRowNumbers()
      }
    })

  }


  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }

    setRowNumbers()
    setNominal()

  }


  function setNominal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#nominal').set(total)
  }


  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="container_id[]">
          <input type="text" name="container[]" class="form-control container-lookup">
        </td>
        <td>
          <input type="text" name="nominal[]" class="form-control autonumeric">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)
    $('#detailList tbody').append(detailRow)

    $('.container-lookup').last().lookup({
      title: 'Container Lookup',
      fileName: 'container',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (container, element) => {
        $(`#crudForm [name="container_id[]"]`).last().val(container.id)
        element.val(container.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="container_id[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })



    initAutoNumeric(detailRow.find('.autonumeric'))
    setRowNumbers()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}tarif/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            // let element = form.find(`[name="statusaktif"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function approvenonaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}tarif/approvalnonaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsTarif
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsTarif = []
        $('#gs_').prop('checked', false)
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

  }


  function cekValidasidelete(Id, aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}tarif/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: aksi
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          if (!response.editblok) {
            if (aksi == 'EDIT') {
              aksiEdit = false
              editTarif(selectedId)
            } else {
              showDialog(response.message['keterangan'])
            }
          } else {
            showDialog(response.message['keterangan'])
          }
        } else {
          if (aksi == 'EDIT') {
            aksiEdit = true
            editTarif(selectedId)
          } else {
            deleteTarif(selectedId)
          }
        }

      }
    })
  }
</script>
@endpush()
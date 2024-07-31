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

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">NO BUKTI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group kasgantung_nobukti">
              <div class="col-12 col-md-2">
                <label class="col-form-label">NO BUKTI KGT</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kasgantung_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">TANGGAL</label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">

                  <input type="text" name="tglbukti" id="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>

            <hr>
            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card" style="max-height:500px; overflow-y: scroll;">
                  <div class="card-body">
                    <!-- <div class="table-responsive"> -->
                    <table class="table table-bordered table-bindkeys" id="detailList" style="width: 2150px;">
                      <thead>
                        <tr>
                          <th width="2%">No</th>
                          <th width="13%">Trado</th>
                          <th width="5%">supir serap</th>
                          <th width="5%">tambahan trado</th>
                          <th width="10%">Supir</th>
                          <th width="10%" class="uangjalan">Uang Jalan</th>
                          <th width="16%">Keterangan</th>
                          <th width="10%" class="kolom-jeniskendaraan">jenis kendaraan</th>
                          <th width="10%">Status</th>
                          <th width="6%">jlh trip</th>
                          <th width="8%">tgl batas</th>
                          {{-- <th width="2%">Aksi</th> --}}
                        </tr>
                      </thead>
                      <tbody id="table_body" class="form-group">
                        <tr>
                          {{-- <td>1</td>
                    <td>
                      <input type="hidden" name="trado_id[]">
                      <input type="text" name="trado[]" class="form-control trado-lookup">
                    </td>
                    <td>
                      <input type="hidden" name="supir_id[]">
                      <input type="text" name="supir[]" class="form-control supir-lookup">
                    </td>
                    <td>
                      <input type="text" name="keterangan_detail[]" class="form-control">
                    </td>
                    <td>
                      <input type="hidden" name="absen_id[]">
                      <input type="text" name="absen" class="form-control absentrado-lookup">
                    </td>
                    <td>
                      <input type="text" class="form-control inputmask-time" name="jlhtrip[]"></input>
                    </td>
                    <td>
                      <input type="text" class="form-control inputmask-time" name="tglbatas[]"></input>
                    </td>
                    <td>
                      <input type="text" class="form-control uangjalan autonumeric" name="uangjalan[]">
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                    </td> --}}

                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="5">
                            <h5 class="text-right font-weight-bold">TOTAL:</h5>
                          </td>
                          <td>
                            <h5 id="total" class="text-right font-weight-bold"></h5>
                          </td>
                          {{-- <td>
                      <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                    </td>--}}
                        </tr>
                      </tfoot>
                    </table>
                    <!-- </div> -->
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

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    Inputmask("datetime", {
      inputFormat: "HH:MM",
      max: 24
    }).mask(".inputmask-time");

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="uangjalan[]"]`, function(event) {
      setTotal()
    })

    $(document).on('click', '#btnSubmit', function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="uangjalan[]"`).each((index, element) => {
        data.filter((row) => row.name === 'uangjalan[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="uangjalan[]"]`)[index])
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
        name: 'tgldari',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })
      data.push({
        name: 'tglsampai',
        value: $('#tglsampaiheader').val()
      })
      // let inputs = data.filter((row) => row.name === 'uangjalan[]')

      // inputs.forEach((input, index) => {
      //   if (input.value !== '') {
      //     input.value = AutoNumeric.getNumber($('#crudForm').find('[name="uangjalan[]"]')[index])
      //   }
      // });

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}absensisupirheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}absensisupirheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
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
          $('#crudModal').modal('hide')
          $('#crudForm').trigger('reset')

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
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

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    // getMaxLength(form)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {
    
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'absensisupirheader');

    fetch(`{{ config('app.api_url') }}removeedit`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        body: formData,
        keepalive: true

      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        $("#crudModal").modal("hide");
      })
      .catch(error => {
        // Handle error
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();
          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON);
        }
      })
    
  }



  function setTotal() {
    let nominalDetails = $(`#table_body [name="uangjalan[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createAbsensiSupir() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')

    $('#table_body').html('')
    $('#crudModalTitle').text('Add Absensi Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setUpRow()
      ])
      .then(() => {
        setTampilan(form).then(() => {
            setTotal()
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
          })
          .catch((error) => {
            showDialog(error.responseJSON)
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
        value: 'ABSENSISUPIR'
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
            $('#detailList tfoot').hide()
          }

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function setUpRow() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}absensisupirheader/default`,
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
                    <td>
                      <input type="hidden" name="trado_id[]">
                      <input type="text" name="trado[]"  data-current-value="${detail.trado}" class="form-control" readonly>
                    </td>
                    <td>
                      <input type="hidden" name="supir_id[]">
                      <input type="text" name="supir[]" class="form-control supir-lookup">
                    </td>
                    <td>
                      <input type="text" name="keterangan_detail[]" class="form-control">
                    </td>
                    <td>
                      <input type="hidden" name="absen_id[]">
                      <input type="text" name="absen" class="form-control absentrado-lookup">
                    </td>
                    <td>
                      <input type="text" class="form-control autonumeric" name="jlhtrip[]" disabled></input>
                    </td>
                    <td>
                      <input type="text" class="form-control autonumeric" name="tglbatas[]" disabled></input>
                    </td>
                    <td class="uangjalan">
                      <input type="text" class="form-control uangjalan autonumeric" name="uangjalan[]">
                    </td>              
            </tr>
            `)
            detailRow.find(`[name="trado_id[]"]`).val(detail.trado_id)
            detailRow.find(`[name="trado[]"]`).val(detail.trado)
            initAutoNumeric(detailRow.find('.autonumeric'))
            $('#detailList tbody').append(detailRow)

            detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
            $('#detailList tbody').append(detailRow)
            Inputmask("datetime", {
              inputFormat: "HH:MM",
              max: 24
            }).mask(".inputmask-time");


            $(document).find('.supir-lookup').last().lookup({
              title: 'Supir Lookup',
              fileName: 'supir',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (supir, element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)

                element.val(supir.namasupir)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

            $('.trado-lookup').last().lookup({
              title: 'Trado Lookup',
              fileName: 'trado',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (trado, element) => {
                element.parents('td').find(`[name="trado_id[]"]`).val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="trado_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

            $('.absentrado-lookup').last().lookup({
              title: 'Absen Trado Lookup',
              fileName: 'absentrado',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (absentrado, element) => {
                element.parents('td').find(`[name="absen_id[]"]`).val(absentrado.id)
                element.val(absentrado.keterangan)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="absen_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

          })
          setRowNumbers()
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })

  }

  function editAbsensiSupir(absensiId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Absensi Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()



    Promise
      .all([
        showAbsensiSupir(form, absensiId)
      ])
      .then(() => {
        setTampilan(form).then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            form.find('[name=tglbukti]').attr('readonly', true)
            form.find('[name=tglbukti]').siblings('.input-group-append').remove()

            if (!activeKolomJenisKendaraan) {
              $(`.kolom-jeniskendaraan`).hide()
            }

            if (isTradoMilikSupir == 'YA') {

              form.find(`[name="supir[]"]`).prop('readonly', true)
              form.find(`[name="supir[]"]`).parent('.input-group').find('.button-clear').remove()
              form.find(`[name="supir[]"]`).parent('.input-group').find('.input-group-append').remove()
            }
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })

      })
  }

  function deleteAbsensiSupir(absensiId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-times"></i>
              Delete
    `)
    $('#crudModalTitle').text('Delete Absensi Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        showAbsensiSupir(form, absensiId)
      ])
      .then(() => {
        setTampilan(form).then(() => {
            $('#crudModal').modal('show')
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            form.find('[name=tglbukti]').attr('readonly', true)
            form.find('[name=tglbukti]').siblings('.input-group-append').remove()
            if (!activeKolomJenisKendaraan) {
              $(`.kolom-jeniskendaraan`).hide()
            }
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewAbsensiSupir(absensiId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled', true)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Absensi Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        showAbsensiSupir(form, absensiId)
      ])
      .then(() => {
        setTampilan(form)
          .then(absensiId => {
            setFormBindKeys(form)
            initSelect2(form.find('.select2bs4'), true)
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
            form.find('[name=tglbukti]').attr('readonly', true)
            form.find('[name=tglbukti]').siblings('.input-group-append').remove()

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
            name.attr('disabled', true)
            name.find('.lookup-toggler').remove()
            nameFind.find('button.button-clear').remove()

            if (!activeKolomJenisKendaraan) {
              $(`.kolom-jeniskendaraan`).hide()
            }
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function showAbsensiSupir(form, absensiId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}absensisupirheader/${absensiId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
          })
          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            let detailRow = $(`
            <tr class="index${index}">
              <td></td>
              <td>
                <input type="hidden" name="trado_id[]" value="${detail.trado_id}">
                <input type="text" name="trado[]" data-current-value="${detail.trado}" class="form-control" value="${detail.trado}" readonly>
              </td>
              <td>
                <input type="text" class="form-control" name="statussupirserap[]" value="${detail.statussupirserap}" readonly>
              </td>
              <td>
                <input type="text" class="form-control" name="statustambahantrado[]" value="${detail.statustambahantrado}" readonly>
              </td>
              <td>
                <input type="hidden" name="supir_old[]" id="supir_old_row_${index}" value="${detail.namasupir_old}">
                <input type="hidden" name="supir_id_old[]" id="supir_old_id_row_${index}" value="${detail.supir_id_old}">

                <input type="hidden" name="supir_id[]" id="supir_id_row_${index}">
                <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup" id="supir_row_${index}" value="${detail.supir}">
              </td>
              <td class="uangjalan">
                <input type="text" id="uangjalan_row_${index}" class="form-control uangjalan autonumeric" name="uangjalan[]" value="${detail.uangjalan}" ${detail.uangjalan_readonly}>
              </td>
              <td>
                <input type="text" name="keterangan_detail[]" class="form-control" value="${detail.keterangan}">
              </td>
              <td class='kolom-jeniskendaraan'>
                <input type="hidden" name="statusjeniskendaraan[]" value="">
                <input type="text" name="jeniskendaraan[]"  data-current-value="" id="jeniskendaraan-${index}" class="form-control  jeniskendaraan-lookup" value="">
              </td>
              <td>
                <input type="hidden" name="absen_id[]" value="${detail.absen_id}">
                <input type="text" name="absen"  data-current-value="${detail.absen}" class="form-control absentrado-lookup" value="${detail.absen}">
              </td>
              <td>
                <input type="text" class="form-control autonumeric" name="jlhtrip[]" value="${detail.jlhtrip}" disabled></input>
                <input type="text" class="form-control inputmask-time" hidden name="jam[]" value="${detail.jam}"></input>
              </td>
              <td>
                <input type="text" class="form-control autonumeric" name="tglbatas[]" value="${detail.tglbatas}" disabled></input>
              </td>
              <input type="hidden" name="namasupir_old[]" value="${detail.namasupir_old}">
              <input type="hidden" name="supirold_id[]" value="${detail.supir_id_old}">

            </tr>
            `)

            detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
            if (detail.statusjeniskendaraan) {
              detailRow.find(`[name="statusjeniskendaraan[]"]`).val(detail.statusjeniskendaraan)
              detailRow.find(`[name="jeniskendaraan[]"]`).val(detail.statusjeniskendaraannama)
              detailRow.find(`[name="jeniskendaraan[]"]`).attr("data-current-value", detail.statusjeniskendaraannama);
            }else{
              detailRow.find(`[name="statusjeniskendaraan[]"]`).val(response.attributes.defaultJenis.id)
              detailRow.find(`[name="jeniskendaraan[]"]`).val(response.attributes.defaultJenis.text)
              detailRow.find(`[name="jeniskendaraan[]"]`).attr("data-current-value", response.attributes.defaultJenis.text);
            }
            // getabsentrado(detail.absen_id).then((response) => {
            //       setSupirEnableIndex(response, index)
            //     }).catch(() => {
            //       setSupirEnableIndex(false, index)
            //     })
            initAutoNumeric(detailRow.find(`[name="uangjalan[]"]`))
            $('#detailList tbody').append(detailRow)
            Inputmask("datetime", {
              inputFormat: "HH:MM",
              max: 24
            }).mask(".inputmask-time");


            $(document).find('.supir-lookup').last().lookup({
              title: 'Supir Lookup',
              fileName: 'supir',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (supir, element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)

                element.val(supir.namasupir)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

            $('.trado-lookup').last().lookup({
              title: 'Trado Lookup',
              fileName: 'trado',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (trado, element) => {
                element.parents('td').find(`[name="trado_id[]"]`).val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="trado_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

            $('.absentrado-lookup').last().lookup({
              title: 'Absen Trado Lookup',
              fileName: 'absentrado',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',
                  trado_id: detail.trado_id,
                  supir_id: detail.supir_id,
                  supirold_id: detail.supir_id_old,
                  tglabsensi: $('#tglbukti').val(),
                  dari: 'mandorabsensisupir',
                }
              },
              onSelectRow: (absentrado, element) => {
                getabsentrado(absentrado.id).then((response) => {
                  setSupirEnableIndex(response, index)
                }).catch(() => {
                  setSupirEnableIndex(false, index)
                })
                element.parents('td').find(`[name="absen_id[]"]`).val(absentrado.id)
                element.val(absentrado.keterangan)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="absen_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
                setSupirEnableIndex(false, index)
              }
            })
            $(`.jeniskendaraan-lookup`).last().lookupMaster({
              title: 'Jenis Kendaraan',
              fileName: 'parameterMaster',
              typeSearch: 'ALL',
              searching: 1,
              beforeProcess: function() {
                this.postData = {
                  url: `${apiUrl}parameter/combo`,
                  grp: 'STATUS JENIS KENDARAAN',
                  subgrp: 'STATUS JENIS KENDARAAN',
                  searching: 1,
                  valueName: `jeniskendaraan_id`,
                  searchText: `jeniskendaraan-${index}`,
                  singleColumn: true,
                  hideLabel: true,
                  title: 'JENIS KENDARAAN'
                };
              },
              onSelectRow: (status, element) => {
                element.parents('td').find(`[name="jeniskendaraan_id[]"]`).val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'));
              },
              onClear: (element) => {
                element.parents('td').find(`[name="jeniskendaraan_id[]"]`).val('')
                element.val('');
                element.data('currentValue', element.val());
              },
            });
            $('.jeniskendaraan-lookup').last().parents('td').children().find('input').attr('disabled', true)
            $('.jeniskendaraan-lookup').last().parents('td').children().find('.lookup-toggler').attr('disabled', true)
            $('.jeniskendaraan-lookup').last().parents('td').children().find('.button-clear').attr('disabled', true)
            if (detail.berlaku == 0) {
              $('.absentrado-lookup').last().parents('td').children().find('input').attr('disabled', true)
              $('.absentrado-lookup').last().parents('td').children().find('.lookup-toggler').attr('disabled', true)
              $('.absentrado-lookup').last().parents('td').children().find('.button-clear').attr('disabled', true)
            }
            if ( detail.pujnobukti_readonly == "readonly") {
              $('.absentrado-lookup').last().parents('td').children().find('input').attr('disabled', true)
              $('.absentrado-lookup').last().parents('td').children().find('.lookup-toggler').attr('disabled', true)
              $('.absentrado-lookup').last().parents('td').children().find('.button-clear').attr('disabled', true)
              
              $('.jeniskendaraan-lookup').last().parents('td').children().find('input').attr('disabled', true)
              $('.jeniskendaraan-lookup').last().parents('td').children().find('.lookup-toggler').attr('disabled', true)
              $('.jeniskendaraan-lookup').last().parents('td').children().find('.button-clear').attr('disabled', true)
              
              $('.uangjalan').last().attr('readonly', true)
             
              $('.supir-lookup').last().parents('td').children().find('input').attr('disabled', true)
              $('.supir-lookup').last().parents('td').children().find('.lookup-toggler').attr('disabled', true)
              $('.supir-lookup').last().parents('td').children().find('.button-clear').attr('disabled', true)
            }
            if (detail.tidakadasupir == "readonly") {
              setSupirEnableIndex({supir:1}, index,detail.supir_id)
            }
            if (detail.tgltrip) {
              setRowDisable(index);
            }
          })

          setRowNumbers()
          setTotal()
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

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="trado_id[]">
          <input type="text" name="trado[]" class="form-control trado-lookup readonly">
        </td>
        <td>
          <input type="hidden" name="supir_id[]">
          <input type="text" name="supir[]" class="form-control supir-lookup">
        </td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">
        </td>
        <td>
          <input type="hidden" name="absen_id[]">
          <input type="text" name="absen" class="form-control absentrado-lookup">
        </td>
        <td>
          <input type="text" class="form-control autonumeric" name="jlhtrip[]" disabled></input>
        </td>
        <td>
          <input type="text" class="form-control uangjalan autonumeric" name="uangjalan[]">
        </td>
    

      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    Inputmask("datetime", {
      inputFormat: "HH:MM",
      max: 24
    }).mask(".inputmask-time");

    $('.supir-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $(`#crudForm [name="supir_id[]"]`).last().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="supir_id[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.trado-lookup').last().lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (trado, element) => {
        $(`#crudForm [name="trado_id[]"]`).last().val(trado.id)
        element.val(trado.kodetrado)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="trado_id[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }

    })

    $('.absentrado-lookup').last().lookup({
      title: 'Absen Trado Lookup',
      fileName: 'absentrado',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (absentrado, element) => {
        $(`#crudForm [name="absen_id[]"]`).last().val(absentrado.id)
        element.val(absentrado.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="absen_id[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    initAutoNumeric(detailRow.find('.autonumeric'))

    setRowNumbers()
  }

  function deleteRow(row) {
    let countRow = $('.rmv').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }
    setRowNumbers()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}absensisupirheader/field_length`,
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
          showDialog(error.statusText)
        }
      })
    }
  }

  function approvalFinalAbsensi(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}absensisupirheader/approvalfinalabsensi`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        bukti: selectedbukti ,
        table: 'absensisupirheader' ,
        statusapproval: 'statusapprovalfinalabsensi' ,

      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
  }



  function cekValidasi(Id, Aksi) {

    $.ajax({
      url: `{{ config('app.api_url') }}absensisupirheader/${Id}/cekvalidasi`,
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
          showDialog(response)
        } else {
          if (Aksi == 'PRINTER BESAR') {
            window.open(`{{ route('absensisupirheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('absensisupirheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          }
          if (Aksi == 'EDIT') {
            editAbsensiSupir(Id)
          }
          if (Aksi == 'DELETE') {
            deleteAbsensiSupir(Id)
          }
        }

        // var kodenobukti = response.kodenobukti
        // if (kodenobukti == '1') {
        //   var kodestatus = response.kodestatus
        //   if (kodestatus == '1') {
        //     showDialog(response.message['keterangan'])
        //   } else {
        //     if (Aksi == 'PRINTER BESAR') {
        //       window.open(`{{ route('absensisupirheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
        //     } else if (Aksi == 'PRINTER KECIL') {
        //       window.open(`{{ route('absensisupirheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
        //     }
        //     if (Aksi == 'EDIT') {
        //       editAbsensiSupir(Id)
        //     }
        //     if (Aksi == 'DELETE') {
        //       deleteAbsensiSupir(Id)
        //     }
        //   }

        // } else {
        //   showDialog(response.message['keterangan'])
        // }
      }
    })
  }

  function setSupirEnableIndex(kodeabsensitrado, rowId,supir = false) {
    var supirText = $(`#supir_row_${rowId}`).parents('.input-group').children()

    if (kodeabsensitrado.supir) {
      if (!supir) {
        $(`#supir_row_${rowId}`).val('')
        $(`#supir_id_row_${rowId}`).val('')
        
      }
      $(`#supir_id_row_${rowId}`).prop('readonly', true);
      $(`#supir_row_${rowId}`).prop('readonly', true);
      $(supirText[1]).attr('disabled', true)
      $(supirText[2]).find('.lookup-toggler').attr('disabled', true)
    } else {
      $(`#supir_id_row_${rowId}`).prop('readonly', false);
      $(`#supir_row_${rowId}`).prop('readonly', false);
      $(supirText[1]).attr('disabled', false)
      $(supirText[2]).find('.lookup-toggler').attr('disabled', false)
      let namasupir_old = $(`#supir_old_row_${rowId}`).val()
      let supir_id_old = $(`#supir_old_id_row_${rowId}`).val()
      if (namasupir_old != null && supir_id_old != 0 && namasupir_old != 'null' && supir_id_old != '0') {
        $(`#supir_row_${rowId}`).val(namasupir_old)
        $(`#supir_id_row_${rowId}`).val(supir_id_old)
      }

    }
    if (kodeabsensitrado.uang) {
      $(`#uangjalan_row_${rowId}`).attr('readonly', true)
    } else {
      $(`#uangjalan_row_${rowId}`).attr('readonly', false)
    }


  }

  function setRowDisable(rowId) {
    $(`.index${rowId} input`).attr('readonly', true);
    $(`.index${rowId} button`).attr('disabled', true);
  }


  function getabsentrado(id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}mandorabsensisupir/${id}/getabsentrado`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        success: response => {
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function initLookup() {
    $('.supir-lookup').lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $(`#crudForm [name="supir_id[]"]`).first().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="supir_id"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })

    $('.trado-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (trado, element) => {
        $(`#crudForm [name="trado_id[]"]`).first().val(trado.id)
        element.val(trado.kodetrado)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="trado_id[]"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })

    $('.absentrado-lookup').lookup({
      title: 'Absen Trado Lookup',
      fileName: 'absentrado',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (absentrado, element) => {
        $(`#crudForm [name="absen_id[]"]`).first().val(absentrado.id)
        element.val(absentrado.kodetrado)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="absen_id"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush
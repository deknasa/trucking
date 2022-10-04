<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalTitle">Create Absensi Supir</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI KGT</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kasgantung_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>

            <hr>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Trado</th>
                  <th>Supir</th>
                  <th>Uang Jalan</th>
                  <th>Status</th>
                  <th>Jam</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
              </tbody>
            </table>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Simpan
            </button>
            <button class="btn btn-secondary" data-dismiss="modal">
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
  let modalBody = $('#crudModal').find('.modal-body').html()

  $(document).ready(function() {
    $(document).on('click', '#btnSubmit', function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let id = form.find('[name=id]').val()
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

      let inputs = data.filter((row) => row.name === 'uangjalan[]')

      inputs.forEach((input, index) => {
        if (input.value !== '') {
          input.value = AutoNumeric.getNumber($('#crudForm').find('[name="uangjalan[]"]')[index])
        }
      });

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}absensisupirheader/${id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}absensisupirheader/${id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
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
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          indexRow = response.data.position - 1

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })
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

  $('#crudModal').on('shown.bs.modal', () => {
    setFormBindKeys($('#crudForm'))
    activeGrid = null
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createAbsensiSupir() {
    $('#crudForm').trigger('reset')
    $('#crudForm').find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Create Absensi Supir')
    $('#crudModal').modal('show')
    $('#crudForm').data('action', 'add')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    let supirs
    let statuses

    $.ajax({
      url: `${apiUrl}trado`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $(document).find('#crudForm #table_body').html('')

        $.each(response.data, (index, trado) => {
          $(document).find('#crudForm #table_body').append(`
            <tr>
              <input type="hidden" name="trado_id[]" value="${trado.id}">
              <td>${trado.keterangan}</td>
              <td>
                <select class="form-control w-100" name="supir_id[]">
                  <option hidden selected value="">-- PILIH SUPIR --</option>
                </select>
              </td>
              <td>
                  <input type="text" class="form-control autonumeric" name="uangjalan[]"></input>
              </td>
              <td>
                <select class="form-control w-100" name="absen_id[]">
                  <option hidden selected value="">-- PILIH STATUS --</option>
                </select>
              </td>
              <td>
                  <input type="text" class="form-control inputmask-time" name="jam[]"></input>
              </td>
              <td>
                  <input type="text" class="form-control" name="keterangan_detail[]"></input>
              </td>
            <tr>
          `)
        })

        initSelect2($('#crudForm').find('select'))
        initAutoNumeric($('#crudForm').find('.autonumeric'))
        Inputmask("datetime", {
          inputFormat: "HH:MM",
          max: 24
        }).mask(".inputmask-time");
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}supir`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let supirElements = $(`#crudForm [name="supir_id[]"]`)

        supirElements.map((index, supirElement) => {
          response.data.map((supir, index) => {
            supirElement.append(
              new Option(supir.namasupir, supir.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}absentrado`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let statusElements = $(`#crudForm [name="absen_id[]"]`)

        statusElements.map((index, statusElement) => {
          response.data.map((status, index) => {
            statusElement.append(
              new Option(status.keterangan, status.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function editAbsensiSupir(id) {
    $('#crudForm').data('action', 'edit')
    $('#crudForm').trigger('reset')
    $('#crudForm').find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Absensi Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    let supirs
    let statuses
    let absensiSupir

    $.ajax({
      url: `${apiUrl}trado`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $(document).find('#crudForm #table_body').html('')

        $.each(response.data, (index, trado) => {
          $(document).find('#crudForm #table_body').append(`
            <tr>
              <input type="hidden" name="trado_id[]" value="${trado.id}">
              <td>${trado.keterangan}</td>
              <td>
                <select class="form-control w-100" name="supir_id[]"></select>
              </td>
              <td>
                  <input type="text" class="form-control autonumeric" name="uangjalan[]"></input>
              </td>
              <td>
                <select class="form-control w-100" name="absen_id[]"></select>
              </td>
              <td>
                  <input type="text" class="form-control inputmask-time" name="jam[]"></input>
              </td>
              <td>
                  <input type="text" class="form-control" name="keterangan_detail[]"></input>
              </td>
            <tr>
          `)
        })

        initSelect2($('#crudForm').find('select'))
        Inputmask("datetime", {
          inputFormat: "HH:MM",
          max: 24
        }).mask(".inputmask-time");
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}supir`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let supirElements = $(`#crudForm [name="supir_id[]"]`)

        supirElements.map((index, supirElement) => {
          response.data.map((supir, index) => {
            supirElement.append(
              new Option(supir.namasupir, supir.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}absentrado`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let statusElements = $(`#crudForm [name="absen_id[]"]`)

        statusElements.map((index, statusElement) => {
          response.data.map((status, index) => {
            statusElement.append(
              new Option(status.keterangan, status.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}absensisupirheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#crudForm').find(`[name="id"]`).val(response.data.id)
        $('#crudForm').find(`[name="nobukti"]`).val(response.data.nobukti)
        $('#crudForm').find(`[name="kasgantung_nobukti"]`).val(response.data.kasgantung_nobukti)
        $('#crudForm').find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
        $('#crudForm').find(`[name="keterangan"]`).val(response.data.keterangan)

        $.each(response.data.absensi_supir_detail, (index, detail) => {
          $($('#crudForm').find(`[name="supir_id[]"]`)[index]).val(detail.supir_id)
          $($('#crudForm').find(`[name="absen_id[]"]`)[index]).val(detail.absen_id)
          $($('#crudForm').find(`[name="jam[]"]`)[index]).val(detail.jam)
          $($('#crudForm').find(`[name="keterangan_detail[]"]`)[index]).val(detail.keterangan)

          new AutoNumeric($('#crudForm').find(`[name="uangjalan[]"]`)[index]).set(detail.uangjalan)
        })

      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function deleteAbsensiSupir(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Absensi Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    let supirs
    let statuses
    let absensiSupir

    $.ajax({
      url: `${apiUrl}trado`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $(document).find('#crudForm #table_body').html('')

        $.each(response.data, (index, trado) => {
          $(document).find('#crudForm #table_body').append(`
            <tr>
              <input type="hidden" name="trado_id[]" value="${trado.id}">
              <td>${trado.keterangan}</td>
              <td>
                <select class="form-control w-100" name="supir_id[]"></select>
              </td>
              <td>
                  <input type="text" class="form-control autonumeric" name="uangjalan[]"></input>
              </td>
              <td>
                <select class="form-control w-100" name="absen_id[]"></select>
              </td>
              <td>
                  <input type="time" class="form-control" name="jam[]"></input>
              </td>
              <td>
                  <input type="text" class="form-control" name="keterangan_detail[]"></input>
              </td>
            <tr>
          `)
        })

        form.find('[name]').addClass('disabled')

        initDisabled()
        initSelect2($('#crudForm').find('select'))
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}supir`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let supirElements = $(`#crudForm [name="supir_id[]"]`)

        supirElements.map((index, supirElement) => {
          response.data.map((supir, index) => {
            supirElement.append(
              new Option(supir.namasupir, supir.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}absentrado`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let statusElements = $(`#crudForm [name="absen_id[]"]`)

        statusElements.map((index, statusElement) => {
          response.data.map((status, index) => {
            statusElement.append(
              new Option(status.keterangan, status.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}absensisupirheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#crudForm').find(`[name="id"]`).val(response.data.id)
        $('#crudForm').find(`[name="nobukti"]`).val(response.data.nobukti)
        $('#crudForm').find(`[name="kasgantung_nobukti"]`).val(response.data.kasgantung_nobukti)
        $('#crudForm').find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
        $('#crudForm').find(`[name="keterangan"]`).val(response.data.keterangan)

        $.each(response.data.absensi_supir_detail, (index, detail) => {
          $($('#crudForm').find(`[name="supir_id[]"]`)[index]).val(detail.supir_id)
          $($('#crudForm').find(`[name="absen_id[]"]`)[index]).val(detail.absen_id)
          $($('#crudForm').find(`[name="jam[]"]`)[index]).val(detail.jam)
          $($('#crudForm').find(`[name="keterangan_detail[]"]`)[index]).val(detail.keterangan)

          new AutoNumeric($('#crudForm').find(`[name="uangjalan[]"]`)[index]).set(detail.uangjalan)
        })

      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }
</script>
@endpush
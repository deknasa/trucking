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
          <input type="hidden" name="id">

          <div class="row form-group">
            <div class="col-12 col-sm-2 col-md-2 col-form-label">
              <label>
                DARI <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <select name="kotadari_id" class="form-control select2bs4">
                <option value="">-- PILIH DARI --</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12 col-md-2 col-form-label">
              <label>
                TUJUAN <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <select name="kotasampai_id" class="form-control select2bs4">
                <option value="">-- PILIH TUJUAN --</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12 col-md-2 col-form-label">
              <label>
                ZONA <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <select name="zona_id" class="form-control select2bs4">
                <option value="">-- PILIH ZONA --</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12 col-md-2 col-form-label">
              <label>
                JARAK <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="text" name="jarak" class="form-control autonumeric">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12 col-md-2 col-form-label">
              <label>
                STATUS AKTIF <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <select name="statusaktif" class="form-control select2bs4">
                <option value="">-- PILIH STATUS AKTIF --</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12 col-md-2 col-form-label">
              <label>
                TGL MULAI BERLAKU <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="text" name="tglmulaiberlaku" class="form-control datepicker">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12 col-md-2 col-form-label">
              <label>
                TGL AKHIR BERLAKU <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="text" name="tglakhirberlaku" class="form-control datepicker">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12 col-md-2 col-form-label">
              <label>
                STATUS LUAR KOTA <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <select name="statusluarkota" class="form-control select2bs4">
                <option value="">-- PILIH STATUS LUAR KOTA --</option>
              </select>
            </div>
          </div>

          <table class="table table-borderd table-bindkeys" id="detailList">
            <thead>
              <tr>
                <th width="50">No</th>
                <th>CONTAINER</th>
                <th>STATUS CONTAINER</th>
                <th>NOMINAL SUPIR</th>
                <th>NOMINAL KENEK</th>
                <th>NOMINAL KOMISI</th>
                <th>NOMINAL TOL</th>
                <th>LITER</th>
                <th>AKSI</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
                <td>
                  <select type="text" name="container_id[]" class="form-control"></select>
                </td>
                <td>
                  <select type="text" name="statuscontainer_id[]" class="form-control"></select>
                </td>
                <td>
                  <input type="text" name="nominalsupir[]" class="form-control autonumeric">
                </td>
                <td>
                  <input type="text" name="nominalkenek[]" class="form-control autonumeric">
                </td>
                <td>
                  <input type="text" name="nominalkomisi[]" class="form-control autonumeric">
                </td>
                <td>
                  <input type="text" name="nominaltol[]" class="form-control autonumeric">
                </td>
                <td>
                  <input type="text" name="liter[]" class="form-control autonumeric">
                </td>
                <td>
                  <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                </td>
              </tr>

            </tbody>
            <tfoot>
              <tr>
                <td colspan="8"></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                </td>
              </tr>
            </tfoot>
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
  let containers
  let statusContainers

  $(document).ready(function() {
    getContainerOptions()
    getStatusContainerOptions()

    $("#addRow").click(function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let upahSupirId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()


      $('#crudForm').find(`[name="nominalsupir[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalsupir[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalsupir[]"]`)[index])
      })

      $('#crudForm').find(`[name="nominalkenek[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalkenek[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalkenek[]"]`)[index])
      })

      $('#crudForm').find(`[name="nominalkomisi[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalkomisi[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalkomisi[]"]`)[index])
      })

      $('#crudForm').find(`[name="nominaltol[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominaltol[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaltol[]"]`)[index])
      })

      $('#crudForm').find(`[name="liter[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'liter[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="liter[]"]`)[index])
      })

      $('#crudForm').find(`[name="jarak"]`).each((index, element) => {
        data.filter((row) => row.name === 'jarak')[index].value = AutoNumeric.getNumber($(`#crudForm [name="jarak"]`)[index])
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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}upahsupir`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}upahsupir/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}upahsupir/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}upahsupir`
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
          $('#crudModal').find('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
        },
        //   $('#crudForm').trigger('reset')
        //   $('#crudModal').modal('hide')

        //   id = response.data.id

        //   $('#jqGrid').trigger('reloadGrid', {
        //     page: response.data.page
        //   })

        //   if (response.data.grp == 'FORMAT') {
        //     updateFormat(response.data)
        //   }
        // },
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

  // $('#crudModal').on('shown.bs.modal', () => {
  //   let form = $('#crudForm')

  //   setFormBindKeys(form)

  //   activeGrid = null

  //   getMaxLength(form)
  // })

  // $('#crudModal').on('hidden.bs.modal', () => {
  //   activeGrid = '#jqGrid'
  // })

  function createUpahSupir() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    // form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Upah Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setKotaOptions(form)
    setZonaOptions(form)
    setStatusAktifOptions(form)
    setStatusLuarKotaOptions(form)

    addRow()
  }

  function editUpahSupir(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Upah Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setKotaOptions(form),
        setZonaOptions(form),
        setStatusAktifOptions(form),
        setStatusLuarKotaOptions(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
      })
  }

  function deleteUpahSupir(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Upah Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showUpahSupir(form, id)

    Promise
      .all([
        setKotaOptions(form),
        setZonaOptions(form),
        setStatusAktifOptions(form),
        setStatusLuarKotaOptions(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
      })
  }

  // function getMaxLength(form) {
  //   if (!form.attr('has-maxlength')) {
  //     $.ajax({
  //       url: `${apiUrl}upahsupir/field_length`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         'Authorization': `Bearer ${accessToken}`
  //       },
  //       success: response => {
  //         $.each(response.data, (index, value) => {
  //           if (value !== null && value !== 0 && value !== undefined) {
  //             form.find(`[name=${index}]`).attr('maxlength', value)
  //           }
  //         })

  //         form.attr('has-maxlength', true)
  //       },
  //       error: error => {
  //         showDialog(error.statusText)
  //       }
  //     })
  //   }
  // }

  const getStatusContainerOptions = function() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}statuscontainer`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          statusContainers = response.data

          resolve()
        }
      })
    })
  }

  const getContainerOptions = function() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}container`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          containers = response.data

          resolve()
        }
      })
    })
  }

  const setKotaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=kotadari_id], [name=kotasampai_id]').empty()
      relatedForm.find('[name=kotadari_id]').append(
        new Option('-- PILIH DARI --', '', false, true)
      ).trigger('change')
      relatedForm.find('[name=kotasampai_id]').append(
        new Option('-- PILIH SAMPAI --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}kota`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(kota => {
            let option = new Option(kota.keterangan, kota.id)

            relatedForm.find('[name=kotadari_id], [name=kotasampai_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setZonaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=zona_id]').empty()
      relatedForm.find('[name=zona_id]').append(
        new Option('-- PILIH ZONA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}zona`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(zona => {
            let option = new Option(zona.zona, zona.id)

            relatedForm.find('[name=zona_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusLuarKotaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusluarkota]').empty()
      relatedForm.find('[name=statusluarkota]').append(
        new Option('-- PILIH STATUS LUAR KOTA --', '', false, true)
      ).trigger('change')

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
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLuarKota => {
            let option = new Option(statusLuarKota.text, statusLuarKota.id)

            relatedForm.find('[name=statusluarkota]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusAktifOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusaktif]').empty()
      relatedForm.find('[name=statusaktif]').append(
        new Option('-- PILIH STATUS AKTIF --', '', false, true)
      ).trigger('change')

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
              "data": "STATUS AKTIF"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAktif => {
            let option = new Option(statusAktif.text, statusAktif.id)

            relatedForm.find('[name=statusaktif]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function showUpahSupir(form, userId) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}upahsupir/${userId}`,
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
        })

        $.each(response.detail, (index, detail) => {
          // $.each(response.data.upahsupir_rincian, (index, detail) => {
          let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <select type="text" name="container_id[]" class="form-control"></select>
              </td>
              <td>
                <select type="text" name="statuscontainer_id[]" class="form-control"></select>
              </td>
              <td>
                <input type="text" name="nominalsupir[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="nominalkenek[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="nominalkomisi[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="nominaltol[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="liter[]" class="form-control autonumeric">
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
            </tr>
          `)
          detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
          detailRow.find(`[name="statuscontainer_id[]"]`).val(detail.statuscontainer_id)
          detailRow.find(`[name="nominalsupir[]"]`).val(dateFormat(detail.nominalsupir))
          detailRow.find(`[name="nominalkenek[]"]`).val(detail.nominalkenek)
          detailRow.find(`[name="nominalkomisi[]"]`).val(detail.nominalkomisi)
          detailRow.find(`[name="nominaltol[]"]`).val(detail.nominaltol)
          detailRow.find(`[name="liter[]"]`).val(detail.liter)

          initAutoNumeric(detailRow.find(`[name="nominalsupir[]"]`))
          initAutoNumeric(detailRow.find(`[name="nominalkenek[]"]`))
          initAutoNumeric(detailRow.find(`[name="nominalkomisi[]"]`))
          initAutoNumeric(detailRow.find(`[name="nominaltol[]"]`))
          initAutoNumeric(detailRow.find(`[name="liter[]"]`))


          containers.forEach(container => {
            detailRow.find(`[name="container_id[]"]`).append(
              new Option(container.kodecontainer, container.id, false, false)
            ).select2({
              theme: 'bootstrap4',
              dropdownParent: $("#crudModal")
            })
          });

          statusContainers.forEach(statusContainer => {
            detailRow.find(`[name="statuscontainer_id[]"]`).append(
              new Option(statusContainer.kodestatuscontainer, statusContainer.id, false, false)
            ).select2({
              theme: 'bootstrap4',
              dropdownParent: $("#crudModal")
            })
          });

          $('#detailList tbody').append(detailRow)

          initAutoNumeric(detailRow.find('.autonumeric'))
          setRowNumbers()
        })
      }
    })
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <select type="text" name="container_id[]" class="form-control"></select>
        </td>
        <td>
          <select type="text" name="statuscontainer_id[]" class="form-control"></select>
        </td>
        <td>
          <input type="text" name="nominalsupir[]" class="form-control autonumeric">
        </td>
        <td>
          <input type="text" name="nominalkenek[]" class="form-control autonumeric">
        </td>
        <td>
          <input type="text" name="nominalkomisi[]" class="form-control autonumeric">
        </td>
        <td>
          <input type="text" name="nominaltol[]" class="form-control autonumeric">
        </td>
        <td>
          <input type="text" name="liter[]" class="form-control autonumeric">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    containers.forEach(container => {
      detailRow.find(`[name="container_id[]"]`).append(
        new Option(container.kodecontainer, container.id, false, false)
      ).select2({
        theme: 'bootstrap4',
        dropdownParent: $("#crudModal")
      })
    });

    statusContainers.forEach(statusContainer => {
      detailRow.find(`[name="statuscontainer_id[]"]`).append(
        new Option(statusContainer.kodestatuscontainer, statusContainer.id, false, false)
      ).select2({
        theme: 'bootstrap4',
        dropdownParent: $("#crudModal")
      })
    });

    $('#detailList tbody').append(detailRow)

    initAutoNumeric(detailRow.find('.autonumeric'))
    setRowNumbers()
  }

  function deleteRow(row) {
    row.remove()

    setRowNumbers()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }
</script>
@endpush()
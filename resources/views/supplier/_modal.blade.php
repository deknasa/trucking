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
            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2" style="display:none">
               
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Nama Supplier <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="namasupplier" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Nama Kontak <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="namakontak" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Alamat <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="alamat" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3" p>
                <label class="col-form-label">
                  Kota <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="kota" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Kode pos <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="kodepos" class="form-control numbernoseparate">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  NO TELEPON/HANDPHONE (1) <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="notelp1" class="form-control numbernoseparate">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  NO TELEPON/HANDPHONE (2)
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="notelp2" class="form-control numbernoseparate">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Email <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="email" name="email" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Web
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="web" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Nama Pemilik <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="namapemilik" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Jenis Usaha <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="jenisusaha" class="form-control">
              </div>
            </div>
            <!-- 
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TOP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="top" class="form-control numbernoseparate text-right">
              </div>
            </div> -->

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Bank <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="bank" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Rekening Bank <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="rekeningbank" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  NAMA PERKIRAAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-9">
                <div class="input-group">
                  <input type="hidden" name="coa">
                  <input type="text" id="ketcoa" name="ketcoa" class="form-control akunpusat-lookup">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Jabatan <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="jabatan" class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-md-3 col-form-label">STATUS DAFTAR HARGA<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-9">
                <input type="hidden" name="statusdaftarharga">
                <input type="text" name="statusdaftarharganama" id="statusdaftarharganama" class="form-control lg-form statusdaftarharga-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Kategori Usaha <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="kategoriusaha" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Nama Rekening <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="namarekening" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Keterangan <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  syarat pembayaran / TOP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="top" class="form-control numbernoseparate text-right">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
              </div>
            </div>

            {{--<div class="row form-group statuspostingtnl">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  STATUS POSTING TNL <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <select name="statuspostingtnl" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS POSTING TNL --</option>
                </select>
              </div>
            </div>--}}
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

  let dataMaxLength = []
  var data_id

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let supplierId = form.find('[name=id]').val()
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
        name: 'info',
        value: info
      })
      data.push({
        name: 'accessTokenTnl',
        value: accessTokenTnl
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
          url = `${apiUrl}supplier`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}supplier/${supplierId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}supplier/${supplierId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}supplier`
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
            page: response.data.page
          }).trigger('reloadGrid');

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
    data_id = $('#crudForm').find('[name=id]').val();

    setFormBindKeys(form)

    activeGrid = null
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy(data_id)

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function removeEditingBy(id) {
    if (id == "") {
      return ;
    }
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
        table: 'supplier'

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

  function createSupplier() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Supplier')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusDaftarHargaOptions(form),
        setStatusAktifOptions(form),
        setStatusPostingTnlOptions(form),
        // setTampilan(form),
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
  }

  function editSupplier(supplierId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Supplier')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusDaftarHargaOptions(form),
        setStatusAktifOptions(form),
        setStatusPostingTnlOptions(form),
        // setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showSupplier(form, supplierId)
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
  }

  function deleteSupplier(supplierId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Supplier')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusDaftarHargaOptions(form),
        setStatusAktifOptions(form),
        setStatusPostingTnlOptions(form),
        // setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showSupplier(form, supplierId)
          .then(() => {
            $('#crudModal').modal('show')
            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewSupplier(supplierId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Supplier')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusDaftarHargaOptions(form),
        setStatusAktifOptions(form),
        setStatusPostingTnlOptions(form),
        // setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showSupplier(form, supplierId)
          .then(() => {
            $('#crudModal').modal('show')
            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}supplier/field_length`,
          method: 'GET',
          dataType: 'JSON',
          headers: {
            'Authorization': `Bearer ${accessToken}`
          },
          success: response => {
            $.each(response.data, (index, value) => {
              if (value !== null && value !== 0 && value !== undefined) {
                form.find(`[name=${index}]`).attr('maxlength', value)
                if (index == 'kodepos') {
                  form.find(`[name=kodepos]`).attr('maxlength', 50)
                }
                if (index == 'namakontak') {
                  form.find(`[name=namakontak]`).attr('maxlength', 150)
                }
                if (index == 'notelp1') {
                  form.find(`[name=notelp1]`).attr('maxlength', 13)
                }
                if (index == 'notelp2') {
                  form.find(`[name=notelp2]`).attr('maxlength', 13)
                }
                if (index == 'namarekening') {
                  form.find(`[name=namarekening]`).attr('maxlength', 150)
                }
                if (index == 'jabatan') {
                  form.find(`[name=jabatan]`).attr('maxlength', 150)
                }
                if (index == 'kategoriusaha') {
                  form.find(`[name=kategoriusaha]`).attr('maxlength', 150)
                }
                if (index == 'rekeningbank') {
                  form.find(`[name=rekeningbank]`).attr('maxlength', 150)
                }
                if (index == 'email') {
                  form.find(`[name=email]`).attr('maxlength', 50)
                }
                if (index == 'web') {
                  form.find(`[name=web]`).attr('maxlength', 50)
                }
                if (index == 'namapemilik') {
                  form.find(`[name=namapemilik]`).attr('maxlength', 150)
                }
                if (index == 'jenisusaha') {
                  form.find(`[name=jenisusaha]`).attr('maxlength', 150)
                }
                if (index == 'bank') {
                  form.find(`[name=bank]`).attr('maxlength', 150)
                }

                if (index == 'kota') {
                  form.find(`[name=kota]`).attr('maxlength', 150)
                }
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

            if (index == 'kodepos') {
              form.find(`[name=kodepos]`).attr('maxlength', 50)
            }
            if (index == 'namakontak') {
              form.find(`[name=namakontak]`).attr('maxlength', 150)
            }
            if (index == 'notelp1') {
              form.find(`[name=notelp1]`).attr('maxlength', 13)
            }
            if (index == 'notelp2') {
              form.find(`[name=notelp2]`).attr('maxlength', 13)
            }
            if (index == 'namarekening') {
              form.find(`[name=namarekening]`).attr('maxlength', 150)
            }
            if (index == 'jabatan') {
              form.find(`[name=jabatan]`).attr('maxlength', 150)
            }
            if (index == 'kategoriusaha') {
              form.find(`[name=kategoriusaha]`).attr('maxlength', 150)
            }
            if (index == 'rekeningbank') {
              form.find(`[name=rekeningbank]`).attr('maxlength', 150)
            }
            if (index == 'email') {
              form.find(`[name=email]`).attr('maxlength', 50)
            }
            if (index == 'web') {
              form.find(`[name=web]`).attr('maxlength', 50)
            }
            if (index == 'namapemilik') {
              form.find(`[name=namapemilik]`).attr('maxlength', 150)
            }
            if (index == 'jenisusaha') {
              form.find(`[name=jenisusaha]`).attr('maxlength', 150)
            }
            if (index == 'bank') {
              form.find(`[name=bank]`).attr('maxlength', 150)
            }

            if (index == 'kota') {
              form.find(`[name=kota]`).attr('maxlength', 150)
            }
          }
        })
        resolve()
      })
    }


  }



  const setStatusDaftarHargaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusdaftarharga]').empty()
      relatedForm.find('[name=statusdaftarharga]').append(
        new Option('-- PILIH STATUS DAFTAR HARGA --', '', false, true)
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
              "data": "STATUS DAFTAR HARGA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusDaftarHarga => {
            let option = new Option(statusDaftarHarga.text, statusDaftarHarga.id)

            relatedForm.find('[name=statusdaftarharga]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function approve() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}supplier/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsSupplier
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsSupplier = []
        $('#gs_check').prop('checked', false)
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



  function approvenonaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}supplier/approvalnonaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsSupplier
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsSupplier = []
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}supplier/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            console.log(value)
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

  const setTampilan = function(relatedForm) {
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

  function showSupplier(form, supplierId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}supplier/${supplierId}`,
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
            } else {
              element.val(value)
            }

            if (index == 'statuspostingtnl') {
              element.prop('disabled', true)
            }
            if (index == 'ketcoa') {
              element.data('current-value', value)
            }

            if (index == 'statusdaftarharganama') {
              element.data('current-value', value)
            }

            if (index == 'statusaktifnama') {
              element.data('current-value', value)
            }
          })
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

  function cekValidasidelete(Id, aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}supplier/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: aksi,
      },
      success: response => {
        // var kondisi = response.kondisi
        // if (kondisi == true) {
        //   showDialog(response.message['keterangan'])
        // } else {
        //   deleteSupplier(Id)
        // }
        var error = response.error
        if (error == true) {
          showDialog(response.message)
        } else {
          if (aksi == "edit") {
            editSupplier(Id)
          } else if (aksi == "delete") {
            deleteSupplier(Id)
          }
        }
      }
    })
  }

  function initLookup() {

    $('.akunpusat-lookup').lookupV3({
      title: 'Akun Pusat Lookup',
      fileName: 'akunpusatV3',
      searching: ['coa','keterangancoa'],
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      filterToolbar: true,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          levelCoa: '3',
        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coa]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coa]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.statusdaftarharga-lookup`).lookupV3({
      title: 'Status Daftar Harga Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS DAFTAR HARGA',
          subgrp: 'STATUS DAFTAR HARGA',
        };
      },
      onSelectRow: (statusdaftarharga, element) => {
        $('#crudForm [name=statusdaftarharga]').first().val(statusdaftarharga.id)
        element.val(statusdaftarharga.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusdaftarharga"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusaktif-lookup`).lookupV3({
      title: 'Status Aktif Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
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
  }
</script>
@endpush()
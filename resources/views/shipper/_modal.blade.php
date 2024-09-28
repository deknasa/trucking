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
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  nama shipper <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="namapelanggan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  alias shipper <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="text" name="kodepelanggan" class="form-control">
              </div>
            </div>
            
            <!--- trucking default ---->

            <div class="" id="field-trucking">
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    nama kontak <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="namakontak" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    NO TELEPON/HANDPHONE <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="telp" class="form-control numbernoseparate">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    alamat (1) <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="alamat" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    alamat (2) <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="alamat2" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    kota <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="kota" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    kode pos <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="kodepos" class="form-control numbernoseparate">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    keterangan
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>
            </div>
            <!--- end trucking default ---->
            
            <!--- emkl bitung ---->
            <div class="" id="field-emkl">
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    npwp
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input id='input_masknpwp' type="text" name="npwp" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    noktp
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input id='input_maskktp' type="text" name="noktp" class="form-control numbernoseparate">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    alamat faktur pajak
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="alamatfakturpajak" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    alamat kantor penagihan
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="alamatkantorpenagihan" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    nama pemilik
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="namapemilik" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    telp kantor
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="telpkantor" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    faxk antor
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="faxkantor" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    website
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="website" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    contact person (CP)
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="contactperson" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    telp cp
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="telpcp" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    asuransi tas
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="asuransitas" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    asuransi sendiri
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="asuransisendiri" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    top
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="top" style="text-align:right" class="form-control autonumeric">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    prosedur penagihan
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="prosedurpenagihan" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    syarat penagihan
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="syaratpenagihan" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    pic keuangan
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="pickeuangan" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    telp pic keuangan
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="telppickeuangan" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    jenis usaha
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="jenisusaha" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    volume perbulan
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="volumeperbulan" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    kompetitor
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="kompetitor" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    referensi
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="referensi" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    nominal plafon
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="nominalplafon" style="text-align:right" class="form-control autonumeric">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    dana ditransfer dari
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="danaditransferdari" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    atas nama
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="atasnama" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    no rekening
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="norekening" class="form-control">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-3">
                  <label class="col-form-label">
                    bank
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-9">
                  <input type="text" name="bank" class="form-control">
                </div>
              </div>
            </div>
            
            <!--- end emkl bitung ---->

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-3">
                <label class="col-form-label">
                  Status Aktif <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-9">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form status-lookup">
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
  let dataMaxLength = []
  var data_id

  $('#input_masknpwp').inputmask({
    mask: '99.999.999.9-999.999',
    definitions: {
      A: {
        validator: "[A-Za-z0-9]"
      },
    },
  });

  $('#input_maskktp').inputmask({
    mask: '9999999999999999',
    definitions: {
      A: {
        validator: "[A-Za-z0-9]"
      },
    },
  });

  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  $('#field-emkl').hide()
  $('#field-trucking').show()

  $(document).ready(function() {
    if (accessCabang == 'BITUNG-EMKL') {
      $('#field-trucking').hide()
      $('#field-emkl').show()
    }
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let pelangganId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()


      $('#crudForm').find(`[name="nominalplafon"`).each((index, element) => {
        data.filter((row) => row.name === 'nominalplafon')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalplafon"]`)[index])
      })
      $('#crudForm').find(`[name="top"`).each((index, element) => {
        data.filter((row) => row.name === 'top')[index].value = AutoNumeric.getNumber($(`#crudForm [name="top"]`)[index])
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
          url = `${apiUrl}shipper`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}shipper/${pelangganId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}shipper/${pelangganId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}shipper`
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
    initAutoNumeric(form.find(`[name="nominalplafon"]`))
    initAutoNumeric(form.find(`[name="top"]`))

    initLookup()
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
        table: 'pelanggan'

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


  function createPelanggan() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    $('#input_masknpwp').inputmask({
      mask: '99.999.999.9-999.999',
      definitions: {
        A: {
          validator: "[A-Za-z0-9]"
        },
      },
    });
    
    $('#input_maskktp').inputmask({
      mask: '9999999999999999',
      definitions: {
        A: {
          validator: "[A-Za-z0-9]"
        },
      },
    });
    
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Shipper')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
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
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function initLookup() {
    $(`.status-lookup`).lookupV3({
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}shipper/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            console.log(value)
            let element = form.find(`[name="${index}"]`)

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


  function editPelanggan(pelangganId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    $('#input_masknpwp').inputmask({
      mask: '99.999.999.9-999.999',
      definitions: {
        A: {
          validator: "[A-Za-z0-9]"
        },
      },
    });
    
    $('#input_maskktp').inputmask({
      mask: '9999999999999999',
      definitions: {
        A: {
          validator: "[A-Za-z0-9]"
        },
      },
    });

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Shipper')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showPelanggan(form, pelangganId)
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

  function deletePelanggan(pelangganId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Shipper')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showPelanggan(form, pelangganId)
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

  function viewPelanggan(pelangganId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Shipper')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showPelanggan(form, pelangganId)
          .then(pelangganId => {
            // form.find('.aksi').hide()
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

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {

        $.ajax({
          url: `${apiUrl}shipper/field_length`,
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
                  form.find(`[name=${index}]`).attr('maxlength', 5)
                }
                if (index == 'telp') {
                  form.find(`[name=${index}]`).attr('maxlength', 13)
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
              form.find(`[name=${index}]`).attr('maxlength', 5)
            }
            if (index == 'telp') {
              form.find(`[name=${index}]`).attr('maxlength', 13)
            }
          }
        })
        resolve()
      })
    }
  }

  function showPelanggan(form, pelangganId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}shipper/${pelangganId}`,
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
            // } else if (element.hasClass('autonumeric')) {
            //   initAutoNumeric(element)
            } else {
              element.val(value)
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


  function approvenonaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}shipper/approvalnonaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsShipper
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsShipper = []
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
      url: `{{ config('app.api_url') }}shipper/${Id}/cekValidasi`,
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
        //   deletePelanggan(Id)
        // }

        var error = response.error
        if (error == true) {
          showDialog(response.message)
        } else {
          if (aksi == "edit") {
            editPelanggan(Id)
          } else if (aksi == "delete") {
            deletePelanggan(Id)
          }
        }

      }
    })
  }
</script>
@endpush()
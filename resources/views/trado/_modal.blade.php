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

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusaktif" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS AKTIF --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Kilometer Awal <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="kmawal">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Kilometer Akhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="kmakhirgantioli">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Akhir Ganti oli <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="tglakhirgantioli">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl STNK Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control formatdate" name="tglstnkmati">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Asuransi Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control formatdate" name="tglasuransimati">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tahun <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input pattern="[0-9.]+" type="text" class="form-control numbernoseparate" name="tahun">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tahun Produksi Akhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="akhirproduksi">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Merek <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="merek">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No Rangka <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="norangka">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No Mesin <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomesin">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nama <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nostnk">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Alamat STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="alamatstnk">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control formatdate" name="tglstandarisasi">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Service Opname <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control formatdate" name="tglserviceopname">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusstandarisasi" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS STANDARISASI --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan Progress Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="keteranganprogressstandarisasi">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jenis Plat <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="jenisplat" class="form-control select2bs4">
                    <option value="">-- PILIH JENIS PLAT --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Speksi Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control formatdate" name="tglspeksimati">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Pajak STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control formatdate" name="tglpajakstnk">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Ganti aki terakhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control formatdate" name="tglgantiakiterakhir">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Mutasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusmutasi" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS MUTASI --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Validasi Kendaraan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusvalidasikendaraan" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS VALIDASI KENDARAAN --</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tipe <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="tipe">
                </div>
              </div>

            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jenis <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="jenis">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Isi Silinder <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="isisilinder">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Warna <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="warna">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Bahan Bakar <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="jenisbahanbakar">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Sumbu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="jlhsumbu">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Roda <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="jlhroda">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Model <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="model">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No BPKB <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nobpkb">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Mobil Storing <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusmobilstoring" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS MOBIL STORING --</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Milik Mandor <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="mandor_id" class="form-control select2bs4">
                    <option value="">-- PILIH MILIK MANDOR --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Ban Serap <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="jlhbanserap">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS APPEDIT BAN <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusappeditban" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS APPEDIT BAN --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Lewat Validasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statuslewatvalidasi" class="form-control select2bs4">
                    <option value="">-- PILIH LEWAT VALIDASI --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row p-2">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Trado</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" id="uploadTrado" type="button">Upload Trado</button>
                  </div>
                </div>
                <div class="dropzone" id="my-dropzone" data-field="trado">
                  <div class="fallback">
                    <input name="file" type="file" />
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto BPKB</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" type="button" id="uploadBpkb">Upload BPKB</button>
                  </div>
                </div>
                <div class="dropzone" id="my-dropzoness" data-field="bpkb">
                  <div class="fallback">
                    <input name="file" type="file" />
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto STNK</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" type="button" id="uploadStnk">Upload STNK</button>
                  </div>
                </div>
                <div class="dropzone" id="dropzonestnk" data-field="stnk">
                  <div class="fallback">
                    <input name="file" type="file" />
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
  Dropzone.autoDiscover = false;

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="isisilinder"]`).each((index, element) => {
        data.filter((row) => row.name === 'isisilinder')[index].value = AutoNumeric.getNumber($(`#crudForm [name="isisilinder"]`)[index])
      })

      $('#crudForm').find(`[name="kmawal"]`).each((index, element) => {
        data.filter((row) => row.name === 'kmawal')[index].value = AutoNumeric.getNumber($(`#crudForm [name="kmawal"]`)[index])
      })

      $('#crudForm').find(`[name="kmakhirgantioli"]`).each((index, element) => {
        data.filter((row) => row.name === 'kmakhirgantioli')[index].value = AutoNumeric.getNumber($(`#crudForm [name="kmakhirgantioli"]`)[index])
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
          url = `${apiUrl}trado`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}trado/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}trado/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}trado`
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

          id = response.data.id

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

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

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function createTrado() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Trado')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    initDropzone(form.data('action'))

    setStatusAktifOptions(form)
    setStatusStandarisasiOptions(form)
    setJenisPlatOptions(form)
    setStatusMutasiOptions(form)
    setStatusValidasiKendaraanOptions(form)
    setStatusMobilStoringOptions(form)
    setMandorOptions(form)
    setAppeditBanOptions(form)
    setStatusLewatValidasiOptions(form)
  }

  function editTrado(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Trado')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusStandarisasiOptions(form),
        setJenisPlatOptions(form),
        setStatusMutasiOptions(form),
        setStatusValidasiKendaraanOptions(form),
        setStatusMobilStoringOptions(form),
        setMandorOptions(form),
        setAppeditBanOptions(form),
        setStatusLewatValidasiOptions(form)
      ])
      .then(() => {
        showTrado(form, id)
      })
  }

  function deleteTrado(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Trado')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusStandarisasiOptions(form),
        setJenisPlatOptions(form),
        setStatusMutasiOptions(form),
        setStatusValidasiKendaraanOptions(form),
        setStatusMobilStoringOptions(form),
        setMandorOptions(form),
        setAppeditBanOptions(form),
        setStatusLewatValidasiOptions(form)
      ])
      .then(() => {
        showTrado(form, id)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}trado/field_length`,
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

  const setStatusLewatValidasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslewatvalidasi]').empty()
      relatedForm.find('[name=statuslewatvalidasi]').append(
        new Option('-- PILIH STATUS LEWAT VALIDASI --', '', false, true)
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
              "data": "STATUS LEWAT VALIDASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLewatValidasi => {
            let option = new Option(statusLewatValidasi.text, statusLewatValidasi.id)

            relatedForm.find('[name=statuslewatvalidasi]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setMandorOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=mandor_id]').empty()
      relatedForm.find('[name=mandor_id]').append(
        new Option('-- PILIH MANDOR --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}mandor`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(mandor => {
            let option = new Option(mandor.namamandor, mandor.id)

            relatedForm.find('[name=mandor_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setAppeditBanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusappeditban]').empty()
      relatedForm.find('[name=statusappeditban]').append(
        new Option('-- PILIH STATUS APPEDIT BAN --', '', false, true)
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
              "data": "STATUS APPROVAL EDIT BAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAppeditBan => {
            let option = new Option(statusAppeditBan.text, statusAppeditBan.id)

            relatedForm.find('[name=statusappeditban]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }
  //sini
 
  const setStatusMobilStoringOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusmobilstoring]').empty()
      relatedForm.find('[name=statusmobilstoring]').append(
        new Option('-- PILIH STATUS MOBIL STORING --', '', false, true)
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
              "data": "STATUS MOBIL STORING"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusMobilStoring => {
            let option = new Option(statusMobilStoring.text, statusMobilStoring.id)

            relatedForm.find('[name=statusmobilstoring]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusValidasiKendaraanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusvalidasikendaraan]').empty()
      relatedForm.find('[name=statusvalidasikendaraan]').append(
        new Option('-- PILIH STATUS VALIDASI KENDARAAN --', '', false, true)
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
              "data": "STATUS VALIDASI KENDARAAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusValidasiKendaraan => {
            let option = new Option(statusValidasiKendaraan.text, statusValidasiKendaraan.id)

            relatedForm.find('[name=statusvalidasikendaraan]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusMutasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusmutasi]').empty()
      relatedForm.find('[name=statusmutasi]').append(
        new Option('-- PILIH STATUS MUTASI --', '', false, true)
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
              "data": "STATUS MUTASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusMutasi => {
            let option = new Option(statusMutasi.text, statusMutasi.id)

            relatedForm.find('[name=statusmutasi]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setJenisPlatOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=jenisplat]').empty()
      relatedForm.find('[name=jenisplat]').append(
        new Option('-- PILIH JENIS PLAT --', '', false, true)
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
              "data": "JENIS PLAT"
            }]
          })
        },
        success: response => {
          response.data.forEach(jenisPlat => {
            let option = new Option(jenisPlat.text, jenisPlat.id)

            relatedForm.find('[name=jenisplat]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusStandarisasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusstandarisasi]').empty()
      relatedForm.find('[name=statusstandarisasi]').append(
        new Option('-- PILIH STATUS STANDARISASI --', '', false, true)
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
              "data": "STATUS STANDARISASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusStandarisasi => {
            let option = new Option(statusStandarisasi.text, statusStandarisasi.id)

            relatedForm.find('[name=statusstandarisasi]').append(option).trigger('change')
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

  function showTrado(form, id) {
    $.ajax({
      url: `${apiUrl}trado/${id}`,
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
          } else if (element.hasClass('autonumeric')) {
            let autoNumericInput = AutoNumeric.getAutoNumericElement(element[0])

            autoNumericInput.set(value);
          } else {
            element.val(value)
          }
        })
      }
    })
  }

  function initDropzone(action) {
    let attachArray = {
      'trado': {},
      'stnk': {},
      'bpkb': {}
    };

    const dropzones = []
    $('.dropzone').each(function(i, el) {
      const name = 'g_' + $(el).data('field');
      var myDropzone = new Dropzone(el, {
        url: window.location.pathname,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        paramName: name,
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        init: function() {
          var wrapperThis = this;

          this.on('removedfile', function(file) {
            var key = file.upload.uuid;
            if (attachArray.trado.hasOwnProperty(key) || attachArray.stnk.hasOwnProperty(key) || attachArray.bpkb.hasOwnProperty(key)) {
              delete attachArray.trado[key];
              delete attachArray.stnk[key];
              delete attachArray.bpkb[key];
            }
          })

          if (action == 'edit' || action == 'delete') {
            var imgTrado = {}
            var imgBpkb = {}
            var imgStnk = {}

            if (Object.keys(imgTrado).length > 0) {
              var total = Object.keys(imgTrado).length / 3;
              var idx = 0;
              for (var i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }
                // console.log(idx);
                var obj = {
                  name: imgTrado[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_trado') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, baseurl + '/uploads/trado/' + imgTrado[idx]);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.trado[obj.upload.uuid] = imgTrado[idx];
                }
              }
            }

            if (Object.keys(imgBpkb).length > 0) {
              var total = Object.keys(imgBpkb).length / 3;
              var idx = 0;
              for (var i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                var obj = {
                  name: imgBpkb[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_bpkb') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, baseurl + '/uploads/bpkb/' + imgBpkb[idx]);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.bpkb[obj.upload.uuid] = imgBpkb[idx];
                }
              }
            }

            if (Object.keys(imgStnk).length > 0) {
              var total = Object.keys(imgStnk).length / 3;
              var idx = 0;
              for (var i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                var obj = {
                  name: imgStnk[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_stnk') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, baseurl + '/uploads/stnk/' + imgStnk[idx]);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.stnk[obj.upload.uuid] = imgStnk[idx];
                }
              }
            }
          }

        }
      })
      dropzones.push(myDropzone)
    })
  }
</script>
@endpush()
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
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglakhirgantioli">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl STNK Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglstnkmati">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Asuransi Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglasuransimati">
                  </div>
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
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglstandarisasi">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Service Opname <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglserviceopname">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusstandarisasi" class="form-control select2bs4" z-index="3">
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
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglspeksimati" z-index="3">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Pajak STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglpajakstnk">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Ganti aki terakhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglgantiakiterakhir">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Mutasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusmutasi" class="form-control select2bs4" z-index="3">
                    <option value="">-- PILIH STATUS MUTASI --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Validasi Kendaraan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusvalidasikendaraan" class="form-control select2bs4" z-index="3">
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
                  <input type="text" class="form-control numbernoseparate" name="jlhsumbu">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Roda <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jlhroda">
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
                  <select name="statusmobilstoring" class="form-control select2bs4" z-index="3"> 
                    <option value="">-- PILIH STATUS MOBIL STORING --</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Milik Mandor <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="hidden" name="mandor_id">
                  <input type="text" name="mandor" class="form-control mandor-lookup">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Ban Serap <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jlhbanserap">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS APPEDIT BAN <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusappeditban" class="form-control select2bs4" z-index="3">
                    <option value="">-- PILIH STATUS APPEDIT BAN --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Lewat Validasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statuslewatvalidasi" class="form-control select2bs4" z-index="3">
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
                <div class="dropzone" id="dropzone-trado" data-field="trado">
                  <div class="fallback">
                    <input name="phototrado" type="file" multiple/>
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
                <div class="dropzone" id="dropzone-bpkb" data-field="bpkb">
                  <div class="fallback">
                    <input name="photobpkb" type="file" multiple/>
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
                <div class="dropzone" id="dropzone-stnk" data-field="stnk">
                  <div class="fallback">
                    <input name="photostnk" type="file" multiple/>
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
  let modalBody = $('#crudModal').find('.modal-body').html()
  let myDropzone
  let dropzoneAttachment = {
    phototrado: [],
    photobpkb: [],
    photostnk: [],
  }
  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      // let data = $('#crudForm').serializeArray()
      let formData = new FormData();

      formData.append('id', form.find(`[name="id"]`).val())
      formData.append('keterangan', form.find(`[name="keterangan"]`).val())
      formData.append('statusaktif', form.find(`[name="statusaktif"]`).val())
      formData.append('kmawal', AutoNumeric.getNumber($(`#crudForm [name="kmawal"]`)[0]))
      formData.append('kmakhirgantioli', AutoNumeric.getNumber($(`#crudForm [name="kmakhirgantioli"]`)[0]))
      formData.append('tglakhirgantioli', form.find(`[name="tglakhirgantioli"]`).val())
      formData.append('tglstnkmati', form.find(`[name="tglstnkmati"]`).val())
      formData.append('tglasuransimati', form.find(`[name="tglasuransimati"]`).val())
      formData.append('tahun', form.find(`[name="tahun"]`).val())
      formData.append('akhirproduksi', form.find(`[name="akhirproduksi"]`).val())
      formData.append('merek', form.find(`[name="merek"]`).val())
      formData.append('norangka', form.find(`[name="norangka"]`).val())
      formData.append('nomesin', form.find(`[name="nomesin"]`).val())
      formData.append('nama', form.find(`[name="nama"]`).val())
      formData.append('nostnk', form.find(`[name="nostnk"]`).val())
      formData.append('alamatstnk', form.find(`[name="alamatstnk"]`).val())
      formData.append('tglstandarisasi', form.find(`[name="tglstandarisasi"]`).val())
      formData.append('tglserviceopname', form.find(`[name="tglserviceopname"]`).val())
      formData.append('statusstandarisasi', form.find(`[name="statusstandarisasi"]`).val())
      formData.append('keteranganprogressstandarisasi', form.find(`[name="keteranganprogressstandarisasi"]`).val())
      formData.append('jenisplat', form.find(`[name="jenisplat"]`).val())
      formData.append('tglspeksimati', form.find(`[name="tglspeksimati"]`).val())
      formData.append('tglpajakstnk', form.find(`[name="tglpajakstnk"]`).val())
      formData.append('tglgantiakiterakhir', form.find(`[name="tglgantiakiterakhir"]`).val())
      formData.append('statusmutasi', form.find(`[name="statusmutasi"]`).val())
      formData.append('statusvalidasikendaraan', form.find(`[name="statusvalidasikendaraan"]`).val())
      formData.append('tipe', form.find(`[name="tipe"]`).val())
      formData.append('jenis', form.find(`[name="jenis"]`).val())
      formData.append('isisilinder', AutoNumeric.getNumber($(`#crudForm [name="isisilinder"]`)[0]))
      formData.append('warna', form.find(`[name="warna"]`).val())
      formData.append('bahanbakar', form.find(`[name="bahanbakar"]`).val())
      formData.append('jlhsumbu', form.find(`[name="jlhsumbu"]`).val())
      formData.append('jlhroda', form.find(`[name="jlhroda"]`).val())
      formData.append('model', form.find(`[name="model"]`).val())
      formData.append('nobpkb', form.find(`[name="nobpkb"]`).val())
      formData.append('statusmobilstoring', form.find(`[name="statusmobilstoring"]`).val())
      formData.append('mandor_id', form.find(`[name="mandor_id"]`).val())
      formData.append('jlhbanserap', form.find(`[name="jlhbanserap"]`).val())
      formData.append('statusappeditban', form.find(`[name="statusappeditban"]`).val())
      formData.append('statuslewatvalidasi', form.find(`[name="statuslewatvalidasi"]`).val())

      $.each(dropzoneAttachment.phototrado, function(row) {
        formData.append('phototrado[]', dropzoneAttachment.phototrado[row])
      })
      $.each(dropzoneAttachment.photobpkb, function(row, val) {
        formData.append('photobpkb[]', dropzoneAttachment.photobpkb[row])
      })
      $.each(dropzoneAttachment.photostnk, function(row, val) {
        formData.append('photostnk[]', dropzoneAttachment.photostnk[row])
      })
      formData.append('sortIndex', $('#jqGrid').getGridParam().sortname)
      formData.append('sortOrder', $('#jqGrid').getGridParam().sortorder)
      formData.append('filters', $('#jqGrid').getGridParam('postData').filters)
      formData.append('indexRow', indexRow)
      formData.append('page', page)
      formData.append('limit', limit)

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
        enctype: 'multipart/form-data',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: formData,
        processData: false,
        contentType: false,
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
    initLookup()
    initDatepicker()
    initSelect2()
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
        setAppeditBanOptions(form),
        setStatusLewatValidasiOptions(form)
      ])
      .then(() => {
        showTrado(form, id)
        
        initDropzone(form.data('action'), id)
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

  function initDropzone(action, id = null) {
    let attachArray = {
      'trado': {},
      'stnk': {},
      'bpkb': {}
    };

    const dropzones = []
    $('.dropzone').each(function(i, el) {
      const name = 'g_' + $(el).data('field');
      console.log(name)
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
          
          this.on('addedfile', function(imageFile) {
            if (el.id == 'dropzone-trado') {
              dropzoneAttachment.phototrado.push(imageFile)
            }
            if (el.id == 'dropzone-bpkb') {
              dropzoneAttachment.photobpkb.push(imageFile)
            }
            if (el.id == 'dropzone-stnk') {
              dropzoneAttachment.photostnk.push(imageFile)
            }

          })

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
            if (el.id == 'dropzone-trado') {
              $.ajax({
                url: `${apiUrl}trado/getImage/${id}/phototrado`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    console.log(value);
                    let tes = `${response.base}/${value.name}`
                    let ext = tes.split('.').pop()
                    let imageFile = new File([{
                      name: `${response.base}/${value.name}`,
                      size: value.size,
                      type: `images/${ext}`,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name)

                    newAdd = false
                    console.log(imageFile)
                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/${value.name}`);
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }

            if (el.id == 'dropzone-bpkb') {
              $.ajax({
                url: `${apiUrl}trado/getImage/${id}/photobpkb`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    console.log(value);
                    let tes = `${response.base}/${value.name}`
                    let ext = tes.split('.').pop()
                    let imageFile = new File([{
                      name: `${response.base}/${value.name}`,
                      size: value.size,
                      type: `images/${ext}`,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name)

                    newAdd = false
                    console.log(imageFile)
                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/${value.name}`);
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }

            if (el.id == 'dropzone-stnk') {
              $.ajax({
                url: `${apiUrl}trado/getImage/${id}/photostnk`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    console.log(value);
                    let tes = `${response.base}/${value.name}`
                    let ext = tes.split('.').pop()
                    let imageFile = new File([{
                      name: `${response.base}/${value.name}`,
                      size: value.size,
                      type: `images/${ext}`,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name)

                    newAdd = false
                    console.log(imageFile)
                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/${value.name}`);
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }

            // if (Object.keys(imgTrado).length > 0) {
            //   var total = Object.keys(imgTrado).length / 3;
            //   var idx = 0;
            //   for (var i = 1; i <= total; i++) {
            //     if (i > 1) {
            //       idx += 3;
            //     }
            //     // console.log(idx);
            //     var obj = {
            //       name: imgTrado[idx],
            //       size: 12345,
            //       upload: {
            //         uuid: (Math.random() + 1).toString(36).substring(7)
            //       }
            //     };

            //     if (name == 'g_trado') {
            //       wrapperThis.emit("addedfile", obj);
            //       wrapperThis.emit("thumbnail", obj, baseurl + '/uploads/trado/' + imgTrado[idx]);
            //       wrapperThis.emit("complete", obj);
            //       wrapperThis.files.push(obj);
            //       attachArray.trado[obj.upload.uuid] = imgTrado[idx];
            //     }
            //   }
            // }

          }

        }
      })
      dropzones.push(myDropzone)
    })
  }

  function initLookup() {

    $('.mandor-lookup').lookup({
      title: 'Mandor Lookup',
      fileName: 'mandor',
      onSelectRow: (mandor, element) => {
        $('#crudForm [name=mandor_id]').first().val(mandor.id)
        element.val(mandor.namamandor)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
  }
</script>
@endpush()
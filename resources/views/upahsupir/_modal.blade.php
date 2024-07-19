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

            <div class="row form-group statusupahzona">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS UPAH ZONA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusupahzona" class="form-control select2bs4" z-index="6">
                  <option value="">-- PILIH STATUS UPAH ZONA --</option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Parent
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="parent_id">
                <input type="text" id="parent" name="parent" class="form-control upahsupir-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Tarif <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarif_id">
                <input type="text" id="tarif" name="tarif" class="form-control tarif-lookup">
              </div>
            </div>
            <div class="row form-group tarifmuatan">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Tarif Muatan
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarifmuatan_id">
                <input type="text" id="tarifmuatan" name="tarifmuatan" class="form-control tarifmuatan-lookup">
              </div>
            </div>
            <div class="row form-group tarifbongkaran">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Tarif Bongkaran
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarifbongkaran_id">
                <input type="text" id="tarifbongkaran" name="tarifbongkaran" class="form-control tarifbongkaran-lookup">
              </div>
            </div>
            <div class="row form-group tarifexport">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Tarif Export
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarifexport_id">
                <input type="text" id="tarifexport" name="tarifexport" class="form-control tarifexport-lookup">
              </div>
            </div>
            <div class="row form-group tarifimport">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Tarif Import
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarifimport_id">
                <input type="text" id="tarifimport" name="tarifimport" class="form-control tarifimport-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  DARI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="kotadari_id">
                <input type="text" id="kotadari" name="kotadari" class="form-control kotadari-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TUJUAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="kotasampai_id">
                <input type="text" id="kotaupahsupir" name="kotasampai" class="form-control kotasampai-lookup">
                <!-- <input type="hidden" id="kotatarif" name="kotasampai" disabled class="form-control"> -->
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PENYESUAIAN
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="penyesuaian" class="form-control">
              </div>
            </div>

            <div class="row form-group zonadari">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  ZONA DARI
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="zonadari_id">
                <input type="text" name="zonadari" class="form-control zonadari-lookup">
              </div>
            </div>

            <div class="row form-group zonasampai">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  ZONA SAMPAI
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="zonasampai_id">
                <input type="text" name="zonasampai" class="form-control zonasampai-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JARAK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="jarak" class="form-control" style="text-align: right">
                  <div class="input-group-append">
                    <span class="input-group-text" style="font-weight: bold;">KM</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JARAK FULL/EMPTY<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="jarakfullempty" class="form-control" style="text-align: right" readonly>
                  <div class="input-group-append">
                    <span class="input-group-text" style="font-weight: bold;">KM</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
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
                  TGL MULAI BERLAKU <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglmulaiberlaku" class="form-control datepicker">
                </div>
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TGL AKHIR BERLAKU <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglakhirberlaku" class="form-control datepicker">
                </div>
              </div>
            </div> 
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS LUAR KOTA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusluarkota" class="form-control select2bs4" z-index="6">
                  <option value="">-- PILIH STATUS LUAR KOTA --</option>
                </select>
              </div>
            </div> --}}
            {{-- <div class="row form-group statussimpankandang" id="simpanKandang">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS SIMPAN KANDANG <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statussimpankandang" class="form-control select2bs4" z-index="6">
                  <option value="">-- PILIH STATUS SIMPAN KANDANG --</option>
                </select>
              </div>
            </div> --}}


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  ZONA
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="zona_id">
                <input type="text" id="zona" name="zona" class=" form-control zona-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  KETERANGAN
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="keterangan_id">
                <input type="text" name="keterangan" class="form-control keterangan">
              </div>
            </div>


            <div class="row form-group">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Peta</label>
                  </div>
                </div>
                <div class="dropzone" data-field="gambar" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail style="width:100%" />
                  </div>
                </div>
                <!-- <div class="dropzone" data-field="gambar" style="padding: 0; min-width: 202px !important; min-height: 234px !important; display:flex;">
                  <div class="fallback">
                    <input name="gambar" type="file" />
                  </div>
                </div> -->
              </div>
            </div>

            <div class="table-responsive table-scroll ">
              <table class="table table-bordered mt-3 table-bindkeys" id="detailList" style="width:1500px">
                <thead class="table-secondary">
                  <tr>
                    <th width="5%">NO</th>
                    <th width="10%">CONTAINER</th>
                    <th width="12%">STATUS CONTAINER</th>
                    <th width="12%">NOMINAL SUPIR</th>
                    <th width="12%">NOMINAL KENEK</th>
                    <th width="12%">NOMINAL KOMISI</th>
                    <th width="12%">NOMINAL TOL</th>
                    <th width="12%">LITER</th>
                    {{-- <th width="1%">AKSI</th> --}}
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">
                  <tr>
                    <td>1</td>
                    <td>
                      <input type="hidden" name="container_id[]">
                      <input type="text" name="container[]" class="form-control container-lookup">
                    </td>
                    <td>
                      <input type="hidden" name="statuscontainer_id[]" class="form-control">
                      <input type="text" name="statuscontainer[]" class="form-control statuscontainer-lookup">
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
                    {{-- <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                    </td> --}}
                  </tr>
                </tbody>
                <tfoot>
                  <tr style="display: none;">
                    <td colspan="3">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="nominalSupir"></p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="nominalKenek"></p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="nominalKomisi"></p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="nominalTol"></p>
                    </td>
                    <td>
                      {{-- <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button> --}}
                    </td>
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
  Dropzone.autoDiscover = false;
  let dropzones = []
  let aksiEdit = true;
  var data_id

  let dataMaxLength = []

  let statusAktif
  let statusUpahZona
  $(document).ready(function() {
    $(document).on('dblclick', '[data-dz-thumbnail]', handleImageClick)
    $('#kotatarif').hide()
    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', '#addRow', function(event) {
      addRow()
    });

    $(document).on('input', `#table_body [name="nominalsupir[]"]`, function(event) {
      setNominalSupir()
    })

    $(document).on('change', `#crudForm [name="statusupahzona"]`, function(event) {
      let selectedUpahZona = $(`#crudForm [name="statusupahzona"] option:selected`).text()
      if (selectedUpahZona == 'NON UPAH ZONA' || selectedUpahZona == 'UPAH ZONA') {
        if (aksiEdit == true) {
          formatUpahZona(selectedUpahZona)
        }
      }
    })

    $(document).on('input', `#table_body [name="nominalkenek[]"]`, function(event) {
      setNominalKenek()
    })

    $(document).on('input', `#table_body [name="nominalkomisi[]"]`, function(event) {
      setNominalKomisi()
    })

    $(document).on('input', `#table_body [name="nominaltol[]"]`, function(event) {
      setNominalTol()
    })


    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      let formData = new FormData()

      dropzones.forEach(dropzone => {
        const {
          paramName
        } = dropzone.options

        dropzone.files.forEach((file, index) => {
          formData.append(`${paramName}[${index}]`, file)
        })
      })

      // formData.delete(`nominalsupir[]`);
      $('#crudForm').find(`[name="nominalsupir[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalsupir[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalsupir[]"]`)[index])
        // formData.append(`nominalsupir[]`, AutoNumeric.getNumber($(`#crudForm [name="nominalsupir[]"]`)[index]))
      })

      // formData.delete(`nominalkenek[]`);
      $('#crudForm').find(`[name="nominalkenek[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalkenek[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalkenek[]"]`)[index])
        // formData.append('nominalkenek[]', AutoNumeric.getNumber($(`#crudForm [name="nominalkenek[]"]`)[index]))
      })

      // formData.delete(`nominalkomisi[]`);
      $('#crudForm').find(`[name="nominalkomisi[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalkomisi[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalkomisi[]"]`)[index])
        // formData.append('nominalkomisi[]', AutoNumeric.getNumber($(`#crudForm [name="nominalkomisi[]"]`)[index]))
      })

      // formData.delete(`nominaltol[]`);
      $('#crudForm').find(`[name="nominaltol[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominaltol[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaltol[]"]`)[index])
        // formData.append('nominaltol[]', AutoNumeric.getNumber($(`#crudForm [name="nominaltol[]"]`)[index]))
      })

      // formData.delete(`liter[]`);
      $('#crudForm').find(`[name="liter[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'liter[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="liter[]"]`)[index])
        // formData.append('liter[]', AutoNumeric.getNumber($(`#crudForm [name="liter[]"]`)[index]))
      })

      data.filter((row) => row.name === 'jarak')[0].value = AutoNumeric.getNumber($(`#crudForm [name="jarak"]`)[0])
      data.filter((row) => row.name === 'jarakfullempty')[0].value = AutoNumeric.getNumber($(`#crudForm [name="jarakfullempty"]`)[0])

      $.each(data, function(key, input) {
        formData.append(input.name, input.value);
      });

      if (aksiEdit == false) {
        // formData.append('statusaktif', statusAktif)
        formData.append('statusupahzona', statusUpahZona)
      }


      formData.append('sortIndex', $('#jqGrid').getGridParam().sortname)
      formData.append('sortOrder', $('#jqGrid').getGridParam().sortorder)
      formData.append('filters', $('#jqGrid').getGridParam('postData').filters)
      formData.append('info', info)
      formData.append('indexRow', indexRow)
      formData.append('accessTokenTnl', accessTokenTnl)
      formData.append('page', page)
      formData.append('limit', limit)

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}upahsupir`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}upahsupir/${Id}`
          formData.append('_method', 'PATCH')
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}upahsupir/${Id}`
          formData.append('_method', 'DELETE')
          break;
        default:
          method = 'POST'
          url = `${apiUrl}upahsupir`
          break;
      }

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')
      $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: formData,
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




  //update sore
  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    data_id = $('#crudForm').find('[name=id]').val();

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }


    initDatepicker()
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy(data_id)
    $('#crudModal').find('.modal-body').html(modalBody)
    dropzones.forEach(dropzone => {
      dropzone.removeAllFiles()
    })
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
        table: 'upahsupir'

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

  function setNominalSupir() {
    let nominalDetails = $(`#table_body [name="nominalsupir[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#nominalSupir').set(total)
  }

  function setNominalKenek() {
    let nominalDetails = $(`#table_body [name="nominalkenek[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#nominalKenek').set(total)
  }

  function setNominalKomisi() {
    let nominalDetails = $(`#table_body [name="nominalkomisi[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#nominalKomisi').set(total)
  }

  function setNominalTol() {
    let nominalDetails = $(`#table_body [name="nominaltol[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#nominalTol').set(total)
  }


  $(document).on('input', `#crudForm [name="jarak"]`, function(event) {

    let jaraks = $(`#crudForm [name="jarak"]`)
    let total = 0
    total = AutoNumeric.getNumber(jaraks[0]) * 2;
    new AutoNumeric($(`#crudForm [name="jarakfullempty"]`)[0]).set(total)
  })

  function createUpahSupir() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Upah Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    setUpRow()

    $('#crudForm').find('[name=tglmulaiberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglakhirberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusUpahZonaOptions(form),

        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {

            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
    initDropzone(form.data('action'))

    initAutoNumeric(form.find(`[name="jarak"]`), {
      minimumValue: 0
    })

    initAutoNumeric(form.find(`[name="jarakfullempty"]`), {
      minimumValue: 0
    })
  }

  function editUpahSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Upah Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusUpahZonaOptions(form),

        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
          .then((upahsupir) => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            initDropzone(form.data('action'), upahsupir);
            if (aksiEdit == false) {

              statusAktif = form.find(`[name="statusaktif"]`).val()
              statusUpahZona = form.find(`[name="statusupahzona"]`).val()
              // form.find('select').each((index, select) => {
              //   let element = $(select)

              //   if (element.data('select2')) {
              //     element.select2('destroy')
              //   }
              // })

              // form.find(`[name="jarak"]`).prop('readonly', true)
              // form.find(`[name="statusaktif"]`).prop('disabled', 'disabled')
              form.find(`[name="statusupahzona"]`).prop('disabled', 'disabled')
              // form.find(`[name="tglmulaiberlaku"]`).prop('readonly', true)
              form.find(`[name="tujuan"]`).prop('readonly', true)
              form.find(`[name="penyesuaian"]`).prop('readonly', true)
              form.find(`[name="kotadari"]`).prop('readonly', true)
              form.find(`[name="kotasampai"]`).prop('readonly', true)
              form.find(`[name="zonadari"]`).prop('readonly', true)
              form.find(`[name="zonasampai"]`).prop('readonly', true)
              form.find(`[name="zona"]`).prop('readonly', true)
              form.find(`[name="parent"]`).prop('readonly', true)
              form.find(`[name="tarif"]`).prop('readonly', true)
              form.find(`[name="tarifmuatan"]`).prop('readonly', true)
              form.find(`[name="tarifbongkaran"]`).prop('readonly', true)
              form.find(`[name="tarifexport"]`).prop('readonly', true)
              form.find(`[name="tarifimport"]`).prop('readonly', true)
            }
          })
          .then(() => {
            $('#crudModal').modal('show')
            if (aksiEdit == false) {
              $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)
              let name = $('#crudForm').find(`[name]`).parents('.input-group')
              name.find('.button-clear').attr('disabled', true)
              name.children().find('.lookup-toggler').attr('disabled', true)

            } else {
              $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)

              let name = $('#crudForm').find(`[name]`).parents('.input-group')
              name.find('.button-clear').attr('disabled', false)
              name.children().find('.lookup-toggler').attr('disabled', false)

            }
            // $('#simpanKandang').hide()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteUpahSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Upah Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),

        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
          .then((upahsupir) => {
            initDropzone(form.data('action'), upahsupir)
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)
            $('#crudForm').find(`.ui-datepicker-trigger.btn.btn-easyui.text-easyui-dark`).attr('disabled', true)


            // $('#simpanKandang').hide()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })

      })
  }

  function viewUpahSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Upah Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),

        setTampilan(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
          .then((upahsupir) => {
            initDropzone(form.data('action'), upahsupir)
          })
          .then(stokId => {
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
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
            $(".dz-hidden-input").prop("disabled", true);

            // $('#simpanKandang').hide()
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
        value: 'UPAHSUPIR'
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

  /**
   * 
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
   * 
  */

  function cekValidasidelete(Id, aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}upahsupir/${Id}/cekValidasi`,
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
              editUpahSupir(selectedId)
            } else {
              showDialog(response.message['keterangan'])
            }
          } else {
            showDialog(response.message['keterangan'])
          }
        } else {
          if (aksi == 'EDIT') {
            aksiEdit = true
            editUpahSupir(selectedId)
          } else {
            deleteUpahSupir(selectedId)
          }
        }

        // 
      }
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}upahsupir/field_length`,
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

  function handleImageClick(event) {
    event.preventDefault();
    let imageUrl = event.target.src;
    if (imageUrl.substr(0, 4) == 'data') {
      var image = new Image();
      image.src = imageUrl;
      var w = window.open("");
      w.document.write(image.outerHTML);
    } else {
      window.open(imageUrl);
    }

  }


  function initDropzone(action, data = null) {
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`

    $('.dropzone').each((index, element) => {
      if (!element.dropzone) {
        let newDropzone = new Dropzone(element, {
          url: 'test',
          previewTemplate: document.querySelector('.dz-preview').innerHTML,
          thumbnailWidth: null,
          thumbnailHeight: null,
          autoProcessQueue: false,
          addRemoveLinks: true,
          dictRemoveFile: buttonRemoveDropzone,
          acceptedFiles: 'image/*',
          minFilesize: 50, // Set the minimum file size in kilobytes
          paramName: $(element).data('field'),
          init: function() {
            dropzones.push(this)
            this.on("addedfile", function(file) {
              if (this.files.length > 5) {
                this.removeFile(file);
              }
              if (file.size < (this.options.minFilesize * 1024)) {
                showDialog('ukuran file minimal 50 kb')
                this.removeFile(file);
              }
            });
          }
        })
      }
      element.dropzone.removeAllFiles()
      if (action == 'edit' || action == 'delete' || action == 'view') {
        assignAttachment(element.dropzone, data)
      }
    })
  }

  function assignAttachment(dropzone, data) {
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
    const paramName = dropzone.options.paramName
    const type = paramName.substring(5)

    if (data[paramName] == '') {
      $('.dropzone').each((index, element) => {
        if (!element.dropzone) {
          let newDropzone = new Dropzone(element, {
            url: 'test',
            previewTemplate: document.querySelector('.dz-preview').innerHTML,
            thumbnailWidth: null,
            thumbnailHeight: null,
            autoProcessQueue: false,
            addRemoveLinks: true,
            dictRemoveFile: buttonRemoveDropzone,
            acceptedFiles: 'image/*',
            minFilesize: 50, // Set the minimum file size in kilobytes
            paramName: $(element).data('field'),
            init: function() {
              dropzones.push(this)
              this.on("addedfile", function(file) {
                if (this.files.length > 5) {
                  this.removeFile(file);
                }
                if (file.size < (this.options.minFilesize * 1024)) {
                  showDialog('ukuran file minimal 50 kb')
                  this.removeFile(file);
                }
              });
            }
          })
        }

        element.dropzone.removeAllFiles()
      })
    } else {
      let files = JSON.parse(data[paramName])

      files.forEach((file) => {
        getImgURL(`${apiUrl}upahsupir/${file}/ori`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')

          if (fileBlob.type != 'text/html') {
            dropzone.options.addedfile.call(dropzone, imageFile);
            dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}upahsupir/${file}/ori`);
            dropzone.files.push(imageFile)
          }
        })
      })
    }
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
              "data": "UPAH SUPIR LUAR KOTA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLuarKota => {
            let option = new Option(statusLuarKota.text, statusLuarKota.id)

            relatedForm.find('[name=statusluarkota]').append(option).trigger('change')
          });

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
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  /*
  const setStatusSimpanKandangOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statussimpankandang]').empty()
      relatedForm.find('[name=statussimpankandang]').append(
        new Option('-- PILIH STATUS SIMPAN KANDANG --', '', false, true)
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
              "data": "STATUS SIMPAN KANDANG"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusSimpanKandang => {
            let option = new Option(statusSimpanKandang.text, statusSimpanKandang.id)

            relatedForm.find('[name=statussimpankandang]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  */

  const setStatusUpahZonaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusupahzona]').empty()
      relatedForm.find('[name=statusupahzona]').append(
        new Option('-- PILIH STATUS SIMPAN KANDANG --', '', false, true)
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
              "data": "STATUS UPAH ZONA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusUpahZona => {
            let option = new Option(statusUpahZona.text, statusUpahZona.id)

            relatedForm.find('[name=statusupahzona]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showUpahSupir(form, userId, parent = null) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}upahsupir/${userId}`,
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
            delete response.data['penyesuaian'];
            // delete response.data['statuspostingtnl'];
            delete response.data['tglmulaiberlaku'];
            delete response.data['tarif'];
            delete response.data['tarif_id'];
            delete response.data['tarifbongkaran'];
            delete response.data['tarifbongkaran_id'];
            delete response.data['tarifexport'];
            delete response.data['tarifexport_id'];
            delete response.data['tarifimport'];
            delete response.data['tarifimport_id'];
            delete response.data['tarifmuatan'];
            delete response.data['tarifmuatan_id'];
          }
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`).not(':file')
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if ((index == 'parent_id') && parent || (index == 'id') && parent) {
              console.log('parent');
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            // if (index == 'statuspostingtnl') {
            //   if (!parent) {
            //     element.prop('disabled', true)
            //   }
            // }
            if (index == 'tarif') {
              element.data('currentValue', value)
            }
            if (index == 'tarifmuatan') {
              element.data('currentValue', value)
            }
            if (index == 'tarifbongkaran') {
              element.data('currentValue', value)
            }
            if (index == 'tarifexport') {
              element.data('currentValue', value)
            }
            if (index == 'tarifimport') {
              element.data('currentValue', value)
            }
            // TAMBAH INI
            if (index == 'statuslangsirnama') {
              element.data('current-value', value)
            }

            if (index == 'statusaktifnama') {
              element.data('current-value', value)
            }
            // if(!parent && aksiEdit == true){
            //   console.log('tru kaaa')
            //   if (index == 'tujuan' || index == 'penyesuaian' || index == 'kotadari' || index == 'kotasampai' || index == 'zona' || index == 'parent' || index == 'tarif') {
            //     element.prop('readonly', true)
            //   }
            // }
          })
          if (parent) {

            $('#crudForm').find('[name=tglmulaiberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change')
            jarakFE = parseFloat(response.data.jarak) * 2
            form.find(`[name="jarakfullempty"]`).val(jarakFE)
          }
          initAutoNumeric(form.find(`[name="jarak"]`), {
            minimumValue: 0
          })
          initAutoNumeric(form.find(`[name="jarakfullempty"]`), {
            minimumValue: 0
          })
          // initAutoNumeric(form.find('.autonumeric'), {
          //   minimumValue: 0
          // })
          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            // $.each(response.data.upahsupir_rincian, (index, detail) => {
            let detailRow = $(`
              <tr>
                <td></td>
                <td>
                  <input type="hidden" name="container_id[]">
                  <input type="text" name="container[]" data-current-value="${detail.container}" class="form-control " readonly>
                </td>
                <td>
                  <input type="hidden" name="statuscontainer_id[]" class="form-control">
                  <input type="text" name="statuscontainer[]" data-current-value="${detail.statuscontainer}" class="form-control " readonly>
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
                
              </tr>
            `)

            detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
            detailRow.find(`[name="container[]"]`).val(detail.container)
            detailRow.find(`[name="statuscontainer_id[]"]`).val(detail.statuscontainer_id)
            detailRow.find(`[name="statuscontainer[]"]`).val(detail.statuscontainer)
            detailRow.find(`[name="nominalsupir[]"]`).val(detail.nominalsupir)
            detailRow.find(`[name="nominalkenek[]"]`).val(detail.nominalkenek)
            detailRow.find(`[name="nominalkomisi[]"]`).val(detail.nominalkomisi)
            detailRow.find(`[name="nominaltol[]"]`).val(detail.nominaltol)
            detailRow.find(`[name="liter[]"]`).val(detail.liter);

            $('#detailList tbody').append(detailRow)

            initAutoNumeric(detailRow.find('.autonumeric'), {
              minimumValue: 0
            })

            setNominalSupir()
            setNominalKenek()
            setNominalKomisi()
            setNominalTol()
          })
          // setuprowshow(userId);

          setRowNumbers()

          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function formatUpahZona(selectedUpahZona) {
    if (selectedUpahZona == 'NON UPAH ZONA') {
      setTimeout(() => {

        $('#crudForm ').find(`[name="zonadari"]`).prop('readonly', true)
        $('#crudForm ').find(`[name="zonasampai"]`).prop('readonly', true)
        $('#crudForm').find(`[name="zonadari"]`).parents('.input-group').find('.button-clear').attr('disabled', true)
        $('#crudForm').find(`[name="zonadari"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        $('#crudForm').find(`[name="zonasampai"]`).parents('.input-group').find('.button-clear').attr('disabled', true)
        $('#crudForm').find(`[name="zonasampai"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)

        $('#crudForm ').find(`[name="kotadari"]`).prop('readonly', false)
        $('#crudForm ').find(`[name="kotasampai"]`).prop('readonly', false)
        $('#crudForm ').find(`[name="parent"]`).prop('readonly', false)
        $('#crudForm ').find(`[name="tarif"]`).prop('readonly', false)
        $('#crudForm ').find(`[name="penyesuaian"]`).prop('readonly', false)
        $('#crudForm').find(`[name="kotadari"]`).parents('.input-group').find('.button-clear').attr('disabled', false)
        $('#crudForm').find(`[name="kotadari"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
        $('#crudForm').find(`[name="kotasampai"]`).parents('.input-group').find('.button-clear').attr('disabled', false)
        $('#crudForm').find(`[name="kotasampai"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
        $('#crudForm').find(`[name="parent"]`).parents('.input-group').find('.button-clear').attr('disabled', false)
        $('#crudForm').find(`[name="parent"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
        $('#crudForm').find(`[name="tarif"]`).parents('.input-group').find('.button-clear').attr('disabled', false)
        $('#crudForm').find(`[name="tarif"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
      }, 50);

    } else if (selectedUpahZona == 'UPAH ZONA') {
      setTimeout(() => {

        $('#crudForm ').find(`[name="kotadari"]`).prop('readonly', true)
        $('#crudForm ').find(`[name="kotasampai"]`).prop('readonly', true)
        $('#crudForm ').find(`[name="tarif"]`).prop('readonly', true)
        $('#crudForm ').find(`[name="parent"]`).prop('readonly', true)
        $('#crudForm ').find(`[name="penyesuaian"]`).prop('readonly', true)
        $('#crudForm').find(`[name="kotadari"]`).parents('.input-group').find('.button-clear').attr('disabled', true)
        $('#crudForm').find(`[name="kotadari"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        $('#crudForm').find(`[name="kotasampai"]`).parents('.input-group').find('.button-clear').attr('disabled', true)
        $('#crudForm').find(`[name="kotasampai"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        $('#crudForm').find(`[name="tarif"]`).parents('.input-group').find('.button-clear').attr('disabled', true)
        $('#crudForm').find(`[name="tarif"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        $('#crudForm').find(`[name="parent"]`).parents('.input-group').find('.button-clear').attr('disabled', true)
        $('#crudForm').find(`[name="parent"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)

        $('#crudForm ').find(`[name="zonadari"]`).prop('readonly', false)
        $('#crudForm ').find(`[name="zonasampai"]`).prop('readonly', false)
        $('#crudForm').find(`[name="zonadari"]`).parents('.input-group').find('.button-clear').attr('disabled', false)
        $('#crudForm').find(`[name="zonadari"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
        $('#crudForm').find(`[name="zonasampai"]`).parents('.input-group').find('.button-clear').attr('disabled', false)
        $('#crudForm').find(`[name="zonasampai"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
      }, 50);
    }
  }

  function getImgURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
      // console.log(xhr.response);
      callback(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}upahsupir/default`,
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
          })
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
          <input type="hidden" name="container_id[]">
          <input type="text" name="container[]" class="form-control container-lookup">
        </td>
        <td>
          <input type="hidden" name="statuscontainer_id[]" class="form-control">
          <input type="text" name="statuscontainer[]" class="form-control statuscontainer-lookup">
        </td>
        <td>
          <input type="text" name="nominalsupir[]" class="form-control autonumeric">
        </td>
        <td>
          <input type="text" name="nominalkenek[]" class="form-control autonumeric">
        </td>
        <td>
          <input type="text" name="nominalkomisi[]" class="form-control autonumeric ">
        </td>
        <td>
          <input type="text" name="nominaltol[]" class="form-control autonumeric">
        </td>
        <td>
          <input type="text" name="liter[]" class="form-control autonumeric">
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

    $('.statuscontainer-lookup').last().lookup({
      title: 'Status Container Lookup',
      fileName: 'statuscontainer',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (statuscontainer, element) => {
        $(`#crudForm [name="statuscontainer_id[]"]`).last().val(statuscontainer.id)
        element.val(statuscontainer.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="statuscontainer_id[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    initAutoNumeric(detailRow.find('.autonumeric'), {
      minimumValue: 0
    })

    setRowNumbers()
  }


  function setUpRow() {
    $.ajax({
      url: `${apiUrl}upahsupirrincian/setuprow`,
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
              <input type="hidden" name="container_id[]">
              <input type="text" name="container[]" data-current-value="${detail.container}" class="form-control" readonly>
            </td>
            <td>
              <input type="hidden" name="statuscontainer_id[]" class="form-control">
              <input type="text" name="statuscontainer[]" data-current-value="${detail.statuscontainer}" class="form-control" readonly>
            </td>
            <td>
              <input type="text" name="nominalsupir[]" data-current-value="${detail.nominalsupir}" class="form-control autonumeric">
            </td>
            <td>
              <input type="text" name="nominalkenek[]" data-current-value="${detail.nominalkenek}" class="form-control autonumeric">
            </td>
            <td>
              <input type="text" name="nominalkomisi[]" data-current-value="${detail.nominalkomisi}" class="form-control autonumeric">
            </td>
            <td>
              <input type="text" name="nominaltol[]" data-current-value="${detail.nominaltol}" class="form-control autonumeric">
            </td>
            <td>
              <input type="text" name="liter[]" data-current-value="${detail.liter}" class="form-control autonumeric">
            </td>
          </tr>
        `);

          detailRow.find(`[name="container_id[]"]`).val(detail.container_id);
          detailRow.find(`[name="container[]"]`).val(detail.container);
          detailRow.find(`[name="statuscontainer_id[]"]`).val(detail.statuscontainer_id);
          detailRow.find(`[name="statuscontainer[]"]`).val(detail.statuscontainer);

          // let nominalSupirInput = detailRow.find(`[name="nominalsupir[]"]`);
          // let nominalKenekInput = detailRow.find(`[name="nominalkenek[]"]`);

          // nominalSupirInput.val(detail.nominalsupir);
          // nominalKenekInput.val(detail.nominalkenek);


          // nominalSupirInput.on('input', function() {
          //   let cleanedInput = nominalSupirInput.val().replace(/\D/g, '');
          //   nominalSupirInput.val(cleanedInput);

          // });

          // nominalKenekInput.on('input', function() {
          //   let cleanedInput = nominalKenekInput.val().replace(/\D/g, '');
          //   nominalKenekInput.val(cleanedInput);
          // });


          initAutoNumeric(detailRow.find('.autonumeric'), {
            minimumValue: 0
          })

          setNominalSupir();
          setNominalKenek();
          setNominalKomisi();
          setNominalTol();

          $('#detailList tbody').append(detailRow);
        });

        setRowNumbers();
      }
    });
  }


  function setuprowshow(id) {
    $.ajax({
      url: `${apiUrl}upahsupirrincian/setuprowshow/${id}`,
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
                <input type="hidden" name="container_id[]">
                <input type="text" name="container[]" data-current-value="${detail.container}" class="form-control" readonly>
              </td>
              <td>
                <input type="hidden" name="statuscontainer_id[]" class="form-control">
                <input type="text" name="statuscontainer[]" data-current-value="${detail.statuscontainer}" class="form-control" readonly>
              </td>
              <td>
                <input type="text" name="nominalsupir[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="nominalkenek[]" class="form-control autonumeric" data-negative="false">
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
              
            </tr>
            `)
          detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
          detailRow.find(`[name="container[]"]`).val(detail.container)
          detailRow.find(`[name="statuscontainer_id[]"]`).val(detail.statuscontainer_id)
          detailRow.find(`[name="statuscontainer[]"]`).val(detail.statuscontainer)
          initAutoNumeric(detailRow.find('.autonumeric'), {
            minimumValue: 0
          })

          setNominalSupir()
          setNominalKenek()
          setNominalKomisi()
          setNominalTol()
          $('#detailList tbody').append(detailRow)

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
    setNominalSupir()
    setNominalKenek()
    setNominalKomisi()
    setNominalTol()

  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }




  function approvenonaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}upahsupir/approvalnonaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsUpahSupir
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsUpahSupir = []
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

  function initLookup() {
    $('.upahsupir-lookup').lookupMaster({
      title: 'Upah Supir Lookup',
      fileName: 'upahsupirMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'upahsupir_id',
          searchText: 'upahsupir-lookup',
          title: 'Upah Supir Lookup',
          typeSearch: 'ALL',
          isParent: true
        }
      },
      onSelectRow: (upahsupir, element) => {
        $('#crudForm [name=parent_id]').first().val(upahsupir.id)
        $('#crudForm [name=parent]').first().val(upahsupir.kotasampai_id)

        $('#crudForm').find(`[name=penyesuaian]`).val('').prop('readonly', false)
        $('#crudForm [name=kotasampai_id]').val('')
        $('#crudForm').find(`[name=kotasampai]`).val('').prop('readonly', false)
        // $('#kotaupahsupir').prop('disabled', false)
        // $('#kotaupahsupir').parent('.input-group').show()
        $('#kotatarif').prop('type', 'hidden')
        $('#kotatarif').prop('disabled', true).hide()

        element.data('currentValue', element.val())
        upahSupirKota = upahsupir.kotasampai_id;
        // Menghapus nilai autonumeric pada input jarak
        // $('#crudForm [name=jarak]').autoNumeric('remove')
        let jarakInput = $('#crudForm [name=jarak]').get(0); // Dapatkan elemen input jarak
        let jarakFEInput = $('#crudForm [name=jarakfullempty]').get(0); // Dapatkan elemen input jarak
        let autoNumericInstance = AutoNumeric.getAutoNumericElement(jarakInput); // Dapatkan instance AutoNumeric dari elemen tersebut
        let autoNumericInstanceFE = AutoNumeric.getAutoNumericElement(jarakFEInput); // Dapatkan instance AutoNumeric dari elemen tersebut

        if (autoNumericInstance) {
          autoNumericInstance.remove(); // Hapus efek AutoNumeric
        }
        if (autoNumericInstanceFE) {
          autoNumericInstanceFE.remove(); // Hapus efek AutoNumeric
        }

        let form = $('#crudForm')
        showUpahSupir(form, upahsupir.id, true).then((upahsupir) => {
          initDropzone('edit', upahsupir)
          element.val(upahSupirKota)
          element.data('currentValue', element.val())
        })
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=upahsupir_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.kotadari-lookup').lookupMaster({
      title: 'Kota Dari Lookup',
      fileName: 'kotaMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'kotadari_id',
          searchText: 'kotadari-lookup',
          title: 'Kota Dari Lookup',
          typeSearch: 'ALL',
          upahSupirDariKe: 'dari',
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudForm [name=kotadari_id]').first().val(kota.id)
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kotadari_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.kotasampai-lookup').lookupMaster({
      title: 'Kota Sampai Lookup',
      fileName: 'kotaMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'kotasampai_id',
          searchText: 'kotasampai-lookup',
          title: 'Kota Sampai Lookup',
          typeSearch: 'ALL',
          upahSupirDariKe: 'ke',
          upahSupirKotaDari: $('#crudForm [name=kotadari_id]').first().val(),
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudForm [name=kotasampai_id]').first().val(kota.id)
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kotasampai_id]').first().val('')
        $('#crudForm').find(`[name=kotasampai]`).prop('readonly', false)
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tarif-lookup').lookupMaster({
      title: 'Tarif Lookup',
      fileName: 'tarifMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'tarif_id',
          searchText: 'tarif-lookup',
          title: 'Tarif Lookup',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (tarif, element) => {
        $('#crudForm').find(`[name=penyesuaian]`).val(tarif.penyesuaian)
        $('#crudForm [name=kotasampai_id]').first().val(tarif.kotaId)
        $('#crudForm [name=kotasampai]').val(tarif.tujuan)
        $('#crudForm [name=kotasampai]').data('currentValue', tarif.tujuan)
        $('#crudForm [name=tarif_id]').first().val(tarif.id)
        // $('#crudForm').find(`[name=kotasampai]`).prop('readonly', true)
        // $('#kotaupahsupir').prop('readonly', true)
        // $('#kotaupahsupir').parent('.input-group').hide()
        $('#kotatarif').prop('type', 'text')
        $('#kotatarif').show()
        // $('#kotatarif').prop('readonly', true).show()

        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.input-group-append').show()
        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.button-clear').show()
        // element.val(tarif.tujuan + ' - ' + tarif.penyesuaian)
        element.val(tarif.tujuanpenyesuaian)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm').find(`[name=penyesuaian]`).val('').prop('readonly', false)
        $('#crudForm [name=kotasampai_id]').val('')
        $('#crudForm').find(`[name=kotasampai]`).val('').prop('readonly', false)
        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.input-group-append').show()
        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.button-clear').show()
        // $('#kotaupahsupir').prop('disabled', false)
        // $('#kotaupahsupir').parent('.input-group').show()
        $('#kotatarif').prop('type', 'hidden')
        $('#kotatarif').prop('disabled', true).hide()
        element.val('')
        element.data('currentValue', element.val())
        $('#crudForm [name=tarif_id]').val('')
      }
    })

    $('.zonadari-lookup').lookup({
      title: 'Zona Dari Lookup',
      fileName: 'zona',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (zona, element) => {
        $('#crudForm [name=zonadari_id]').first().val(zona.id)
        element.val(zona.zona)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=zonadari_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.zonasampai-lookup').lookup({
      title: 'Zona Sampai Lookup',
      fileName: 'zona',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (zona, element) => {
        $('#crudForm [name=zonasampai_id]').first().val(zona.id)
        element.val(zona.zona)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=zonasampai_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tarifmuatan-lookup').lookupMaster({
      title: 'Tarif Muatan Lookup',
      fileName: 'tarifMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'tarifmuatan_id',
          searchText: 'tarifmuatan-lookup',
          title: 'Tarif Muatan Lookup',
          typeSearch: 'ALL',
          jenisOrder: 'MUATAN'
        }
      },
      onSelectRow: (tarif, element) => {
        $('#crudForm [name=tarifmuatan_id]').first().val(tarif.id)
        element.val(tarif.tujuan + ' - ' + tarif.penyesuaian)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tarifmuatan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tarifbongkaran-lookup').lookupMaster({
      title: 'Tarif Bongkaran Lookup',
      fileName: 'tarifMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'tarifbongkaran_id',
          searchText: 'tarifbongkaran-lookup',
          title: 'Tarif Bongkaran Lookup',
          typeSearch: 'ALL',
          jenisOrder: 'BONGKARAN'
        }
      },
      onSelectRow: (tarif, element) => {
        $('#crudForm [name=tarifbongkaran_id]').first().val(tarif.id)
        element.val(tarif.tujuan + ' - ' + tarif.penyesuaian)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tarifbongkaran_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tarifexport-lookup').lookupMaster({
      title: 'Tarif Export Lookup',
      fileName: 'tarifMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'tarifexport_id',
          searchText: 'tarifexport-lookup',
          title: 'Tarif Export Lookup',
          typeSearch: 'ALL',
          jenisOrder: 'EKSPORT'
        }
      },
      onSelectRow: (tarif, element) => {
        $('#crudForm [name=tarifexport_id]').first().val(tarif.id)
        element.val(tarif.tujuan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tarifexport_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tarifimport-lookup').lookupMaster({
      title: 'Tarif Import Lookup',
      fileName: 'tarifMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'tarifimport_id',
          searchText: 'tarifimport-lookup',
          title: 'Tarif Import Lookup',
          typeSearch: 'ALL',
          jenisOrder: 'IMPORT'
        }
      },
      onSelectRow: (tarif, element) => {
        $('#crudForm [name=tarifimport_id]').first().val(tarif.id)
        element.val(tarif.tujuan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tarifimport_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.statuslangsir-lookup`).lookupMaster({
      title: 'Status Aktif Lookup',
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
    });

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

    $('.zona-lookup').lookupMaster({
      title: 'Zona Lookup',
      fileName: 'zonaMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'zona_id',
          searchText: 'zona-lookup',
          title: 'Zona Lookup',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (zona, element) => {
        $('#crudForm [name=zona_id]').first().val(zona.id)
        element.val(zona.zona)
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
  }
</script>
@endpush()
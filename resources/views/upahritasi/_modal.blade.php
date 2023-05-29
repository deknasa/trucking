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

            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Parent 
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="parent_id" class="form-control upahritasi-lookup">
              </div>
            </div> --}}

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  DARI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="kotadari_id">
                <input type="text" name="kotadari" class="form-control kotadari-lookup">
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
                <input type="text" name="kotasampai" class="form-control kotasampai-lookup">
              </div>
            </div>

            <div class="row form-group" style="display: none">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  ZONA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="zona_id">
                <input type="text" name="zona" class="form-control zona-lookup">
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
                  <input type="text" name="jarak" class="form-control autonumeric" style="text-align: right">
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
                <select name="statusaktif" class="form-control select2bs4">
                  <option value="">-- PILIH STATUS AKTIF --</option>
                </select>
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
            <div class="row form-group" style="display: none">
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
            <div class="row form-group" style="display: none">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS LUAR KOTA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusluarkota" class="form-control select2bs4" z-index="3">
                  <option value="">-- PILIH STATUS LUAR KOTA --</option>
                </select>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered mt-3 table-bindkeys" id="detailList" style="width:1000px">
                <thead>
                  <tr>
                    <th width="5%">NO</th>
                    <th width="50%">CONTAINER</th>
                    <th width="25%">NOMINAL SUPIR</th>
                    <th width="20%">LITER</th>
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
                      <input type="text" name="nominalsupir[]" class="form-control autonumeric">
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
                    <td colspan="2">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="nominalSupir"></p>
                    </td>
                    
                    <td></td>
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


    $("#crudForm [name]").attr("autocomplete", "off");
    $(document).on('click', '#addRow', function(event) {
      addRow()
    });

    $(document).on('input', `#table_body [name="nominalsupir[]"]`, function(event) {
      setNominalSupir()
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

        data.filter((row) => row.name === 'jarak').value = AutoNumeric.getNumber($(`#crudForm [name="jarak"]`)[0])


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
          url = `${apiUrl}upahritasi`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}upahritasi/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}upahritasi/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}upahritasi`
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
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          }).trigger('reloadGrid');
          
          if(id == 0){
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
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setNominalSupir() {
    let nominalDetails = $(`#table_body [name="nominalsupir[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#nominalSupir').set(total)
  }

  

  function createUpahRitasi() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Create Upah Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#table_body').html('')
    setUpRow()
    $('#crudForm').find('[name=tglmulaiberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglakhirberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
    .all([
        setStatusAktifOptions(form),
        setStatusLuarKotaOptions(form)
      ])
    .then(() => {
        showDefault(form)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
    setNominalSupir()
    // initAutoNumeric(form.find(`[name="jarak"]`))
    // initAutoNumeric(form.find(`[name="jarak"]`))
  }

  function editUpahRitasi(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Upah Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusLuarKotaOptions(form)
      ])
      .then(() => {
        showUpahRitasi(form, id)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteUpahRitasi(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Upah Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusLuarKotaOptions(form)
      ])
      .then(() => {
        showUpahRitasi(form, id)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}upahritasi/field_length`,
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

  function showUpahRitasi(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}upahritasi/${userId}`,
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

            if (index == 'kotadari') {
              element.data('current-value', value)
            }
            if (index == 'kotasampai') {
              element.data('current-value', value)
            }
            if (index == 'zona') {
              element.data('current-value', value)
            }
            
          

        })

       
        $.each(response.detail, (index, detail) => {
          // $.each(response.data.upahritasi_rincian, (index, detail) => {
          let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <input type="hidden" name="container_id[]">
                <input type="text" name="container[]" readonly data-current-value="${detail.container}" class="form-control container-lookup">
              </td>
              
              <td>
                <input type="text" name="nominalsupir[]" class="form-control autonumeric" data-current-value="${detail.nominalsupir}" >
              </td>
              
              <td>
                <input type="text" name="liter[]" class="form-control autonumeric" data-current-value="${detail.liter}">
              </td>
              
            </tr>
          `)

          console.log('response', response.detail);
          $.each(response.detail, (index, detail) => {
            // $.each(response.data.upahritasi_rincian, (index, detail) => {
            let detailRow = $(`
              <tr>
                <td></td>
                <td>
                  <input type="hidden" name="container_id[]">
                  <input type="text" name="container[]" readonly data-current-value="${detail.container}" class="form-control container-lookup">
                </td>
                
                <td>
                  <input type="text" name="nominalsupir[]" class="form-control autonumeric" data-current-value="${detail.nominalsupir}">
                </td>
                
                <td>
                  <input type="text" name="liter[]" class="form-control autonumeric" data-current-value="${detail.liter}">
                </td>
                
              </tr>
            `)


            detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
            detailRow.find(`[name="container[]"]`).val(detail.container)
            detailRow.find(`[name="nominalsupir[]"]`).val(detail.nominalsupir)
            detailRow.find(`[name="liter[]"]`).val(detail.liter);


          initAutoNumeric(detailRow.find('.autonumeric'))
          setNominalSupir()
        })

            $('#detailList tbody').append(detailRow)

            initAutoNumeric(detailRow.find('.autonumeric'))
            setNominalSupir()
          })

          setupRowShow(userId);
          setRowNumbers()

          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve()
        }
      })
    })
  }

  function setUpRow() {
    $.ajax({
        url: `${apiUrl}upahritasirincian/setuprow`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.detail, (index, detail) => {
            
            let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <input type="hidden" name="container_id[]">
                <input type="text" name="container[]" readonly data-current-value="${detail.container}" class="form-control" readonly>
              </td>
             
              <td>
                <input type="text" name="nominalsupir[]" data-current-value="${detail.nominalsupir}" class="form-control autonumeric">
              </td>
              
              <td>
                <input type="text" name="liter[]" data-current-value="${detail.liter}" class="form-control autonumeric">
              </td>
              
            </tr>
            `)
            detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
            detailRow.find(`[name="container[]"]`).val(detail.container)
            detailRow.find(`[name="nominalsupir[]"]`).val(detail.nominalsupir)
            detailRow.find(`[name="liter[]"]`).val(detail.liter)
            initAutoNumeric(detailRow.find('.autonumeric'))
            setNominalSupir()
            $('#detailList tbody').append(detailRow)
            
          })
          setRowNumbers()
        }
      })
   
  }
  function setupRowShow(id) {
    $.ajax({
        url: `${apiUrl}upahritasirincian/setuprowshow/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.detail, (index, detail) => {
            
            let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <input type="hidden" name="container_id[]">
                <input type="text" name="container[]" readonly data-current-value="${detail.container}" class="form-control" readonly>
              </td>
             
              <td>
                <input type="text" name="nominalsupir[]" class="form-control autonumeric" data-current-value="${detail.nominalsupir}" >
              </td>
              
              <td>
                <input type="text" name="liter[]" class="form-control autonumeric" data-current-value="${detail.liter}" >
              </td>
              
            </tr>
            `)
            detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
            detailRow.find(`[name="container[]"]`).val(detail.container)
            initAutoNumeric(detailRow.find('.autonumeric'))
            setNominalSupir()
            $('#detailList tbody').append(detailRow)
            
          })
          setRowNumbers()
        }
      })
   
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="container_id[]">
          <input type="text" name="container[]" class="form-control container-lookup" >
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
        
      </tr>
    `)

    $('#detailList tbody').append(detailRow)
    $('.container-lookup').last().lookup({
      title: 'Container Lookup',
      fileName: 'container',
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

  function deleteRow(row) {
    row.remove()

    setRowNumbers()
    setNominalSupir()
  }
  
  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}upahritasi/default`,
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
            } 
            else {
              element.val(value)
            }
          })
          resolve()
        }
      })
    })
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function initLookup() {
    $('.upahritasi-lookup').lookup({
      title: 'upah ritasi Lookup',
      fileName: 'upahritasi',
      onSelectRow: (upahritasi, element) => {

        $('#crudForm [name=parent_id]').first().val(upahritasi.id)
        element.data('currentValue', element.val())
        let form = $('#crudForm')
        showUpahRitasi(form,upahritasi.id)
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
    $('.kotadari-lookup').lookup({
      title: 'Kota Dari Lookup',
      fileName: 'kota',
      onSelectRow: (kota, element) => {
        $('#crudForm [name=kotadari_id]').first().val(kota.id)
        element.val(kota.keterangan)
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

    $('.kotasampai-lookup').lookup({
      title: 'Kota Tujuan Lookup',
      fileName: 'kota',
      onSelectRow: (kota, element) => {
        $('#crudForm [name=kotasampai_id]').first().val(kota.id)
        element.val(kota.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kotasampai_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.zona-lookup').lookup({
      title: 'Zona Lookup',
      fileName: 'zona',
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
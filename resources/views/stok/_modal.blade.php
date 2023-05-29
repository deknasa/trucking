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
            <div class="row form-group">
              <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">nama stok <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="namastok" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">nama terpusat </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="namaterpusat" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  status aktif <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS AKTIF --</option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">kelompok <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kelompok" class="form-control kelompok-lookup">
                <input type="text" id="kelompokId" name="kelompok_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">sub kelompok <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="subkelompok" class="form-control subkelompok-lookup">
                <input type="text" id="subkelompokId" name="subkelompok_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">kategori <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kategori" class="form-control kategori-lookup">
                <input type="text" id="kategoriId" name="kategori_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">merk </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="merk" class="form-control merk-lookup">
                <input type="text" id="merkId" name="merk_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">jenistrado </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="jenistrado" class="form-control jenistrado-lookup">
                <input type="text" id="jenistradoId" name="jenistrado_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">keterangan</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">qtymin </label>

              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="qtymin" style="text-align:right" class="form-control ">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">qtymax </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="qtymax" style="text-align:right" class="form-control ">
              </div>
            </div>

            <div class="row form-group">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Stok</label>
                  </div>
                </div>
                <div class="dropzone" data-field="gambar">
                  <div class="fallback">
                    <input name="gambar" type="file" />
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
  Dropzone.autoDiscover = false;

  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  let dropzones = []

  $(document).ready(function() {



    $(document).on('click', '.rmv', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let url
      let form = $('#crudForm')

      let formData = new FormData(form[0])
      let Id = form.find('[name=id]').val()

      dropzones.forEach(dropzone => {
        const {
          paramName
        } = dropzone.options

        dropzone.files.forEach((file, index) => {
          formData.append(`${paramName}[${index}]`, file)
        })
      })
      formData.delete(`qtymin`);
      $('#crudForm').find(`[name="qtymin"]`).each((index, element) => {
        formData.append(`qtymin`, AutoNumeric.getNumber($(`#crudForm [name="qtymin"]`)[index]))
      })
      formData.delete(`qtymax`);
      $('#crudForm').find(`[name="qtymax"]`).each((index, element) => {
        formData.append(`qtymax`, AutoNumeric.getNumber($(`#crudForm [name="qtymax"]`)[index]))
      })


      formData.append('sortIndex', $('#jqGrid').getGridParam().sortname)
      formData.append('sortOrder', $('#jqGrid').getGridParam().sortorder)
      formData.append('filters', $('#jqGrid').getGridParam('postData').filters)
      formData.append('indexRow', indexRow)
      formData.append('page', page)
      formData.append('limit', limit)

      if (form.data('action') == 'add') {
        url = `${apiUrl}stok`
      } else if (form.data('action') == 'edit') {
        url = `${apiUrl}stok/${Id}`
        formData.append('_method', 'PATCH')
      } else if (form.data('action') == 'delete') {
        url = `${apiUrl}stok/${Id}`
        formData.append('_method', 'DELETE')
      }

      // $('#crudForm').find(`[name="qtymin"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'qtymin')[index].value = AutoNumeric.getNumber($(`#crudForm [name="qtymin"]`)[index])
      // })
      // $('#crudForm').find(`[name="qtymax"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'qtymax')[index].value = AutoNumeric.getNumber($(`#crudForm [name="qtymax"]`)[index])
      // })
      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

      $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        data: formData,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

          dropzones.forEach(dropzone => {
            dropzone.removeAllFiles()
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

  function kodepengeluaran(kodepengeluaran) {
    $('#crudForm').find('[name=statusaktif]').val(kodepengeluaran).trigger('change');
    $('#crudForm').find('[name=statusaktif_id]').val(kodepengeluaran);
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    initLookup()
    initSelect2(form.find(`[name="statusaktif"]`))
    getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    $('#crudModal').find('.modal-body').html(modalBody)

    activeGrid = '#jqGrid'
  })


  function createStok() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    $('#crudModalTitle').text('Create Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
    .all([
      setStatusAktifOptions(form),
    ])
    .then(() => {
      showDefault(form)
        .then(() => {
          $('#crudModal').modal('show')
          disabledHirarkiKelompok()
        })
        .finally(() => {
          $('.modal-loader').addClass('d-none')
        })
    })

    initDropzone(form.data('action'))
    initAutoNumeric(form.find(`[name="qtymin"]`))
    initAutoNumeric(form.find(`[name="qtymax"]`))
  }

  function editStok(stokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showStok(form, stokId)
          .then((stok) => {
            initDropzone(form.data('action'), stok)
          })
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteStok(stokId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showStok(form, stokId)
          .then((stok) => {
            initDropzone(form.data('action'), stok)
          })
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
        url: `${apiUrl}stok/field_length`,
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}stok/default`,
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
        }
      })
    })
  }

  function showStok(form, stokId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}stok/${stokId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`).not(':file')

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else if (element.hasClass('autonumeric')) {
              initAutoNumeric(element)
              element.val(value)
            } else {
              element.val(value)
            }
          })
          resolve(response.data)
          initAutoNumeric(form.find(`[name="qtymin"]`))
          initAutoNumeric(form.find(`[name="qtymax"]`))
        }
      })
    })

  }

  function initDropzone(action, data = null) {
    $('.dropzone').each((index, element) => {
      if (!element.dropzone) {
        let newDropzone = new Dropzone(element, {
          url: 'test',
          autoProcessQueue: false,
          addRemoveLinks: true,
          acceptedFiles: 'image/*',
          paramName: $(element).data('field'),
          init: function() {
            dropzones.push(this)
          }
        })
      }

      element.dropzone.removeAllFiles()

      if (action == 'edit' || action == 'delete') {
        assignAttachment(element.dropzone, data)
      }
    })
  }

  function assignAttachment(dropzone, data) {
    const paramName = dropzone.options.paramName
    const type = paramName.substring(5)

    if (data[paramName] == '') {
      $('.dropzone').each((index, element) => {
        if (!element.dropzone) {
          let newDropzone = new Dropzone(element, {
            url: 'test',
            autoProcessQueue: false,
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            paramName: $(element).data('field'),
            init: function() {
              dropzones.push(this)
            }
          })
        }

        element.dropzone.removeAllFiles()
      })
    } else {

      let files = JSON.parse(data[paramName])

      files.forEach((file) => {
        getImgURL(`${apiUrl}stok/${file}/ori`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')

          dropzone.options.addedfile.call(dropzone, imageFile);
          dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}stok/${file}/ori`);
          dropzone.files.push(imageFile)
        })
      })
    }
  }

  function disabledHirarkiKelompok(middle=false) {
    
    let kategori = $('#crudForm').find(`[name="kategori"]`).parents('.input-group').children()
    kategori.attr('disabled', true)
    kategori.val('')
    kategori.find('.lookup-toggler').attr('disabled', true)
    $('#kategoriId').attr('disabled', true);
    $('#subkelompokId').val('');
    
    if (middle) {
      return "oke";
    }

    let subkelompok = $('#crudForm').find(`[name="subkelompok"]`).parents('.input-group').children()
    subkelompok.attr('disabled', true)
    subkelompok.val('')
    subkelompok.find('.lookup-toggler').attr('disabled', true)
    $('#subkelompokId').attr('disabled', true);
    $('#subkelompokId').val('');
    
    
  }

  function enabledSubKelompok() {
    let subkelompok = $('#crudForm').find(`[name="subkelompok"]`).parents('.input-group').children()
    subkelompok.attr('disabled', false)
    subkelompok.val('')
    subkelompok.find('.lookup-toggler').attr('disabled', false)
    $('#subkelompokId').attr('disabled', false);
    $('#subkelompokId').val('');
  }
  function enabledKategori() {
    let kategori = $('#crudForm').find(`[name="kategori"]`).parents('.input-group').children()
    kategori.attr('disabled', false)
    kategori.val('')
    kategori.find('.lookup-toggler').attr('disabled', false)
    $('#kategoriId').attr('disabled', false);
    $('#kategoriId').val('');
  }

  function initLookup() {

    $('.jenistrado-lookup').lookup({
      title: 'jenistrado Lookup',
      fileName: 'jenistrado',
      onSelectRow: (jenistrado, element) => {
        element.val(jenistrado.kodejenistrado)
        $(`#${element[0]['name']}Id`).val(jenistrado.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.merk-lookup').lookup({
      title: 'merk Lookup',
      fileName: 'merk',
      onSelectRow: (merk, element) => {
        element.val(merk.kodemerk)
        $(`#${element[0]['name']}Id`).val(merk.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.kelompok-lookup').lookup({
      title: 'kelompok Lookup',
      fileName: 'kelompok',
      onSelectRow: (kelompok, element) => {
        element.val(kelompok.kodekelompok)
        $(`#${element[0]['name']}Id`).val(kelompok.id)
        element.data('currentValue', element.val())
        enabledSubKelompok()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        disabledHirarkiKelompok()
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.subkelompok-lookup').lookup({
      title: 'subkelompok Lookup',
      fileName: 'subkelompok',
      beforeProcess: function(test) {
        this.postData = {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "kelompokid",
              "op": "cn",
              "data": $(`#kelompokId`).val()
            }]
          })
        }
      },
      onSelectRow: (subkelompok, element) => {
        element.val(subkelompok.kodesubkelompok)
        $(`#${element[0]['name']}Id`).val(subkelompok.id)
        element.data('currentValue', element.val())
        enabledKategori()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        disabledHirarkiKelompok(true)
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.kategori-lookup').lookup({
      title: 'kategori Lookup',
      fileName: 'kategori',
      beforeProcess: function(test) {
        this.postData = {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "subkelompok_id",
              "op": "cn",
              "data": $(`#subkelompokId`).val()
            }]
          })
        }
      },
      onSelectRow: (kategori, element) => {
        element.val(kategori.kodekategori)
        $(`#${element[0]['name']}Id`).val(kategori.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function getImgURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
      console.log(xhr.response);
      callback(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
  }

  function cekValidasidelete(Id) {
    $.ajax({
      url: `{{ config('app.api_url') }}stok/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          deleteStok(Id)
        }

      }
    })
  }
</script>
@endpush()
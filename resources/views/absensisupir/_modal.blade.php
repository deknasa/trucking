<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalTitle">Create Absensi Supir</p>
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
            <div class="row form-group">
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

                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
              </div>
            </div>

            <hr>
            <div class="row mt-5">
              <div class="col-md-12">
                  <div class="card" style="max-height:500px; overflow-y: scroll;">
                      <div class="card-body">
            <!-- <div class="table-responsive"> -->
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1800px;">
                <thead>
                  <tr>
                    <th width="2%">No</th>
                    <th width="13%">Trado</th>
                    <th width="15%">Supir</th>
                    <th width="30%">Keterangan</th>
                    <th width="15%">Status</th>
                    <th width="10%">Jam</th>
                    <th width="15%">Uang Jalan</th>
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
                      <input type="text" class="form-control inputmask-time" name="jam[]"></input>
                    </td>
                    <td>
                      <input type="text" class="form-control uangjalan autonumeric" name="uangjalan[]">
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                    </td> --}}

                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6">
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

    getMaxLength(form)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })



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

    $('#crudModalTitle').text('Add Absensi Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    setUpRow()
    setTotal()
  }


  function setUpRow() {
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
                      <input type="text" class="form-control inputmask-time" name="jam[]"></input>
                    </td>
                    <td>
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
      }
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
        $('#crudModal').modal('show')
        form.find('[name=tglbukti]').attr('readonly', true)
        form.find('[name=tglbukti]').siblings('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteAbsensiSupir(absensiId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Absensi Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        showAbsensiSupir(form, absensiId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
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
            <tr>
              <td></td>
              <td>
                <input type="hidden" name="trado_id[]" value="${detail.trado_id}">
                <input type="text" name="trado[]" data-current-value="${detail.trado}" class="form-control" value="${detail.trado}" readonly>
              </td>
              <td>
                <input type="hidden" name="supir_id[]">
                <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup" value="${detail.supir}">
              </td>
              <td>
                <input type="text" name="keterangan_detail[]" class="form-control" value="${detail.keterangan}">
              </td>
              <td>
                <input type="hidden" name="absen_id[]" value="${detail.absen_id}">
                <input type="text" name="absen"  data-current-value="${detail.absen}" class="form-control absentrado-lookup" value="${detail.absen}">
              </td>
              <td>
                <input type="text" class="form-control inputmask-time" name="jam[]" value="${detail.jam}"></input>
              </td>
              <td>
                <input type="text" class="form-control uangjalan autonumeric" name="uangjalan[]" value="${detail.uangjalan}">
              </td>
            

            </tr>
            `)

            detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
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
          <input type="text" class="form-control inputmask-time" name="jam[]"></input>
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
    row.remove()

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

  function cekValidasi(Id, Aksi) {
    let url 
    if (Aksi == 'EDIT') {
      url = `{{ config('app.api_url') }}absensisupirheader/${Id}/cekvalidasi`;
    }
    if (Aksi == 'DELETE') {
      url = `{{ config('app.api_url') }}absensisupirheader/${Id}/cekvalidasi`;
    }
    $.ajax({
      url:url,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kodenobukti = response.kodenobukti
        if (kodenobukti == '1') {
          var kodestatus = response.kodestatus
          if (kodestatus == '1') {
            showDialog(response.message['keterangan'])
          } else {
            if (Aksi == 'EDIT') {
              editAbsensiSupir(Id)
            }
            if (Aksi == 'DELETE') {
              deleteAbsensiSupir(Id)
            }
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }
  
  function cekValidasiAksi(Id,Aksi){
    $.ajax({ 
      url: `{{ config('app.api_url') }}absensisupirheader/${Id}/cekValidasiAksi`,
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
            if (Aksi == 'EDIT') {
              editAbsensiSupir(Id)
            }
            if (Aksi == 'DELETE') {
              deleteAbsensiSupir(Id)
            }
          }
      }
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
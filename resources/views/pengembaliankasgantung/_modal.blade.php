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
          <input type="hidden" name="id">
          <div class="modal-body">
            <div class="row">

              <div class="col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>
                      NO BUKTI
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="nobukti" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>
                      TANGGAL BUKTI <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <div class="input-group">
                      <input type="text" name="tglbukti" class="form-control datepicker">
                    </div>
                  </div>
                </div>
              </div>

              {{-- <div class="col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>COA KAS MASUK </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="coa" class="form-control akunpusat-lookup">
                  </div>
                </div>
              </div> --}}

              <div class="col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>PELANGGAN</label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                    <input type="text" id="pelangganId" name="pelanggan_id" readonly hidden>
                  </div>
                </div>
              </div>



              <div class="col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>
                      DARI TANGGAL
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8 ">
                    <div class="input-group">
                      <input type="text" name="tgldari" class="form-control datepicker">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>
                      SAMPAI TANGGAL
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8 ">
                    <div class="input-group">
                      <input type="text" name="tglsampai" class="form-control datepicker">
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="border p-3">
              <h6>Posting Penerimaan</h6>
              
              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    POSTING </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="bank" class="form-control" readonly>
                  <input type="text" id="bankId" name="bank_id"  hidden>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    NO BUKTI KAS KELUAR </label>
                </div>
                <div class="col-12 col-md-4">
                <input type="text" name="penerimaan_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>


            <div class="col-md-12" style="overflow-x:scroll">
              <table class="table table-bordered mt-3" id="detailList" style="table-layout:auto">
                <thead id="table_body" class="table-secondary">
                  <tr>
                    <th>PILIH</th>
                    <th>NO </th>
                    <th>NO BUKTI</th>
                    <th>TGL BUKTI</th>
                    <th>coa</th>
                    <th>NOMINAL</th>
                    <th>KETERANGAN</th>
                  </tr>
                </thead>
                <tbody id="table_body">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"></td>
                    <td>
                      <p id="nominalPiutang" class="text-right font-weight-bold"></p>
                    </td>
                    <th></th>


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

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })
    $(document).on('click', '.checkItem', function(event) {
      enabledRow($(this).data("id"))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
    })




    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let userId = form.find('[name=user_id]').val()
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      // let data = []
      // $('#crudForm').find(`[name="nominal[]"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
      // })
      let data = []

      data.push({
        name: 'id',
        value: form.find(`[name="id"]`).val()
      })
      data.push({
        name: 'nobukti',
        value: form.find(`[name="nobukti"]`).val()
      })
      data.push({
        name: 'tglbukti',
        value: form.find(`[name="tglbukti"]`).val()
      })
      data.push({
        name: 'bank',
        value: form.find(`[name="bank"]`).val()
      })
      data.push({
        name: 'bank_id',
        value: form.find(`[name="bank_id"]`).val()
      })
      data.push({
        name: 'pelanggan',
        value: form.find(`[name="pelanggan"]`).val()
      })
      data.push({
        name: 'pelanggan_id',
        value: form.find(`[name="pelanggan_id"]`).val()
      })
      data.push({
        name: 'tgldari',
        value: form.find(`[name="tgldari"]`).val()
      })
      data.push({
        name: 'tglsampai',
        value: form.find(`[name="tglsampai"]`).val()
      })
      data.push({
        name: 'penerimaan_nobukti',
        value: form.find(`[name="penerimaan_nobukti"]`).val()
      })


      $('#table_body tr').each(function(row, tr) {


        if ($(this).find(`[name="kasgantungdetail_id[]"]`).is(':checked')) {

          data.push({
            name: 'keterangandetail[]',
            value: $(this).find(`[name="keterangandetail[]"]`).val()
          })
          data.push({
            name: 'coadetail[]',
            value: $(this).find(`[name="coadetail[]"]`).val()
          })
          data.push({
            name: 'ketcoadetail[]',
            value: $(this).find(`[name="ketcoadetail[]"]`).val()
          })
          data.push({
            name: 'kasgantungdetail_id[]',
            value: $(this).find(`[name="kasgantungdetail_id[]"]`).val()
          })

        }
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
          url = `${apiUrl}pengembaliankasgantungheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengembaliankasgantungheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengembaliankasgantungheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengembaliankasgantungheader`
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

    // getMaxLength(form)

    initDatepicker()

    $(`[name=tgldari], [name=tglsampai]`)
      .on("change", function() {
        rangeKasgantung();
      })
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker()

  })

  function rangeKasgantung() {
    var tgldari = $('#crudForm').find(`[name="tgldari"]`).val()
    var tglsampai = $('#crudForm').find(`[name="tglsampai"]`).val()
    // console.log(tgldari, tglsampai);
    if (tgldari !== "" && tglsampai !== "") {
      getKasGantung(tgldari, tglsampai)
    }

  }

  function enabledRow(row) {
    let check = $(`#kasgantungdetail_${row}`)
    if (check.prop("checked") == true) {
      // console.log(row);
      $(`#coa_detail_${row}`).prop('disabled', false)
      $(`#keterangan_detail_${row}`).prop('disabled', false)
    } else if (check.prop("checked") == false) {
      // console.log('disabale');
      $(`#coa_detail_${row}`).prop('disabled', true)
      $(`#keterangan_detail_${row}`).prop('disabled', true)
    }

  }

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPengembalianKasGantung() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Kas Gantung')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    initLookup()

    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    showDefault(form)
  }

  function editPengembalianKasGantung(userId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Kas Gantung')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    initLookup()
    showpengembalianKasGantung(form, userId)
    getPengembalian(userId)

  }

  function deletePengembalianKasGantung(userId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Kas Gantung')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    showpengembalianKasGantung(form, userId)
    getPengembalian(userId)
  }



  function showpengembalianKasGantung(form, userId) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}pengembaliankasgantungheader/${userId}`,
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

      }
    })
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getKasGantung(dari, sampai) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}pengembaliankasgantungheader/getkasgantung`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        tgldari: dari,
        tglsampai: sampai
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        let row = 0
        $('#detailList tbody').html('')
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td ><input name='kasgantungdetail_id[]' type="checkbox" class="checkItem" id="kasgantungdetail_${detail.detail_id}" data-id="${detail.detail_id}"  value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>${detail.nobukti}</td>
            <td>${detail.tglbukti}</td>
            <td>
              <input type="hidden" name="coadetail[]">
               <input type="text" name="ketcoadetail[]" disabled id="coa_detail_${detail.detail_id}"  class="form-control coa_detail_${detail.detail_id}">
              </td>
            <td class="text-right" >${nominal}</td>
            <td><input type="text" name="keterangandetail[]" disabled id="keterangan_detail_${detail.detail_id}"  class="form-control keterangan_detail_${detail.detail_id}"></td>
          </tr>`)
          $('#detailList tbody').append(detailRow)
          $(`.coa_detail_${detail.detail_id}`).lookup({
            title: 'akun pusat Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
              // var levelcoa = $(`#levelcoa`).val();
              this.postData = {
                levelCoa: '3',
                Aktif: 'AKTIF',
              }
            },
            onSelectRow: (akunpusat, element) => {
              element.parents('td').find(`[name="coadetail[]"]`).val(akunpusat.coa)
              element.val(akunpusat.keterangancoa)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              element.parents('td').find(`[name="coadetail[]"]`).val('')
              element.val('')
              element.data('currentValue', element.val())
            }
          })
        })
         totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        $('#nominalPiutang').html(`${totalNominal}`)
      }
    })
  }

  function getPengembalian(userId) {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}pengembaliankasgantungheader/getpengembalian/${userId}`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        // console.log(response);
        let totalNominal = 0
        let row = 0
        $('#detailList tbody').html('')
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td ><input name='kasgantungdetail_id[]' type="checkbox" checked class="checkItem" id="kasgantungdetail_${detail.detail_id}" data-id="${detail.detail_id} "  value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>${detail.nobukti}</td>
            <td>${detail.tglbukti}</td>
            <td> <input type="text" name="coadetail[]" value="${detail.coadetail}" id="coa_detail_${detail.detail_id}" class="form-control coa-lookup coa_detail_${detail.detail_id}"></td>
            <td class="text-right" >${nominal}</td>
            <td><input type="text" name="keterangandetail[]" value="${detail.keterangandetail}" id="keterangan_detail_${detail.detail_id}" class="form-control"></td>
          </tr>`)
          $('#detailList tbody').append(detailRow)
          $(`.coa_detail_${detail.detail_id}`).lookup({
            title: 'akun pusat Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
              // var levelcoa = $(`#levelcoa`).val();
              this.postData = {
                levelCoa: '3',
                Aktif: 'AKTIF',
              }
            },
            onSelectRow: (akunpusat, element) => {
              element.val(akunpusat.coa)
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
        })
        totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        $('#nominalPiutang').html(`${totalNominal}`)
      }
    })

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengembaliankasgantungheader/field_length`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
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
          console.log(error);

          showDialog(error.statusText)
        }
      })
    }
  }


  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengembaliankasgantungheader/${Id}/cekvalidasi`,
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
            cekValidasiAksi(Id,Aksi)
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }

   
  function cekValidasiAksi(Id,Aksi){
    $.ajax({
      url: `{{ config('app.api_url') }}pengembaliankasgantungheader/${Id}/cekValidasiAksi`,
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
              editPengembalianKasGantung(Id)
            }
            if (Aksi == 'DELETE') {
              deletePengembalianKasGantung(Id)
            }
          }

      }
    })
  }
  

  function showDefault(form) {
    $.ajax({
      url: `${apiUrl}pengembaliankasgantungheader/default`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        bankId = response.data.bank_id

        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          // let element = form.find(`[name="statusaktif"]`)

          if (element.is('select')) {
            element.val(value).trigger('change')
          } else {
            element.val(value)
          }
        })
      }
    })
  }

  function initLookup() {
    $('.akunpusat-lookup').lookup({
      title: 'akun pusat Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        element.val(akunpusat.coa)
        element.data('currentValue', element.val())
      },

      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaan-lookup').lookup({
      title: 'penerimaan Lookup',
      fileName: 'penerimaan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (penerimaan, element) => {
        element.val(penerimaan.nobukti)
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
    $('.pelanggan-lookup').lookup({
      title: 'pelanggan Lookup',
      fileName: 'pelanggan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pelanggan, element) => {
        element.val(pelanggan.namapelanggan)
        $(`#${element[0]['name']}Id`).val(pelanggan.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }
    })
    $('.bank-lookup').lookup({
      title: 'bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (bank, element) => {
        element.val(bank.namabank)
        $(`#${element[0]['name']}Id`).val(bank.id)
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
</script>
@endpush()
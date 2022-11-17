<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm" >
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

            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                    NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>

              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                TANGGAL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                    <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                PELANGGAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="pelanggan_id">
                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                KETERANGAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                CABANG <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="cabang_id">
                <input type="text" name="cabang" class="form-control cabang-lookup">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                STATUS JENIS TRANSAKSI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                 <select name="statusjenistransaksi" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS JENIS TRANSAKSI --</option>
                 </select>
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                DIBAYAR KE <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="dibayarke" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                BANK <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="bank_id">
                <input type="text" name="bank" class="form-control bank-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                TRANSFER KE ACC 
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="transferkeac" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                TRANSFER KE AN
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="transferkean" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                TRANSFER KE BANK 
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="transferkebank" class="form-control">
              </div>
            </div>

            <table class="table table-bordered table-bindkeys" id="detailList">
              <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Alat Bayar</th>
                    <th>No warkat</th>
                    <th>Tgl jatuh tempo</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                    <th>Coa Debet</th>
                    <th>Bulan beban</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
                

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5">
                    <p class="text-right font-weight-bold">TOTAL :</p>
                  </td>
                  <td>
                    <p class="text-right font-weight-bold autonumeric" id="total"></p>
                  </td>
                  <td colspan="2"></td>
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
  let modalBody = $('#crudModal').find('.modal-body').html()

  $(document).ready(function() {
    
    $(document).on('click', "#addRow", function() {
      addRow()
    });
    
    $(document).on('click', '.delete-row', function(event) {
        deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
      setTotal()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      
      $('#crudForm').find(`[name="nominal_detail[]"`).each((index,element) => {
        data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
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
      console.log(data)
      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pengeluaranheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluaranheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengeluaranheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluaranheader`
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
          console.log(id)
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')

          $('#jqGrid').jqGrid('setGridParam', { page: response.data.page}).trigger('reloadGrid');

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
    initSelect2()
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPengeluaran() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    
    $('#crudModalTitle').text('Add Pengeluaran')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    
    $('#table_body').html('')
    
    setStatusJenisTransaksiOptions(form)
    addRow()
    setTotal()
  }

  function editPengeluaran(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Pengeluaran')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setStatusJenisTransaksiOptions(form)
      ])
      .then(() => {
        showPengeluaran(form, id)
      })

  }

  function deletePengeluaran(id) {

    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Pengeluaran')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setStatusJenisTransaksiOptions(form)
      ])
      .then(() => {
        showPengeluaran(form, id)
      })

  }

  function approval(Id) {
    $('#loader').removeClass('d-none')

      $.ajax({
        url: `{{ config('app.api_url') }}pengeluaranheader/${Id}/approval`,
        method: 'POST',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        success: response => {
          $('#jqGrid').trigger('reloadGrid')
        }
    }).always(() => {
        $('#loader').addClass('d-none')
      })
  }

  function cekApproval(Id, Aksi) {
    $.ajax({
        url: `{{ config('app.api_url') }}jurnalumumheader/${Id}/cekapproval`,
        method: 'POST',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        success: response => {
          var kodenobukti = response.kodenobukti
          if(kodenobukti == '1')
          {
            var kodestatus = response.kodestatus
            if(kodestatus == '1')
            {
              showDialog(response.message['keterangan'])
            }else{
                if(Aksi == 'EDIT') {
                    editJurnalUmumHeader(Id)
                }
                if(Aksi == 'DELETE') {
                    deleteJurnalUmumHeader(Id)
                }
            }
            
          }else{
            showDialog(response.message['keterangan'])
          }
        }
      })
  }

  const setStatusJenisTransaksiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusjenistransaksi]').empty()
      relatedForm.find('[name=statusjenistransaksi]').append(
        new Option('-- PILIH STATUS JENIS TRANSAKSI --', '', false, true)
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
              "data": "JENIS TRANSAKSI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusJenisTransaksi => {
            let option = new Option(statusJenisTransaksi.text, statusJenisTransaksi.id)

            relatedForm.find('[name=statusjenistransaksi]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function showPengeluaran(form, id) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}pengeluaranheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let tgl = response.data.tglbukti

        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          if (element.is('select')) {
            element.val(value).trigger('change')
          } else if(element.hasClass('datepicker')){
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }
          
          if(index == 'pelanggan') {
            element.data('current-value', value)
          }
          if(index == 'cabang') {
            element.data('current-value', value)
          }
          if(index == 'bank') {
            element.data('current-value', value)
          }
        })

        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="alatbayar_id[]">
                    <input type="text" name="alatbayar[]" data-current-value="${detail.alatbayar}" class="form-control alatbayar-lookup">
                </td>
                <td>
                    <input type="text" name="nowarkat[]"  class="form-control">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
                    </div>
                </td>
                <td>
                    <input type="text" name="keterangan_detail[]"  class="form-control">
                </td>
                <td>
                    <input type="text" name="nominal_detail[]" class="form-control autonumeric nominal"> 
                </td>
                <td>
                <input type="text" name="coadebet[]" data-current-value="${detail.coadebet}" class="form-control akunpusat-lookup">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="bulanbeban[]" class="form-control datepicker">   
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                </td>
            </tr>
          `)

          detailRow.find(`[name="alatbayar_id[]"]`).val(detail.alatbayar_id)
          detailRow.find(`[name="alatbayar[]"]`).val(detail.alatbayar)
          detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
          detailRow.find(`[name="tgljatuhtempo[]"]`).val(detail.tgljatuhtempo)
          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
          detailRow.find(`[name="coadebet[]"]`).val(detail.coadebet)
          detailRow.find(`[name="bulanbeban[]"]`).val(detail.bulanbeban)

          initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
          
          detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
          $('#detailList tbody').append(detailRow)
          
          setTotal();
          
          $('.alatbayar-lookup').last().lookup({
            title: 'Coa Kredit Lookup',
            fileName: 'alatbayar',
            onSelectRow: (alatbayar, element) => {
             
             element.parents('td').find(`[name="alatbayar_id[]"]`).val(alatbayar.id)
              element.val(alatbayar.coa)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            }
          })
          $('.akunpusat-lookup').last().lookup({
              title: 'Kode Perk. Lookup',
              fileName: 'akunpusat',
              onSelectRow: (akunpusat, element) => {
                  element.val(akunpusat.coa)
                  element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                  element.val(element.data('currentValue'))
              }
          })

          
        })

        setRowNumbers()
        initDatepicker()
        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }

  function addRow(){
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="alatbayar_id[]">
          <input type="text" name="alatbayar[]"  class="form-control alatbayar-lookup">
        </td>
        <td>
          <input type="text" name="nowarkat[]"  class="form-control">
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
          </div>
        </td>
        <td>
          <input type="text" name="keterangan_detail[]"  class="form-control">
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
            <input type="text" name="coadebet[]"  class="form-control akunpusat-lookup">
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="bulanbeban[]" class="form-control datepicker">   
          </div>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)
    
    $('#detailList tbody').append(detailRow)

    $('.alatbayar-lookup').last().lookup({
      title: 'Alat Bayar Lookup',
      fileName: 'alatbayar',
      onSelectRow: (alatbayar, element) => {
        element.parents('td').find(`[name="alatbayar_id[]"]`).val(alatbayar.id)
        element.val(alatbayar.namaalatbayar)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
    $('.akunpusat-lookup').last().lookup({
        title: 'Kode Perkiraan Lookup',
        fileName: 'akunpusat',
        onSelectRow: (akunpusat, element) => {
            element.val(akunpusat.coa)
            element.data('currentValue', element.val())
        },
        onCancel: (element) => {
            element.val(element.data('currentValue'))
        }
    })
    initAutoNumeric(detailRow.find('.autonumeric'))
    initDatepicker()
    setRowNumbers()
  }

  function deleteRow(row) {
    row.remove()

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index+1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengeluaranheader/field_length`,
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

  function initLookup() {
  
    $('.pelanggan-lookup').lookup({
      title: 'Pelanggan Lookup',
      fileName: 'pelanggan',
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
        element.val(pelanggan.namapelanggan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
    $('.cabang-lookup').lookup({
      title: 'Cabang Lookup',
      fileName: 'cabang',
      onSelectRow: (cabang, element) => {
        $('#crudForm [name=cabang_id]').first().val(cabang.id)
        element.val(cabang.namacabang)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      onSelectRow: (bank, element) => {
        $('#crudForm [name=bank_id]').first().val(bank.id)
        element.val(bank.namabank)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
  }
</script>
@endpush()
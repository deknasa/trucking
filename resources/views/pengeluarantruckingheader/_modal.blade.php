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
                  KODE PENGELUARAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="pengeluarantrucking_id">
                <input type="text" name="pengeluarantrucking" class="form-control pengeluarantrucking-lookup">
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
                  BANK <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="bank_id">
                <input type="text" name="bank" class="form-control bank-lookup">
              </div>
            </div>

            <!-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  STATUS POSTING <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statusposting" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS POSTING --</option>
                </select>
              </div>
            </div> -->

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  COA
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="coa" class="form-control akunpusat-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO BUKTI PENGELUARAN
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="pengeluaran_nobukti" class="form-control pengeluaran-lookup">
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1350px;">
                <thead>
                  <tr>
                    <th width="1%">No</th>
                    <th width="5%">SUPIR</th>
                    <th width="5%">NO BUKTI PENERIMAAN TRUCKING</th>
                    <th width="6%">Nominal</th>
                    <th width="1%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                    <td>
                      <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                    </td>
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

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
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

      $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
        data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
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
          url = `${apiUrl}pengeluarantruckingheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluarantruckingheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengeluarantruckingheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluarantruckingheader`
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
    let nominalDetails = $(`#table_body [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPengeluaranTruckingHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Pengeluaran Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')

    setStatusPostingOptions(form)
    addRow()
    setTotal()
  }

  function editPengeluaranTruckingHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Pengeluaran Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // Promise
    //   .all([
    //     setStatusPostingOptions(form)
    //   ])
    //   .then(() => {
    //     showPengeluaranTruckingHeader(form, id)
    //   })
    showPengeluaranTruckingHeader(form, id)

  }

  function deletePengeluaranTruckingHeader(id) {

    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Pengeluaran Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // Promise
    //   .all([
    //     setStatusPostingOptions(form)
    //   ])
    //   .then(() => {
    //     showPengeluaranTruckingHeader(form, id)
    //   })
    showPengeluaranTruckingHeader(form, id)

  }

  const setStatusPostingOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusposting]').empty()
      relatedForm.find('[name=statusposting]').append(
        new Option('-- PILIH STATUS POSTING --', '', false, true)
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
              "data": "STATUS POSTING"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPosting => {
            let option = new Option(statusPosting.text, statusPosting.id)

            relatedForm.find('[name=statusposting]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function showPengeluaranTruckingHeader(form, id) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}pengeluarantruckingheader/${id}`,
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
          } else if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }

          if (index == 'pengeluarantrucking') {
            element.data('current-value', value)
          }
          if (index == 'bank') {
            element.data('current-value', value)
          }
          if (index == 'coa') {
            element.data('current-value', value)
          }
          if (index == 'pengeluaran_nobukti') {
            element.data('current-value', value)
          }
        })

        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="supir_id[]">
                    <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                </td>
                <td>
                    <input type="text" name="penerimaantruckingheader_nobukti[]" data-current-value="${detail.penerimaantruckingheader_nobukti}" class="form-control penerimaantruckingheader-lookup">
                </td>
                <td>
                    <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                </td>
            </tr>
          `)

          detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
          detailRow.find(`[name="supir[]"]`).val(detail.supir)
          detailRow.find(`[name="penerimaantruckingheader_nobukti[]"]`).val(detail.penerimaantruckingheader_nobukti)
          detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          $('#detailList tbody').append(detailRow)

          setTotal();

          $('.supir-lookup').last().lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
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

          $('.penerimaantruckingheader-lookup').last().lookup({
            title: 'Penerimaan Trucking Lookup',
            fileName: 'penerimaantruckingheader',
            onSelectRow: (penerimaantruckingheader, element) => {
              element.val(penerimaantruckingheader.nobukti)
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

        setRowNumbers()
        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="supir_id[]">
          <input type="text" name="supir[]"  class="form-control supir-lookup">
        </td>
        <td>
          <input type="text" name="penerimaantruckingheader_nobukti[]"  class="form-control penerimaantruckingheader-lookup">
        </td>
        <td>
          <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    $('.supir-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      onSelectRow: (supir, element) => {
        $(`#crudForm [name="supir_id[]"]`).last().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=supir_id]').last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaantruckingheader-lookup').last().lookup({
      title: 'Penerimaan Trucking Lookup',
      fileName: 'penerimaantruckingheader',
      onSelectRow: (penerimaantruckingheader, element) => {
        element.val(penerimaantruckingheader.nobukti)
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

    initAutoNumeric(detailRow.find('.autonumeric'))
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

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
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/field_length`,
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

    $('.pengeluarantrucking-lookup').lookup({
      title: 'Pengeluaran Trucking Lookup',
      fileName: 'pengeluarantrucking',
      onSelectRow: (pengeluarantrucking, element) => {
        $('#crudForm [name=pengeluarantrucking_id]').first().val(pengeluarantrucking.id)
        element.val(pengeluarantrucking.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pengeluarantrucking_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
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
      },
      onClear: (element) => {
        $('#crudForm [name=bank_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.pengeluaran-lookup').lookup({
      title: 'Pengeluaran Lookup',
      fileName: 'pengeluaranheader',
      onSelectRow: (pengeluaranheader, element) => {
        element.val(pengeluaranheader.nobukti)
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

    $('.akunpusat-lookup').lookup({
      title: 'Kode Perk. Lookup',
      fileName: 'akunpusat',
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
  }
</script>
@endpush()
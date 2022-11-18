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
            <div class="row form-group">
              <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>nobukti <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>tglbukti <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
            </div>

            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>penerimaan stok <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="penerimaanstok" class="form-control penerimaanstok-lookup">
                <input type="text" id="penerimaanstokId" name="penerimaanstok_id" hidden readonly>
              </div>
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>STATUS FORMAT <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <select name="statusformat" disabled class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS FORMAT --</option>
                </select>

                <input type="text" name="statusformat_id" readonly hidden class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>penerimaan stok nobukti </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="penerimaanstok_nobukti" class="form-control penerimaanstokheader-lookup">
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>pengeluaran stok nobukti </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="pengeluaranstok_nobukti" class="form-control pengeluaranstokheader-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>nobon </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="nobon" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>hutang no bukti </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="hutang_nobukti" class="form-control hutang-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>trado </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="trado" class="form-control trado-lookup">
                <input type="text" id="tradoId" name="trado_id" hidden readonly>
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>supplier </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="supplier" class="form-control supplier-lookup">
                <input type="text" id="supplierId" name="supplier_id" hidden readonly>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>gudang </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="gudang" class="form-control gudang-lookup">
                <input type="text" id="gudangId" name="gudang_id" hidden readonly>
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>coa </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="coa" class="form-control akunpusat-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>gudangdari </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="gudangdari" class="form-control gudang-lookup">
                <input type="text" id="gudangdariId" name="gudangdari_id" hidden readonly>
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>gudangke </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="gudangke" class="form-control gudang-lookup">
                <input type="text" id="gudangkeId" name="gudangke_id" hidden readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>keterangan <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>coa </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="coa" class="form-control akunpusat-lookup">
              </div>

            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-bindkeys" style="width: 2000px;">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="20%">stok</th>
                    <th width="5%">vulkanisirke</th>
                    <th width="10%">keterangan</th>
                    <th width="10%">qty</th>
                    <th width="20%">harga</th>
                    <th width="5%">persentase discount</th>
                    <th width="20%">Total</th>
                    <th width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6"></td>

                    <td class="font-weight-bold"> Total : </td>
                    <td id="sumary" class="text-right font-weight-bold"> </td>
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

  $(document).ready(function() {

    $("#addRow").click(function() {
      addRow()
    });

    $(document).on('click', '.rmv', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let penerimaanStokHeaderId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="detail_qty[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_qty[]"]`)[index])
      })
      $('#crudForm').find(`[name="detail_harga[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_harga[]"]`)[index])
      })

      $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
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
          url = `${apiUrl}penerimaanstokheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penerimaanstokheader`
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

  function kodepenerimaan(kodepenerimaan) {
    $('#crudForm').find('[name=statusformat]').val(kodepenerimaan).trigger('change');
    $('#crudForm').find('[name=statusformat_id]').val(kodepenerimaan);
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    initDatepicker()

    // getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })


  function createPenerimaanstokHeader() {
    resetRow()
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Penerimaan Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    addRow()
    sumary()
    setStatusFormatOptions(form)
  }

  function editPenerimaanstokHeader(penerimaanStokHeaderId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Penerimaan Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusFormatOptions(form)
      ])
      .then(() => {
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      })
  }

  function deletePenerimaanstokHeader(penerimaanStokHeaderId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Penerimaan Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusFormatOptions(form)
      ])
      .then(() => {
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}penerimaanstokheader/field_length`,
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

  const setStatusFormatOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusformat]').empty()
      relatedForm.find('[name=statusformat]').append(
        new Option('-- PILIH STATUS FORMAT --', '', false, true)
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
              "data": "PENERIMAAN STOK"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAktif => {
            let option = new Option(statusAktif.text, statusAktif.id)

            relatedForm.find('[name=statusformat]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }
  index = 0;

  function addRow() {

    let detailRow = $(`
    <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="" class="form-control detail_stok_${index}">
                    <input type="text" id="detailstokId_${index}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                  </td>                 
                  <td>
                    <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td>  
                  <td>
                    <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                  </td>
                  <td>
                    <input type="text"  name="detail_qty[]" id="detail_qty${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  
                  <td>
                    <input type="text"  name="detail_harga[]" id="detail_harga${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  
                  <td>
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  <td>
                    <input type="text"  name="totalItem[]" readonly id="totalItem${index}" style="text-align:right" class="form-control totalItem autonumeric number${index}">                    
                  </td>  
                  
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
              </tr>
    `)

    $('table #table_body').append(detailRow)
    var row = index;
    $(`.detail_stok_${row}`).lookup({
      title: 'stok Lookup',
      fileName: 'stok',
      onSelectRow: (stok, element) => {
        element.val(stok.namastok)
        parent = element.closest('td');
        parent.children('.detailstokId').val(stok.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
    initAutoNumeric($(`.number${index}`))

    setRowNumbers()
    index++;
  }

  function deleteRow(row) {
    row.remove()
    sumary()
    setRowNumbers()
  }

  function resetRow() {
    $('.trow').remove()
  }

  function setRowNumbers() {
    let elements = $('table #table_body tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function cal(id) {
    qty = $(`#detail_qty${id}`)[0];
    harga = $(`#detail_harga${id}`)[0];
    discount = $(`#detail_persentasediscount${id}`)[0];

    qty = AutoNumeric.getNumber(qty);
    harga = AutoNumeric.getNumber(harga);
    discount = AutoNumeric.getNumber(discount);

    total = qty * harga;
    nominaldiscount = total * (discount / 100);
    total -= nominaldiscount;
    new AutoNumeric($(`#totalItem${id}`)[0]).set(total)
    sumary();
  }

  function sumary() {
    let sumary = 0;
    $('.totalItem').each(function() {
      var totalItem = AutoNumeric.getNumber($(this)[0]);
      sumary += totalItem;
    })
    new AutoNumeric($('#sumary')[0]).set(sumary);
  }

  function showPenerimaanstokHeader(form, penerimaanStokHeaderId) {
    resetRow()
    $.ajax({
      url: `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        sum = 0;
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
           if (element.attr("name") == 'tglbukti') {
            var result = value.split('-');
            element.val(result[2] + '-' + result[1] + '-' + result[0]);
          } else {
            element.val(value)
          }
          if (index == "statusformat") {
            kodepenerimaan(value)
          }
        })
        $.each(response.detail, (id, detail) => {
          let detailRow = $(`
            <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                  </td>
                  <td>
                    <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td>  
                  <td>
                    <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                  </td>
                  <td>
                    <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                  </td>  
                  
                  <td>
                    <input type="text"  name="detail_harga[]" id="detail_harga${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  
                  
                  <td>
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  
                  <td>
                    <input type="text"  name="totalItem[]" readonly id="totalItem${id}" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                  </td>  
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
              </tr>
          `)
          detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
          detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
          detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
          detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
          detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
          detailRow.find(`[name="totalItem[]"]`).val(detail.total)
          detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          initAutoNumeric($(`.number${id}`))
          setRowNumbers()
          $(`#detail_stok_${id}`).lookup({
            title: 'stok Lookup',
            fileName: 'stok',
            onSelectRow: (stok, element) => {
              element.val(stok.namastok)
              parent = element.closest('td');
              parent.children('.detailstokId').val(stok.id)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            }
          })
          id++;
        })
        sumary()
      }
    })
  }
</script>
@endpush()
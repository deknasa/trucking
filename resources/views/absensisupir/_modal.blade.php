<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalTitle">Create Absensi Supir</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI KGT</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kasgantung_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>

            <hr>

            <table class="table table-bordered" id="detailList">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Trado</th>
                  <th>Supir</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th>Jam</th>
                  <th>Uang Jalan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>
                    <input type="hidden" name="trado_id[]">
                    <input type="text" name="trado" class="form-control trado-lookup">
                  </td>
                  <td>
                    <input type="hidden" name="supir_id[]">
                    <input type="text" name="supir" class="form-control supir-lookup">
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
                  </td>

                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6"><h5 class="text-right font-weight-bold">TOTAL:</h5></td>
                  <td><h5 id="total" class="text-right font-weight-bold"></h5></td>
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

    Inputmask("datetime", {
          inputFormat: "HH:MM",
          max: 24
        }).mask(".inputmask-time");

    $("#addRow").click(function() {
      addRow()
    })
    $(document).on('keyup', '.uangjalan', function(e) {
      calculateSum()
	  })

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('click', '#btnSubmit', function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="uangjalan[]"`).each((index,element) => {
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

      let inputs = data.filter((row) => row.name === 'uangjalan[]')

      inputs.forEach((input, index) => {
        if (input.value !== '') {
          input.value = AutoNumeric.getNumber($('#crudForm').find('[name="uangjalan[]"]')[index])
        }
      });

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}absensisupirheader/${id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}absensisupirheader/${id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
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

          indexRow = response.data.position - 1

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
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

  $('#crudModal').on('shown.bs.modal', () => {
    setFormBindKeys($('#crudForm'))
    activeGrid = null
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createAbsensiSupir() {
    $('#crudForm').trigger('reset')
    $('#crudForm').find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Create Absensi Supir')
    $('#crudModal').modal('show')
    $('#crudForm').data('action', 'add')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

  
  }

  function editAbsensiSupir(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Absensi Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showAbsensiSupir(form, id)

  }

  function deleteAbsensiSupir(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Absensi Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showAbsensiSupir(form,id)
  }

  function showAbsensiSupir(form, id){
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}absensisupirheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let tgl = response.data.tglbukti
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)

            element.val(value)
            let tglbukti = response.data.tglbukti
            $('#tglbukti').val($.datepicker.formatDate( "dd-mm-yy", new Date(tglbukti)));
        })
        let ft = dateFormat(tgl)
        form.find(`[name="tglbukti"]`).val(ft)

        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
          <tr>
            <td></td>
            <td>
              <input type="hidden" name="trado_id[]" value="${detail.trado_id}">
              <input type="text" name="trado" class="form-control trado-lookup" value="${detail.trado}">
            </td>
            <td>
              <input type="hidden" name="supir_id[]" value="${detail.supir_id}">
              <input type="text" name="supir" class="form-control supir-lookup" value="${detail.supir}">
            </td>
            <td>
              <input type="text" name="keterangan_detail[]" class="form-control" value="${detail.keterangan}">
            </td>
            <td>
              <input type="hidden" name="absen_id[]" value="${detail.absen_id}">
              <input type="text" name="absen" class="form-control absentrado-lookup" value="${detail.absen}">
            </td>
            <td>
              <input type="text" class="form-control inputmask-time" name="jam[]" value="${detail.jam}"></input>
            </td>
            <td>
              <input type="text" class="form-control uangjalan autonumeric" name="uangjalan[]" value="${detail.uangjalan}">
            </td>
            <td>
              <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
            </td>

          </tr>
          `)

          initAutoNumeric(detailRow.find(`[name="uangjalan[]"]`))
          $('#detailList tbody').append(detailRow)
          Inputmask("datetime", {
              inputFormat: "HH:MM",
              max: 24
            }).mask(".inputmask-time");
          
          $('.supir-lookup').lookup({
            title: 'Supir Lookup',
            fileName: 'supir',
            onSelectRow: (supir,element) => {
              $(`#crudForm [name="supir_id[]"]`).first().val(supir.id)
              element.val(supir.namasupir)
            }
          })

          $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            onSelectRow: (trado,element) => {
              $(`#crudForm [name="trado_id[]"]`).first().val(trado.id)
              element.val(trado.keterangan)
            }
          })
          
          $('.absentrado-lookup').lookup({
            title: 'Absen Trado Lookup',
            fileName: 'absentrado',
            onSelectRow: (absentrado,element) => {
              $(`#crudForm [name="absen_id[]"]`).first().val(absentrado.id)
              element.val(absentrado.keterangan)
            }
          })
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
          <input type="hidden" name="trado_id[]">
          <input type="text" name="trado" class="form-control trado-lookup">
        </td>
        <td>
          <input type="hidden" name="supir_id[]">
          <input type="text" name="supir" class="form-control supir-lookup">
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
      onSelectRow: (supir,element) => {
        $(`#crudForm [name="supir_id[]"]`).last().val(supir.id)
        element.val(supir.namasupir)
      }
    })

    $('.trado-lookup').last().lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      onSelectRow: (trado,element) => {
        $(`#crudForm [name="trado_id[]"]`).last().val(trado.id)
        element.val(trado.keterangan)
      }
    })
    
    $('.absentrado-lookup').last().lookup({
      title: 'Absen Trado Lookup',
      fileName: 'absentrado',
      onSelectRow: (absentrado,element) => {
        $(`#crudForm [name="absen_id[]"]`).last().val(absentrado.id)
        element.val(absentrado.keterangan)
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
      $(element).text(index+1)
    })
  }

  function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".uangjalan").each(function() {
        let number = this.value
        let hrg =  parseFloat(number.replaceAll(',',''));
        console.log(hrg)
        if (!isNaN(hrg) && hrg.length != 0) {
            sum += parseFloat(hrg);
        }
    });
    sum = new Intl.NumberFormat('en-US').format(sum);
    
    $("#total").html(`${sum}`);
    new AutoNumeric('#total',{
			decimalPlaces			: '2'
		})
  }
</script>
@endpush
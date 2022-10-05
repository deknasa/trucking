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
              <div class="col-12 col-sm-4 col-md-4" id="tglbukti">
                @php
                $tglbukti = date('d-m-Y');
                @endphp
                <input type="text" name="tglbukti" value="{{$tglbukti}}" id="tglbukti" class="form-control datepicker">
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
                AGEN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="agen_id">
                <input type="text" name="agen" class="form-control agen-lookup">
              </div>
            </div>

            <table class="table table-bordered table-bindkeys">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Nominal</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">

                <tr id="row">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  <td>
                    <div class="row form-group">
                      <div class="col-12 col-md-12">
                        <input type="text" name="nominal_detail[]" class="form-control autonumeric">
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="row form-group">
                      <div class="col-12 col-md-12">
                        <input type="text" name="keterangan_detail[]" class="form-control">
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
                </tr>

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3"></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm my-2" id="addrow">Tambah</button>
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

  $(document).ready(function() {

    // initLookupSupir()

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

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
          url = `${apiUrl}piutangheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}piutangheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}piutangheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}piutangheader`
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

  var baris = 1;

  let html = `<tr id="row">
        <td>
        <div class="baris">1</div>
      </td>
     
      <td>
        <input type="text" name="nominal_detail[]" style="text-align:right" class="form-control autonumeric">   
      </td>
      <td>
        <input type="text" name="keterangan_detail[]" class="form-control">
      </td>
      <td>
        <div class='btn btn-danger btn-sm rmv'>Hapus</div>
      </td>
    </tr>`;

  $("#addrow").click(function() {
    let rowCount = $('#row').length;
    let barisCount = $('.baris').length;
    if (rowCount > 0) {
      let clone = $('#row').clone();
      clone.find('input').val('');

      baris = parseInt(barisCount) + 1;
      clone.find('.baris').text(baris);
      $('table #table_body').append(clone);

    } else {
      baris = 1;
      $('#table_body').append(html);
    }
  });

  $('table').on('click', '.rmv', function() {
    $(this).closest('tr').remove();

    $('.baris').each(function(i, obj) {
      $(obj).text(i + 1);
    });
    baris = baris - 1;
  });


  function createPiutangHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
  
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editPiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}piutangheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        let tglbukti = response.data.tglbukti
        $('#tglbukti').val($.datepicker.formatDate( "dd-mm-yy", new Date(tglbukti)));

        $('#table_body').html('')
        $.each(response.detail, (index, value) => {
          $('#table_body').append(
            `<tr id="row">
                <td>
                  <div class="baris">${parseInt(index) + 1}</div>
                </td>
            
                <td>
                  <input type="text" name="nominal_detail[]" value="${value.nominal}" style="text-align:right" class="form-control autonumeric">   
                </td>
                <td>
                  <input type="text" name="keterangan_detail[]" value="${value.keterangan}" class="form-control">
                </td>
                <td>
                  <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                </td>
              </tr>`
          )
        })
      }
    })
  }

  function deletePiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}piutangheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        let tglbukti = response.data.tglbukti
        $('#tglbukti').val($.datepicker.formatDate( "dd-mm-yy", new Date(tglbukti)));
        $('#table_body').html('')
        $.each(response.detail, (index, value) => {
          $('#table_body').append(
            `<tr id="row">
                <td>
                  <div class="baris">${parseInt(index) + 1}</div>
                </td>
            
                <td>
                  <input type="text" name="nominal_detail[]" value="${value.nominal}" style="text-align:right" class="form-control autonumeric">   
                </td>
                <td>
                  <input type="text" name="keterangan_detail[]" value="${value.keterangan}" class="form-control">
                </td>
                <td>
                  <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                </td>
              </tr>`
          )
        })

      }
    })
  }
</script>
@endpush()
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
                <input type="text" name="tglbukti" class="form-control datepicker">
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
                PENERIMAAN TRUCKING <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="hidden" name="penerimaantrucking_id">
                  <input type="text" name="penerimaantrucking" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupPenerimaanTruckingToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupPenerimaanTrucking" style="z-index: 1;">
                  <div class="col-12">
                    <div id="lookupPenerimaanTrucking" class="shadow-lg">
                      @include('partials.lookups.penerimaantrucking')
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                BANK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="hidden" name="bank_id" class="form-control">
                  <input type="text" name="bank" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupBankToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupBank" style="z-index: 1;">
                  <div class="col-12">
                    <div id="lookupBank" class="shadow-lg">
                      @include('partials.lookups.bank')
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                COA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="text" name="akunpusat" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupAkunPusatToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupAkunPusat" style="z-index: 1;">
                  <div class="col-12">
                    <div id="lookupAkunPusat" class="shadow-lg">
                      @include('partials.lookups.akunpusat')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                NO BUKTI PENERIMAAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="text" name="penerimaan_nobukti" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupPenerimaanHeaderToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupPenerimaanHeader" style="z-index: 1;">
                  <div class="col-12">
                    <div id="lookupPenerimaanHeader" class="shadow-lg">
                      @include('partials.lookups.penerimaanheader')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <table class="table table-bordered table-bindkeys">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Supir</th>
                  <th>No Bukti Pengeluaran Trucking</th>
                  <th>Nominal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
                <tr id="row">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  <td>
                  <div class="row form-group" >
                    <div class="col-12 col-md-12" id="supir_id">
                      <div class="input-group">
                        <input type="hidden" name="supir_id">
                        <input type="text" name="supir"  class="form-control">
                        <div class="input-group-append">
                          <button id="lookupSupirToggler" class="btn btn-secondary" type="button">...</button>
                        </div>
                      </div>
                      <div class="row position-absolute" id="lookupSupir" style="z-index: 1;">
                        <div class="col-12">
                          <div id="lookupSupir" class="shadow-lg">
                            @include('partials.lookups.supir')
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </td>
                  <td>
                  <div class="row form-group" >
                    <div class="col-12 col-md-12">
                      <div class="input-group">
                        <input type="text" name="pengeluarantruckingheader_nobukti"  class="form-control">
                        <div class="input-group-append">
                          <button id="lookupPengeluaranTruckingHeaderToggler" class="btn btn-secondary" type="button">...</button>
                        </div>
                      </div>
                      <div class="row position-absolute" id="lookupPengeluaranTruckingHeader" style="z-index: 1;">
                        <div class="col-12">
                          <div id="lookupPengeluaranTruckingHeader" class="shadow-lg" >
                            @include('partials.lookups.pengeluarantruckingheader')
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </td>
                  <td>
                      <input type="text" name="nominal"  style="text-align:right" class="form-control text-right autonumeric" > 
                  </td>
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
                </tr>

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4"></td>
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
          url = `${apiUrl}penerimaantruckingheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penerimaantruckingheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penerimaantruckingheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penerimaantruckingheader`
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


  $("#addrow").click(function() {
    let rowCount = $('#row').length;
      
    if (rowCount > 0) {
      let clone = $('#row').clone();
      clone.find('input').val('');

      baris = parseInt(baris) + 1;
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


  function createPenerimaanTruckingHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Penerimaan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editPenerimaanTruckingHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Penerimaan Trucking Header')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}penerimaantruckingheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        <?php $details = "<script> response.detail </script>"; ?>  
        $.each(response.detail, function() {
          $.each(this, function(name, value) {
            form.find(`[name="${name}"]`).val(value)
          });
        });
        console.log(response.data)
        console.log(response.detail)
      }
    })
  }

  function deletePenerimaanTruckingHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Penerimaan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}penerimaantruckingheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        $.each(response.detail, function() {
          $.each(this, function(name, value) {
            form.find(`[name="${name}"]`).val(value)
          });
        });
      }
    })
  }

</script>
@endpush()
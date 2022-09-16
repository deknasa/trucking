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
                <div class="row position-absolute" id="lookupBank" style="z-index: 3;">
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
                AGEN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="hidden" name="agen_id" class="form-control">
                  <input type="text" name="agen" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupAgenToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupAgen" style="z-index: 3;">
                  <div class="col-12">
                    <div id="lookupAgen" class="shadow-lg">
                      @include('partials.lookups.agen')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                CABANG <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="hidden" name="cabang_id" class="form-control">
                  <input type="text" name="cabang" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupCabangToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupCabang" style="z-index: 3;">
                  <div class="col-12">
                    <div id="lookupCabang" class="shadow-lg">
                      @include('partials.lookups.cabang')
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row form-group">
                      <div class="col-md-2">
                        <label>
                          PELANGGAN <span class="text-danger">*</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <input type="text" name="pelanggan" class="form-control">
                      </div>
                      <div class="col-md-1 offset-md-1">
                        <label>
                          AGEN <span class="text-danger">*</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <input type="text" name="agen_detail" class="form-control">
                      </div>
                    </div>
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
          url = `${apiUrl}pelunasanpiutangheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pelunasanpiutangheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pelunasanpiutangheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pelunasanpiutangheader`
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


  function createPelunasanPiutangHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editPelunasanPiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/${Id}`,
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
      }
    })
  }

  function deletePelunasanPiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/${Id}`,
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
      }
    })
  }

</script>
@endpush()
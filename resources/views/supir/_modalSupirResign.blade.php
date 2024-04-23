<div class="modal fade modal-fullscreen" id="resignModal" tabindex="-1" aria-labelledby="resignModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="resignForm">

      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="resignModalTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id">
          <div id="unapproveResign">
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Supir<span class="text-danger"></span></label>
            <div class="col-sm-8">
              <div class="input-group">
                <input type="text" class="form-control " readonly name="namasupir">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tgl Resign <span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <div class="input-group">
                <input type="text" class="form-control datepicker" name="tglberhentisupir">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Keterangan Resign<span class="text-danger">*</span></label>
            <div class="col-sm-8">
              <div class="input-group">
                <input type="text" class="form-control " name="keteranganberhentisupir">
              </div>
            </div>
          </div>





        </div>
        <div class="modal-footer justify-content-start">
          <button id="resignSubmit" class="btn btn-primary">
            <i class="fa fa-save"></i>
            Save
          </button>
          <button class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times"></i>
            Cancel
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  let modalAbsen = $('#resignModal').find('.modal-body').html()

  $(document).ready(function() {
    $('#resignSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#resignForm')
      let supirId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#resignForm').serializeArray()

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
        name: 'action',
        value: action
      })
      data.push({
        name: 'page',
        value: page
      })
      data.push({
        name: 'limit',
        value: limit
      })

      // switch (action) {
      //   case 'resign':
      method = 'POST'
      url = `${apiUrl}supir/${supirId}/approvalresign`
      //     break;

      //   default:
      //     method = 'POST'
      //     url = `${apiUrl}supir/${id}/approvalresign`
      //     break;
      // }

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
          $('#resignForm').trigger('reset')
          $('#resignModal').modal('hide')

          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');
          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
          selectedRows = []
          $('#gs_').prop('checked', false)
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            console.log(error.responseJSON)
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  $('#resignModal').on('shown.bs.modal', () => {
    activeGrid = null
    initDatepicker()
  })

  $('#resignModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#resignModal').find('.modal-body').html(modalAbsen)
  })

  function supirResign(id) {

    $("#approveResign").hide();
    $("#unapproveResign").hide();
    getSupir($('#resignForm'), id)
      .then((statusApproval) => {
        $('#resignModal').modal('show')
        $('#resignModalTitle').text(`${statusApproval} SUPIR RESIGN`)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

    // $('#resignModal').find('[name=tanggalberhenti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    initDatepicker()
  }


  function getSupir(form, supirId) {
    // console.log(supirId);
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}supir/${supirId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let form = $('#resignForm')

          let statusApproval
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
          })
          if (response.data.tglberhentisupir !== "1900-01-01" && response.data.tglberhentisupir != null) {
            form.data('action', 'unapprove')
            form.find('[name=tglberhentisupir]').prop('readonly', true)
            form.find('[name=keteranganberhentisupir]').prop('readonly', true)
            form.find(`[name="tglberhentisupir"]`).parent('.input-group').find('.input-group-append').remove()
            $("#unapproveResign").show();
            statusApproval = 'unapproval'
          } else {
            form.data('action', 'approve')
            form.find('[name=tglberhentisupir]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
            statusApproval = 'approval'
          }

          // $("#unapproveResign").show();
          // let element = form.find(`[name="namasupir"]`)
          // element.val(response.data.namasupir)
          // $("#unapproveResign").html("unapproval Supir Resign " )

          resolve(statusApproval)

        }
      })
    })
  }
</script>
@endpush
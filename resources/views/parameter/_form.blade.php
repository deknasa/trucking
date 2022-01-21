@php

$limit = $_GET['limit'] ?? 10;
$sortname = $_GET['sortname'] ?? 'id';
$sortorder = $_GET['sortorder'] ?? 'id';
$page = $_GET['page'] ?? '';
$indexRow = $_GET['indexRow'] ?? '';

@endphp

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">Form {{ $title }}</div>
        <form action="" method="post">
          <div class="card-body">
            @csrf
            <input type="hidden" name="limit" value="{{ $limit }}">
            <input type="hidden" name="sortname" value="{{ $sortname }}">
            <input type="hidden" name="sortorder" value="{{ $sortorder }}">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $parameter['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  GROUP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="grp" class="form-control" value="{{ $parameter['grp'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  SUBGROUP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="subgrp" class="form-control" value="{{ $parameter['subgrp'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  NAMA PARAMETER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="text" class="form-control" value="{{ $parameter['text'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  MEMO <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="memo" class="form-control" value="{{ $parameter['memo'] ?? '' }}">
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" id="btnSimpan" class="btn btn-primary">
              <i class="fa fa-save"></i>
              @if(isset($action) && $action == 'delete')
              Delete
              @else
              Simpan
              @endif
            </button>
            <a href="{{ route('parameter.index') }}" class="btn btn-danger">
              <i class="fa fa-window-close"></i>
              BATAL
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let indexUrl = "{{ route('parameter.index') }}"
  let fieldLengthUrl = "{{ route('parameter.field_length') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('parameter.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action == 'edit') : ?>
    actionUrl = "{{ route('parameter.update', $parameter['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('parameter.destroy', $parameter['id']) }}"
    method = "DELETE"
  <?php endif; ?>

  $(document).ready(function() {
    $('form').submit(function(e) {
      e.preventDefault()
    })

    /* Handle on click btnSimpan */
    $('#btnSimpan').click(function() {
      $(this).attr('disabled', '')

      $.ajax({
        url: actionUrl,
        method: method,
        dataType: 'JSON',
        data: $('form').serializeArray(),
        success: response => {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          if (response.status) {
            if (action != 'delete') {
              window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $sortname }}&sortorder={{ $sortorder }}&limit={{ $limit }}`
            } else {
              window.location.href = `${indexUrl}?page={{ $page }}&sortname={{ $sortname }}&sortorder={{ $sortorder }}&limit={{ $limit }}&indexRow={{ $indexRow }}`
            }
          }

          if (response.errors) {
            setErrorMessages(response.errors)
          }
        },
        error: error => {
          alert(`${error.statusText} | ${error.responseText}`)
        },
      }).always(() => {
        $(this).removeAttr('disabled')
      })
    })

    /* Get field maxlength */
    $.ajax({
      url: fieldLengthUrl,
      method: 'GET',
      dataType: 'JSON',
      success: response => {
        $.each(response, (index, value) => {
          if (value !== null && value !== 0 && value !== undefined) {
            $(`[name=${index}]`).attr('maxlength', value)
          }
        })
      },
      error: error => {
        alert(error)
      }
    })
  })
</script>
@endpush()
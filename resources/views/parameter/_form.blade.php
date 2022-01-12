<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">Form {{ $title }}</div>
        <form action="" method="post">
          <div class="card-body">
            @csrf
            <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
            
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
                <label>GROUP</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="grp" class="form-control" value="{{ $parameter['grp'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>SUBGROUP</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="subgrp" class="form-control" value="{{ $parameter['subgrp'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NAMA PARAMETER</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="text" class="form-control" value="{{ $parameter['text'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>MEMO</label>
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
      $.ajax({
        url: actionUrl,
        method: method,
        dataType: 'JSON',
        data: $('form').serializeArray(),
        success: response => {
          if (response.status) {
            alert(response.message)

            if (action != 'delete') {
              window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
            } else {
              window.location.href = `${indexUrl}?page={{ $_GET['page'] ?? '' }}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] ?? ''}}&indexRow={{ $_GET['indexRow'] ?? '' }}`
            }
          }

          $.each(response.errors, (index, error) => {
            console.log(error);
          })
        },
        error: error => {
          alert(error)
        }
      })
    })
  })
</script>
@endpush()
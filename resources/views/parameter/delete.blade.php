@extends('layouts.master')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Delete {{ $title }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Form -->
@include('parameter._form', [
  'action' => 'delete'
])

{{--
@push('scripts')
<script>
  let indexUrl = "{{ route('parameter.index') }}"
  let deleteUrl = "{{ route('parameter.update', $parameter['id']) }}"
  let csrfToken = "{{ csrf_token() }}"

  $(document).ready(function() {
    $('form').submit(function(e) {
      e.preventDefault()
    })
    
    /* Handle on click btnSimpan */
    $('#btnSimpan').click(function() {
      $.ajax({
        url: deleteUrl,
        method: 'DELETE',
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            'id': $('form [name=id]').val()
        },
        success: response => {
          if (response.status) {
            alert(response.message)
            window.location.href = indexUrl
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
--}}
@endsection
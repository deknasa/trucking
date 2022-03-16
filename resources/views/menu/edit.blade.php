@extends('layouts.master')

@section('content')
<!-- Form -->
@include('menu._form', [
  'action' => 'edit'
])

{{--
@push('scripts')
<script>
  let indexUrl = "{{ route('menu.index') }}"
  let updateUrl = "{{ route('menu.update', $menu['id']) }}"
  let csrfToken = "{{ csrf_token() }}"

  $(document).ready(function() {
    $('form').submit(function(e) {
      e.preventDefault()
    })
    
    /* Handle on click btnSimpan */
    $('#btnSimpan').click(function() {
      $.ajax({
        url: updateUrl,
        method: 'PATCH',
        dataType: 'JSON',
        data: $('form').serializeArray(),
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
@extends('layouts.master')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <form action="#" method="post">
          <div class="card-body">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="dd">
                  {!! \App\Helpers\Menu::printRecursiveMenuForResequence(session('menus')) !!}
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" id="btnSimpan" class="btn btn-primary">
              <i class="fa fa-save"></i> Simpan
            </button>
            <a href="{{ route('menu.index') }}" class="btn btn-danger">
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
  $(document).ready(() => {
    let beforeDragParent

    $('.dd').nestable({
      listNodeName: 'ul',
      onDragStart: (container, element) => {
        beforeDragParent = element.parent()
      },
      beforeDragStop: (container, element, place) => {
        console.log(place);
        // if (place.data('isparent')) return false
      },
      callback: (container, element) => {

      }
    });

    $('form').submit((e) => {
      e.preventDefault()

      $('#btnSimpan').attr('disabled', '')
      $('#loader').removeClass('d-none')

      let url = `{{ route('menu.resequence.store') }}`
      let csrfToken = `{{ csrf_token() }}`

      $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        data: {
          menu: $('.dd').nestable('serialize')
        },
        success: response => {
          location.reload()
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        }
      }).always(() => {
        $('#btnSimpan').removeAttr('disabled')
        $('#loader').addClass('d-none')
      })
    })
  })
</script>
@endpush

@endsection
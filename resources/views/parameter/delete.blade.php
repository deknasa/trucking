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

<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">Form {{ $title }}</div>
        <form action="" method="post">
          <div class="card-body">
            @csrf
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $parameter['id'] }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>GROUP</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="grp" class="form-control" value="{{ $parameter['grp'] }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>SUBGROUP</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="subgrp" class="form-control" value="{{ $parameter['subgrp'] }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NAMA PARAMETER</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="text" class="form-control" value="{{ $parameter['text'] }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>MEMO</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="memo" class="form-control" value="{{ $parameter['memo'] }}">
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" id="btnSimpan" class="btn btn-primary">
              <i class="fa fa-save"></i>
              HAPUS
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
@endsection
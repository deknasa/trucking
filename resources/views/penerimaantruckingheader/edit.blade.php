@extends('layouts.master')

@section('content')
<!-- Form -->
@include('penerimaantruckingheader._form', [
  'action' => 'edit'
])
@endsection
@extends('layouts.master')

@section('content')
<!-- Form -->
@include('penerimaantruckingheader._form', [
  'action' => 'delete'
])
@endsection
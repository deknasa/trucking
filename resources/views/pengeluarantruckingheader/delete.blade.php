@extends('layouts.master')

@section('content')
<!-- Form -->
@include('pengeluarantruckingheader._form', [
  'action' => 'delete'
])
@endsection
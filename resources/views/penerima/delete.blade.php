@extends('layouts.master')

@section('content')
<!-- Form -->
@include('penerima._form', [
  'action' => 'delete'
])
@endsection
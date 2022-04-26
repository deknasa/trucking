@extends('layouts.master')

@section('content')
<!-- Form -->
@include('penerima._form', [
  'action' => 'edit'
])
@endsection
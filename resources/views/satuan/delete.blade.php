@extends('layouts.master')

@section('content')
<!-- Form -->
@include('satuan._form', [
  'action' => 'delete'
])
@endsection
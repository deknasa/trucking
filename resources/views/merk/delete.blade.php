@extends('layouts.master')

@section('content')
<!-- Form -->
@include('merk._form', [
  'action' => 'delete'
])
@endsection
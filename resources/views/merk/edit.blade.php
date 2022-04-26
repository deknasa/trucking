@extends('layouts.master')

@section('content')
<!-- Form -->
@include('merk._form', [
  'action' => 'edit'
])
@endsection
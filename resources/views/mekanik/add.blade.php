@extends('layouts.master')

@section('content')
<!-- Form -->
@include('mekanik._form', [
  'action' => 'add'
])
@endsection
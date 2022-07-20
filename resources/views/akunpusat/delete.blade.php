@extends('layouts.master')

@section('content')
<!-- Form -->
@include('akunpusat._form', [
  'action' => 'delete'
])
@endsection
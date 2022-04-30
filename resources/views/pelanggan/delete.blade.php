@extends('layouts.master')

@section('content')
<!-- Form -->
@include('pelanggan._form', [
  'action' => 'delete'
])
@endsection
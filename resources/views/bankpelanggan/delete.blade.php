@extends('layouts.master')

@section('content')
<!-- Form -->
@include('bankpelanggan._form', [
  'action' => 'delete'
])
@endsection
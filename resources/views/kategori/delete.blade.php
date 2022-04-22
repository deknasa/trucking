@extends('layouts.master')

@section('content')
<!-- Form -->
@include('kategori._form', [
  'action' => 'delete'
])
@endsection
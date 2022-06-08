@extends('layouts.master')

@section('content')
<!-- Form -->
@include('prosesabsensisupir._form', [
  'action' => 'add'
])
@endsection
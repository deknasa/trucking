@extends('layouts.master')

@section('content')
<!-- Form -->
@include('hutang._form', [
  'action' => 'add'
])
@endsection
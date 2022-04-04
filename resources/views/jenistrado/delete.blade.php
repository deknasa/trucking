@extends('layouts.master')

@section('content')
<!-- Form -->
@include('jenistrado._form', [
  'action' => 'delete'
])
@endsection
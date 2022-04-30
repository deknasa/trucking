@extends('layouts.master')

@section('content')
<!-- Form -->
@include('status_container._form', [
  'action' => 'delete'
])
@endsection
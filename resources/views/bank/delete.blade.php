@extends('layouts.master')

@section('content')
<!-- Form -->
@include('bank._form', [
  'action' => 'delete'
])
@endsection
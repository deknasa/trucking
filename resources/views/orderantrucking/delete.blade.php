@extends('layouts.master')

@section('content')
<!-- Form -->
@include('orderantrucking._form', [
  'action' => 'delete'
])
@endsection
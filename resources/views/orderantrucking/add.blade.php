@extends('layouts.master')

@section('content')
<!-- Form -->
@include('orderantrucking._form', [
  'action' => 'add'
])
@endsection
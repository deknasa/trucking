@extends('layouts.master')

@section('content')
<!-- Form -->
@include('orderantrucking._form', [
  'action' => 'edit'
])
@endsection
@extends('layouts.master')

@section('content')
<!-- Form -->
@include('bank._form', [
  'action' => 'edit'
])
@endsection
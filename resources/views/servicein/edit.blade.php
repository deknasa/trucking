@extends('layouts.master')

@section('content')
<!-- Form -->
@include('servicein._form', [
  'action' => 'edit'
])
@endsection
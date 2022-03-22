@extends('layouts.master')

@section('content')
<!-- Form -->
@include('parameter._form', [
  'action' => 'delete'
])
@endsection
@extends('layouts.master')

@section('content')
<!-- Form -->
@include('agen._form', [
  'action' => 'delete'
])
@endsection
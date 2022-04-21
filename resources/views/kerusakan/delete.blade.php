@extends('layouts.master')

@section('content')
<!-- Form -->
@include('kerusakan._form', [
  'action' => 'delete'
])
@endsection
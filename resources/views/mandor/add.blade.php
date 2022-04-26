@extends('layouts.master')

@section('content')
<!-- Form -->
@include('mandor._form', [
  'action' => 'add'
])
@endsection
@extends('layouts.master')

@section('content')
<!-- Form -->
@include('user._form', [
  'action' => 'add'
])
@endsection
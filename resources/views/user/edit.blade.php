@extends('layouts.master')

@section('content')
<!-- Form -->
@include('user._form', [
  'action' => 'edit'
])
@endsection
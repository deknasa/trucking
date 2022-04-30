@extends('layouts.master')

@section('content')
<!-- Form -->
@include('zona._form', [
  'action' => 'edit'
])
@endsection
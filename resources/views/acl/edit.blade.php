@extends('layouts.master')

@section('content')
<!-- Form -->
@include('acl._form', [
  'action' => 'edit'
])
@endsection
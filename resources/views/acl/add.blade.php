@extends('layouts.master')

@section('content')
<!-- Form -->
@include('acl._form', [
  'action' => 'add'
])
@endsection
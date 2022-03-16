@extends('layouts.master')

@section('content')
<!-- Form -->
@include('role._form', [
  'action' => 'add'
])
@endsection
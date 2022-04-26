@extends('layouts.master')

@section('content')
<!-- Form -->
@include('kota._form', [
  'action' => 'add'
])
@endsection
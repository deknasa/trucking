@extends('layouts.master')

@section('content')
<!-- Form -->
@include('agen._form', [
  'action' => 'edit'
])
@endsection
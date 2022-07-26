@extends('layouts.master')

@section('content')
<!-- Form -->
@include('serviceout._form', [
  'action' => 'add'
])
@endsection
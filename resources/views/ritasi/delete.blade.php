@extends('layouts.master')

@section('content')
<!-- Form -->
@include('ritasi._form', [
  'action' => 'delete'
])
@endsection
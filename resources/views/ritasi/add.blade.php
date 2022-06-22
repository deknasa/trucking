@extends('layouts.master')

@section('content')
<!-- Form -->
@include('ritasi._form', [
  'action' => 'add'
])
@endsection
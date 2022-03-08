@extends('layouts.master')

@section('content')
<!-- Form -->
@include('menu._form', [
  'action' => 'add'
])
@endsection
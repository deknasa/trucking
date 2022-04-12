@extends('layouts.master')

@section('content')
<!-- Form -->
@include('gudang._form', [
  'action' => 'add'
])
@endsection
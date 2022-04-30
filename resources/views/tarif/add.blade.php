@extends('layouts.master')

@section('content')
<!-- Form -->
@include('tarif._form', [
  'action' => 'add'
])
@endsection
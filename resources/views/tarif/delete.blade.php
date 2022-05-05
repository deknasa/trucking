@extends('layouts.master')

@section('content')
<!-- Form -->
@include('tarif._form', [
  'action' => 'delete'
])
@endsection
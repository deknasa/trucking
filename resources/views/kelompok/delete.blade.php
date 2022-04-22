@extends('layouts.master')

@section('content')
<!-- Form -->
@include('kelompok._form', [
  'action' => 'delete'
])
@endsection
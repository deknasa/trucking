@extends('layouts.master')

@section('content')
<!-- Form -->
@include('sub_kelompok._form', [
  'action' => 'delete'
])
@endsection
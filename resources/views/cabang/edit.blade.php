@extends('layouts.master')

@section('content')
<!-- Form -->
@include('cabang._form', [
  'action' => 'edit'
])
@endsection
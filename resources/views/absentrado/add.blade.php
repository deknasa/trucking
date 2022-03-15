@extends('layouts.master')

@section('content')
<!-- Form -->
@include('absentrado._form', [
  'action' => 'add'
])
@endsection
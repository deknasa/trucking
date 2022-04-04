@extends('layouts.master')

@section('content')
<!-- Form -->
@include('jenisorder._form', [
  'action' => 'edit'
])
@endsection
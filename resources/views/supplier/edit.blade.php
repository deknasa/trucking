@extends('layouts.master')

@section('content')
<!-- Form -->
@include('supplier._form', [
  'action' => 'edit'
])
@endsection
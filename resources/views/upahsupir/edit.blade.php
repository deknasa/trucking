@extends('layouts.master')

@section('content')
<!-- Form -->
@include('upahsupir._form', [
  'action' => 'edit'
])
@endsection
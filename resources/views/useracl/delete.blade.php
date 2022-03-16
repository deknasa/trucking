@extends('layouts.master')

@section('content')
<!-- Form -->
@include('useracl._form', [
  'action' => 'delete'
])
@endsection
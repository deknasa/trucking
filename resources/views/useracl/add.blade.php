@extends('layouts.master')

@section('content')
<!-- Form -->
@include('useracl._form', [
  'action' => 'add'
])
@endsection
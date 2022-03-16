@extends('layouts.master')

@section('content')
<!-- Form -->
@include('userrole._form', [
  'action' => 'delete'
])
@endsection
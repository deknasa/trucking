@extends('layouts.master')

@section('content')
<!-- Form -->
@include('userrole._form', [
  'action' => 'add'
])
@endsection
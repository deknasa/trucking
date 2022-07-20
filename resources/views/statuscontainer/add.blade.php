@extends('layouts.master')

@section('content')
<!-- Form -->
@include('statuscontainer._form', [
  'action' => 'add'
])
@endsection
@extends('layouts.master')

@section('content')
<!-- Form -->
@include('suratpengantar._form', [
  'action' => 'add'
])
@endsection
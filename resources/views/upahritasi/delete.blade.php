@extends('layouts.master')

@section('content')
<!-- Form -->
@include('upahritasi._form', [
  'action' => 'delete'
])
@endsection
@extends('layouts.master')

@section('content')
<!-- Form -->
@include('upahritasi._form', [
  'action' => 'edit'
])
@endsection
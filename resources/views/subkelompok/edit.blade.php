@extends('layouts.master')

@section('content')
<!-- Form -->
@include('subkelompok._form', [
  'action' => 'edit'
])
@endsection
@extends('layouts.master')

@section('content')
<!-- Form -->
@include('kasgantung._form', [
  'action' => 'delete'
])
@endsection
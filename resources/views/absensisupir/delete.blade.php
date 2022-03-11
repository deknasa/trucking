@extends('layouts.master')

@section('content')
<!-- Form -->
@include('absensisupir._form', [
  'action' => 'delete'
])
@endsection
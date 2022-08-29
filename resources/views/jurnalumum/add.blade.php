@extends('layouts.master')

@section('content')
<!-- Form -->
@include('jurnalumum._form', [
  'action' => 'add'
])
@endsection
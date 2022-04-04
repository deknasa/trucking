@extends('layouts.master')

@section('content')
<!-- Form -->
@include('jenisemkl._form', [
  'action' => 'delete'
])
@endsection
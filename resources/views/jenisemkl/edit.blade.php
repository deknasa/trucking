@extends('layouts.master')

@section('content')
<!-- Form -->
@include('jenisemkl._form', [
  'action' => 'edit'
])
@endsection
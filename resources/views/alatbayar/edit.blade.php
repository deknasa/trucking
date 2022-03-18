@extends('layouts.master')

@section('content')
<!-- Form -->
@include('alatbayar._form', [
  'action' => 'edit'
])
@endsection
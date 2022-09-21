@extends('layouts.master')

@section('content')
<!-- Form -->
@include('hutangbayarheader._form', [
  'action' => 'add'
])
@endsection
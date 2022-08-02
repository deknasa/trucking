@extends('layouts.master')

@section('content')
<!-- Form -->
@include('penerimaan._form', [
  'action' => 'add'
])
@endsection
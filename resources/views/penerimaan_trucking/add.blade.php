@extends('layouts.master')

@section('content')
<!-- Form -->
@include('penerimaan_trucking._form', [
  'action' => 'add'
])
@endsection
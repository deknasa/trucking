@extends('layouts.master')

@section('content')
<!-- Form -->
@include('penerimaantrucking._form', [
  'action' => 'edit'
])
@endsection
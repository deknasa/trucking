@extends('layouts.master')

@section('content')
<!-- Form -->
@include('pengeluaran._form', [
  'action' => 'delete'
])
@endsection
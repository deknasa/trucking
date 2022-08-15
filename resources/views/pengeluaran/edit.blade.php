@extends('layouts.master')

@section('content')
<!-- Form -->
@include('pengeluaran._form', [
  'action' => 'edit'
])
@endsection
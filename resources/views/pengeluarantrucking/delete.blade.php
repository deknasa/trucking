@extends('layouts.master')

@section('content')
<!-- Form -->
@include('pengeluaran_trucking._form', [
  'action' => 'delete'
])
@endsection
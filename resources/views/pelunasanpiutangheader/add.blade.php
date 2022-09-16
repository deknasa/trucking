@extends('layouts.master')

@section('content')
<!-- Form -->
@include('pelunasanpiutangheader._form', [
  'action' => 'add'
])
@endsection
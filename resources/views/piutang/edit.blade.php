@extends('layouts.master')

@section('content')
<!-- Form -->
@include('piutang._form', [
    'action' => 'edit'
])
@endsection
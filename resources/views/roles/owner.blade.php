@extends('layouts.app')

@section('title','Owner Dashboard')

@section('content')
  <h1>Owner Dashboard</h1>
  <p>Halo, {{ auth()->user()->name ?? 'Owner' }}.</p>
@endsection

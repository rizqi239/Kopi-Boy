@extends('layouts.app')

@section('title','Kasir Dashboard')

@section('content')
  <h1>Kasir Dashboard</h1>
  <p>Halo, {{ auth()->user()->name ?? 'Kasir' }}.</p>
@endsection

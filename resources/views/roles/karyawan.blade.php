@extends('layouts.app')

@section('title','Karyawan Dashboard')

@section('content')
  <h1>Karyawan Dashboard</h1>
  <p>Halo, {{ auth()->user()->name ?? 'Karyawan' }}.</p>
@endsection

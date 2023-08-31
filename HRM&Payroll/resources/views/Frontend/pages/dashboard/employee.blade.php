@extends('Frontend.layout.sidenav-layout')
@section('content')
    @include('Frontend.component.employee.employee-create')
    @include('Frontend.component.employee.employee-list')
    @include('Frontend.component.employee.employee-delete')
@endsection
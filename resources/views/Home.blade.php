@extends('Temp')
@section('cont')
@if (auth()->user()->role==="admin")
    @include('Home.home_ad')
@else
    @if (auth()->user()->role==="manager")
    @include('Home.Home_ma')
    @else
    @include('Home.home_em')
    @endif
@endif
@endsection
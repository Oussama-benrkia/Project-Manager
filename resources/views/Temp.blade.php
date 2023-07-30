@extends('Master.Layout')

@section('tit')
    TODO - Home
@endsection
@section('content')

<main>
  @include('Dasbord._SideBare')
  @include('Dasbord._NavBar')
  @yield('cont')
</main>


@endsection
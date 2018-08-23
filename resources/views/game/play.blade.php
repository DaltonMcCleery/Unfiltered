@extends('wrapper')
@section('content')

    <play-game :current_ninja = "'{{ Auth::user()->username }}'" :game = "'{{ $game }}'"></play-game>

@endsection
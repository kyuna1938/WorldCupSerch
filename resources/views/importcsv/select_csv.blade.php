@extends('common.layout')
@section('addTitle')
<title>Search World Cup Database</title>
@stop
@include('common.header')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha512-VGxuOMLdTe8EmBucQ5vYNoYDTGijqUsStF6eM7P3vA/cM1pqOwSBv/uxw94PhhJJn795NlOeKBkECQZ1gIzp6A==" crossorigin="anonymous"></script>
<style>
    #search_form_area {
        padding: 0.5em 1em;
        margin: 2em 0;
        background: #f0f7ff;
        border: dashed 2px #5b8bd0;
    }
</style>
@if(Session::has('message'))
    {{ session('message') }}
@endif

<div class="container">
    <div class="title">select format</div>
    <li>
        <a href="{{ url('/importcsv/tournament') }}"> wc_tournament </a>
    </li>
    <li>
        <a href="{{ url('/importcsv/round') }}"> wc_round </a>
    </li>
    <li>
        <a href="{{ url('/importcsv/group') }}"> wc_group </a>
    </li>
    <li>
        <a href="{{ url('/importcsv/match') }}"> wc_match </a>
    </li>
    <li>
        <a href="{{ url('/importcsv/result') }}"> wc_result </a>
    </li>
    <li>
        <a href="{{ url('/importcsv/team') }}"> wc_team </a>
    </li>
</div>
@stop
@include('common.footer')

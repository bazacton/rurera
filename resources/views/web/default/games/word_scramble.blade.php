@extends('web.default.panel.layouts.panel_layout_full')
@php use App\Models\Webinar; @endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/games/word-scramble/css/style.css">
@endpush
@section('content')
<div class="container game-container" data-max_time="{{auth()->user()->game_time}}">

        <h2>Word Scramble  - {{auth()->user()->game_time}}</h2>
        <div class="content">
            <p class="word"></p>
            <div class="details">
                <p class="time">Time Left: <span><b>30</b>s</span></p>
            </div>
            <input type="text" spellcheck="false" placeholder="Enter a valid word">
            <div class="buttons">
                <button class="refresh-word">Refresh Word</button>
                <button class="check-word">Check Word</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
<script src="/assets/games/word-scramble/js/words.js"></script>
<script src="/assets/games/word-scramble/js/script.js"></script>
<script src="/assets/default/js/parts/main.min.js"></script>
@endpush

@extends('web.default.panel.layouts.panel_layout_full')
@php use App\Models\Webinar; @endphp

@push('styles_top')

@endpush

@section('content')

<section class="">
    <div class="activities-container mt-25 p-20 p-lg-35">
        <div class="row">
            <div class="col-4 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/assets/default/svgs/calculator-game.svg" width="90" height="90" alt="">
                    <strong class="font-24 mt-5">64</strong>
                    <span class="font-16 text-gray font-weight-500">Total Games</span>
                </div>
            </div>

            <div class="col-4 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/assets/default/svgs/report-game.svg" width="90" height="90" alt="">
                    <strong class="font-24 mt-5">64</strong>
                    <span class="font-16 text-gray font-weight-500">Daily Average Time</span>
                </div>
            </div>

            <div class="col-4 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/assets/default/svgs/time-game.svg" width="90" height="90" alt="">
                    <strong class="font-24 mt-5">0</strong>
                    <span class="font-16 text-gray font-weight-500">Today Remaining Time</span>
                </div>
            </div>
        </div>
    </div>


<div class="dashboard-games-holder">
    <div class="row mt-35">
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <a href="/games/word-scramble">
                <span class="icon-box"><img src="/assets/default/img/games/word-scramble.jpg" style="height: 190px;width: 100%;"></span>
                <h5>Word Scramble</h5>
                </a>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/my-swashbuckle-adventure.jpg"></span>
                <h5><a href="#">My Swashbuckle Adventure</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/dm-dash-game-cc-2017.jpg"></span>
                <h5><a href="#">Danger Dash</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/mpam-game-cc-2017.jpg"></span>
                <h5><a href="#">My Pet and Friends</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/supertato-supermarket-showdown-game-cc.jpg"></span>
                <h5><a href="#">Supermarket Showdown</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/p05wjp0r.jpg"></span>
                <h5><a href="#">My World Kitchen</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/Peter_Rabbit_Update_content_card.jpg"></span>
                <h5><a href="#">Peter Rabbit's Hop To It</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/octonauts-ocean-adventures-cc.jpg"></span>
                <h5><a href="#">Octonauts Ocean Adventures</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/waffle-and-friends-game-cbeebies-cc.jpg"></span>
                <h5><a href="#">It's time to play with Waffle and Friends</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/ShaunTheSheep-BarnyardBoogie-Index.png"></span>
                <h5><a href="#">Barnyard Boogie</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/furchester-hotel-game-cc-2017-v2.jpg"></span>
                <h5><a href="#">The Furchester Hotel: A Helping Hand</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/shaun-race-the-flock-sp-index.jpeg"></span>
                <h5><a href="#">Race the Flock with Shaun the Sheep</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/go-jetters-hero-academy-cc-v2.jpg"></span>
                <h5><a href="#">Go Jetters Hero Academy</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/Tish-Tash-game-card-cc.jpg"></span>
                <h5><a href="#">Bobby's Rescue Mission</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/go-jetters-game-cc-2017.jpg"></span>
                <h5><a href="#">Help the Go Jetters beat Glitch</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/Graces-Amazing-Machines-game-index2.jpg"></span>
                <h5><a href="#">Speedy's Epic Journey</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/go-jetters-cadet-rescue-cc.jpg"></span>
                <h5><a href="#">Go on a mission with the Go Jetters</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/go-jetters-cadet-rescue-cc.jpg"></span>
                <h5><a href="#">Pablo's Art World Adventure</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/Bitzandbobindexcard.jpg"></span>
                <h5><a href="#">Have an ice cream party with Bitz & Bob</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/swashbuckle-midnight-mystery-game-gem-cc.jpg"></span>
                <h5><a href="#">The Midnight Mystery</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/SarahDuck_bubblepop_game_Banner_1024_576.jpg"></span>
                <h5><a href="#">Sarah and Duck game</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/go-jetters-global-grooves-index.jpg"></span>
                <h5><a href="#">Go Jetters Global Grooves</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/andys-safari-sounds-index02.jpg"></span>
                <h5><a href="#">Andy's Safari Sounds</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/peter-rabbit-running-wild-game-cc.jpg"></span>
                <h5><a href="#">Peter Rabbit Running Wild</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/Swashbuckle-The-Great-Pirate-Games-Content-Card.png"></span>
                <h5><a href="#">The Great Pirate Games</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/a_year_on_your_farm_content_card.jpg"></span>
                <h5><a href="#">Look after the animals down on the farm</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/bitz-and-bob-game-cc.jpg"></span>
                <h5><a href="#">Bitz & Bob Let’s Get Bitzy</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/contentindexbiggleton.jpg"></span>
                <h5><a href="#">Biggleton Helping Hands</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/jamillah-and-aladdin-comic-sky-1024.jpg"></span>
                <h5><a href="#">Cave of Wonders Comic</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/topsy_and_tim_at_the_farm_1024.jpg"></span>
                <h5><a href="#">Topsy and Tim at the Farm</a></h5>
            </div>
        </div>
        <div class="col-12 col-md-6 col-sm-6 col-lg-4">
            <div class="game-card">
                <span class="icon-box"><img src="/assets/default/img/games/andys-animal-teams-index.jpg"></span>
                <h5><a href="#">Andy's Animal Teams</a></h5>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@push('scripts_bottom')

@endpush

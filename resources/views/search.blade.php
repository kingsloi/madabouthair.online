@extends('canvas::frontend.layout')

@section('title', "Search NWI-Based Hair Stylist Maddie Raspe's Blog")
@section('og-title', "Search NWI-Based Hair Stylist Maddie Raspe's Blog")
@section('twitter-title', "Search NWI-Based Hair Stylist Maddie Raspe's Blog")
@section('og-description', "Search NWI-Based Hair Stylist Maddie Raspe's Blog")
@section('twitter-description', "Search NWI-Based Hair Stylist Maddie Raspe's Blog")

@section('og-image', asset('vendor/canvas/assets/images/mad-about-hair.jpg'))
@section('twitter-image', asset('vendor/canvas/assets/images/mad-about-hair.jpg'))

@section('content')

    <div class="container-fluid">

        @if ($query)
            <header class="viewing viewing--wide">
                <h1 class="viewing__title mb-0" itemprop="name">
                    Searching for: "<strong>{{ $query }}</strong>"
                </h1>
            </header>
        @endif

        <div class="search">

            @if ($posts)
                <section class="search__results posts">

                    @each('canvas::frontend.blog.partials.post', $posts, 'post', 'canvas::frontend.blog.partials.post-empty')

                </section>
            @endif

        </div>
    </div>

@endsection
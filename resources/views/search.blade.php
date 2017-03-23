@extends('canvas::frontend.layout')

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
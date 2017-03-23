@extends('canvas::frontend.layout')

@section('content')

    <div class="container-fluid">

        <section class="latest-post"
            @if ($latest->page_image)
                style="background-image: url({{ $latest->page_image }})";
            @endif
        >

            <img src="{{ $latest->page_image }}">

            <div class="latest-post__inner">
                <h2><a href="{{ $latest->url() }}">{{ $latest->title }}</a></h2>

                <div class="latest-post__excerpt">
                    {{ str_limit($latest->subtitle, config('blog.frontend_trim_width')) }}
                </div>

                <div class="latest-post__meta post-meta">
                    <span class="post-meta__date">{{ $latest->published_at->diffForHumans() }}</span>
                    <span class="post-meta__read-time">{{ $latest->readingTime() }} minute read</span>
                    @unless ($latest->tags->isEmpty())
                        <span class="post-meta__tags">
                            {!! implode(' ', $latest->tagLinks()) !!}
                        </span>
                    @endunless
                </div>

                <a href="{{ $latest->url() }}" class="btn btn-primary">Read More</a>
            </div>

        </section>

        <section class="about">
            <h2><abbr title="Northwest Indiana">NWI</abbr>-based hair stylist Maddie Raspe is a beauty expert with over 5 years of experience. Maddie is passionate about creating stunning looks and uncovering gorgeous hair.</h2>

            <a href="#" class="btn btn-primary">Schedule an Appointment Today <i class="fa fa-calendar" aria-hidden="true"></i></a>
        </section>

    </div>


    <section class="categories">
        <div class="category category--hair">
            <a class="category__link" href="#">
                <h2>Hair</h2>
            </a>
        </div>
        <div class="category category--diy">
            <a class="category__link" href="#">
                <h2>DIY</h2>
            </a>
        </div>
        <div class="category category--beauty">
            <a class="category__link" href="#">
                <h2>Beauty</h2>
            </a>
        </div>
        <div class="category category--wedding">
            <a class="category__link" href="#">
                <h2>Weddings</h2>
            </a>
        </div>
    </section>


    <section class="instagram">
        <div class="instagram__inner">

            <h2>Follow madabouthair on instagram <a href="https://www.instagram.com/madabouthair.online/">@madabouthair.online</a></h2>

            <div id="instafeed"></div>

        </div>
    </section>

@endsection
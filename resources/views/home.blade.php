@extends('canvas::frontend.layout')

@section('title', \Canvas\Models\Settings::blogTitle())

@section('og-title', \Canvas\Models\Settings::blogTitle())
@section('twitter-title', \Canvas\Models\Settings::blogTitle())
@section('og-description', \Canvas\Models\Settings::blogDescription())
@section('twitter-description', \Canvas\Models\Settings::blogDescription())

@section('og-image', asset('vendor/canvas/assets/images/mad-about-hair.jpg'))
@section('twitter-image', asset('vendor/canvas/assets/images/mad-about-hair.jpg'))

@section('content')

    <div class="container-fluid">

        <section class="latest-post"
            @if ($latest->page_image)
                style="background-image: url({{ $latest->page_image }})";
            @endif
        >

            <img src="{{ $latest->page_image }}">

            <div class="latest-post__inner">
                <small class="from-the-blog">Maddie's latest post</small>
                <h2><a href="{{ $latest->url() }}">{{ $latest->title }}</a></h2>

                <div class="latest-post__excerpt">
                    {{ str_limit($latest->subtitle, config('blog.frontend_trim_width')) }}
                </div>

                <div class="latest-post__meta post-meta">
                    <span class="post-meta__date">{{ $latest->published_at->diffForHumans() }}</span>
                    <span class="post-meta__read-time">{{ (($latest->readingTime() > 1) ? $latest->readingTime() : '1' ) }} minute read</span>
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
            @php
                $today = Carbon::now();
                $since = Carbon::createFromFormat('d/m/Y', config('maddie.professional_since'));
            @endphp
            <h2><abbr title="Northwest Indiana">NWI</abbr>-based hair stylist Maddie Raspe is a beauty expert with over {{ $today->diffInYears($since) }} years of experience. Maddie is passionate about creating stunning looks and uncovering gorgeous hair<a href="/blog/post/hello-world-its-me-maddie" style="font-size:1rem;">&hellip; more.</a></h2>

            <a href="/contact-maddie-raspe" class="btn btn-primary">Schedule an Appointment Today <i class="fa fa-calendar" aria-hidden="true"></i></a>
        </section>

    </div>


    <section class="categories">
        <div class="category category--wedding">
            <a class="category__link" href="/blog?tag=weddings">
                <h2>Weddings</h2>
            </a>
        </div>
        <div class="category category--diy">
            <a class="category__link" href="/blog?tag=diy">
                <h2>DIY</h2>
            </a>
        </div>
        <div class="category category--photoshoots">
            <a class="category__link" href="/blog?tag=photoshoots">
                <h2>Photoshoots</h2>
            </a>
        </div>
        <div class="category category--products">
            <a class="category__link" href="/blog?tag=products">
                <h2>Products</h2>
            </a>
        </div>
        <div class="category category--hair">
            <a class="category__link" href="/blog?tag=hair">
                <h2>Hair</h2>
            </a>
        </div>
    </section>

    <section class="quotes">

        <div class="quote-icon"></div>

        <div class="Wallop Wallop--slide">
            <div class="Wallop-list">
                <div class="Wallop-item Wallop-item--current">
                    <div class="quote">
                        <blockquote class="blockquote">
                            <p>You have to have fun with hair. It's a great accessory &mdash; play with it</p>
                            <footer class="blockquote-footer"><cite title="Serge Normant">Serge Normant</cite></footer>
                        </blockquote>
                    </div>
                </div>
                <div class="Wallop-item">
                    <div class="quote">
                        <blockquote class="blockquote">
                            <p>Trust the universe and respect your hair</p>
                            <footer class="blockquote-footer"><cite title="Bob Marley">Bob Marley</cite></footer>
                        </blockquote>
                    </div>
                </div>
                <div class="Wallop-item">
                    <div class="quote">
                        <blockquote class="blockquote">
                            <p><em>Hairdresser (noun):</em> an artist whose work is always on display.</p>
                        </blockquote>
                    </div>
                </div>
                <div class="Wallop-item">
                    <div class="quote">
                        <blockquote class="blockquote">
                            <p>Shake dreams from your hair&hellip;</p>
                            <footer class="blockquote-footer"><cite title="Bob Marley">Jim Morrisson</cite></footer>
                        </blockquote>
                    </div>
                </div>
                <div class="Wallop-item">
                    <div class="quote">
                        <blockquote class="blockquote">
                            <p>People will stare. Make it worth their while.</p>
                            <footer class="blockquote-footer"><cite title="Bob Marley">Harry Winston</cite></footer>
                        </blockquote>
                    </div>
                </div>
                <div class="Wallop-item">
                    <div class="quote">
                        <blockquote class="blockquote">
                            <p>Invest in your hair, it's the crown you never take off.</p>
                        </blockquote>
                    </div>
                </div>
            </div>

            <div class="quotes__pagination">
                <button class="Wallop-dot Wallop-dot--current">go to quote 1</button>
                <button class="Wallop-dot">go to quote 2</button>
                <button class="Wallop-dot">go to quote 3</button>
                <button class="Wallop-dot">go to quote 4</button>
                <button class="Wallop-dot">go to quote 5</button>
                <button class="Wallop-dot">go to quote 6</button>
            </div>

        </div>

    </section>

    <section class="instagram">
        <div class="instagram__inner">

            <h2>Follow madabouthair on instagram <a href="https://www.instagram.com/madabouthair.online/">@madabouthair.online</a></h2>

            <div id="instafeed"></div>

        </div>
    </section>

@endsection
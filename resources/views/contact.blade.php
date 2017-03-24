@extends('canvas::frontend.layout')

@section('title', 'Contact | ' . \Canvas\Models\Settings::blogTitle())

@section('og-title', 'Contact | ' . \Canvas\Models\Settings::blogTitle())
@section('twitter-title', 'Contact | ' . \Canvas\Models\Settings::blogTitle())
@section('og-description', "Whether you're looking for a new hair stylist, need to solve a hair dilemma, or want a consultation about onsite wedding (or other special occasion) hairdressing, contact Maddie Raspe today!")
@section('twitter-description', "Whether you're looking for a new hair stylist, need to solve a hair dilemma, or want a consultation about onsite wedding (or other special occasion) hairdressing, contact Maddie Raspe today!")

@section('og-image', asset('vendor/canvas/assets/images/mad-about-hair.jpg'))
@section('twitter-image', asset('vendor/canvas/assets/images/mad-about-hair.jpg'))

@section('content')

    <div class="container-fluid">

        <section class="contact">
            <h1>Contact Maddie</h1>

            <div class="clearfix">
                <div class="contact__info">
                    <p class="lead col-lg-6 px-0">Whether you're looking for a new hair stylist, need to solve a hair dilemma, or want a consultation about onsite wedding (or other special occasion) hairdressing, I'd love to hear from you!</p>
                    <ul>
                        <li>
                            <a href="https://facebook.com/madeline.raspe">
                                <div class="contact__icon">
                                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                </div>
                                <div class="contact__title">
                                    /madeline.raspe
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/madabouthair.online">
                                <div class="contact__icon">
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                </div>
                                <div class="contact__title">
                                    /madabouthair.online
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:madchambers32@yahoo.com">
                                <div class="contact__icon">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </div>
                                <div class="contact__title">
                                    madchambers32@yahoo.com
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="tel:2197944460">
                                <div class="contact__icon">
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
                                </div>
                                <div class="contact__title">
                                    (219) 794-4460
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="accepting">
                        <h2>Accepting:</h2>
                        <div class="cards">
                            <i class="fa fa-cc-visa" aria-hidden="true"></i>
                            <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
                            <i class="fa fa-cc-amex" aria-hidden="true"></i>
                            <i class="fa fa-cc-discover" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
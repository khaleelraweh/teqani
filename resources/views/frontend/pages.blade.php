@extends('layouts.app')

@section('style')
    <style>
        .about-content {
            padding: 20px 0;
        }

        @media(min-width:900px) {
            .main-banner .banner-content h1 {
                padding-top: 60px;
            }
        }
    </style>
@endsection


@section('content')
    <!-- Loader start -->
    <div class="bookshelf_wrapper">
        <ul class="books_list">
            <li class="book_item first"></li>
            <li class="book_item second"></li>
            <li class="book_item third"></li>
            <li class="book_item fourth"></li>
            <li class="book_item fifth"></li>
            <li class="book_item sixth"></li>
        </ul>
        <div class="shelf"></div>
    </div>
    <!-- Loader end -->

    <!-- banner section start -->
    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="banner-content">
                        <h1>{{ $page->title }}</h1>
                        <p><a class="text-gray-800" style="color: white;"
                                href="{{ route('frontend.index') }}">{{ __('transf.home') }}</a> -
                            {{ $page->title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner section end -->
    <!-- about-content start -->
    <div class="about-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {{-- <div class="section-title">
                        <span>Best solution for your Project</span>
                        <h2 class="heading-main-sec">{{ $page->title }}</h2>
                    </div> --}}
                    <p>
                        {!! $page->content !!}
                    </p>

                </div>
            </div>
        </div>
    </div>
    <!-- about-content end -->
@endsection

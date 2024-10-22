@extends('layouts.app')

@section('style')
    <style>
        @media(min-width:900px) {
            .main-banner-blog .banner-content h1 {
                padding-top: 60px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- loader start -->
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
    <!-- loader end -->

    @livewire('frontend.blogs.blog-list-component', ['slug' => $slug])
@endsection

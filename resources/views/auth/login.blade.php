@extends('layouts.app')

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



    <!-- banner section start -->
    <div class="comman-log-in clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-6 col-centered">
                    <div class="sign-in clearfix">
                        <div class="title">
                            <h1>sign in</h1>
                        </div>
                        <!-- contact-social section start -->
                        <div class="social clearfix">
                            <ul>
                                <li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#" class="google"><i class="fa fa-google-plus"
                                            aria-hidden="true"></i></a></li>
                                <li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#" class="pinterest"><i class="fa fa-pinterest-p"
                                            aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <div class="or-line clearfix">
                            <h3>or</h3>
                        </div>
                        <form method="POST" action="{{ route('login') }}">

                            @csrf
                            <div class="sign-in-form clearfix">
                                <div class="form-group">

                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        placeholder="Enter Your Name" value="{{ old('username') }}" required
                                        autocomplete="username" autofocus id="email">
                                    @error('username')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Enter Your Password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <p class="condition">
                                    <a href="{{ route('password.request') }}">Forgot-password</a>
                                </p>
                            </div>
                        </form>

                        <!-- contact-social section end -->
                        <a href="#" class="btn btn-default btn-red">sign in</a>
                        {{-- <button type="submit" class="btn btn-default btn-red">
                            {{ __('Login') }}
                        </button> --}}
                        <p class="have-account">Don’t have an account? <a href="sign-up.html">SIGN up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner section end -->
@endsection

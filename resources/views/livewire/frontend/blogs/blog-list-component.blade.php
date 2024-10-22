<div>
    <!-- banner section start -->
    <div class="main-banner-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="banner-content">
                        <h1>Blog List pages</h1>
                        <p>Home - Blog List Page</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner section end -->

    <!-- blog-list page start -->
    <div class="blog-list-main-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="blog-list-main-content">

                        @foreach ($posts as $post)
                            <!-- Blog List Block Start -->
                            <div class="blog-list-block">
                                <div class="image clearfix">
                                    @php
                                        if (
                                            $post->photos->first() != null &&
                                            $post->photos->first()->file_name != null
                                        ) {
                                            $post_img = asset('assets/posts/' . $post->photos->first()->file_name);

                                            if (
                                                !file_exists(
                                                    public_path('assets/posts/' . $post->photos->first()->file_name),
                                                )
                                            ) {
                                                $post_img = asset('image/not_found/item_image_not_found.webp');
                                            }
                                        } else {
                                            $post_img = asset('image/not_found/item_image_not_found.webp');
                                        }
                                    @endphp
                                    <img src="{{ $post_img }}" class="img-responsive" alt="blog-list-img-1">
                                </div>
                                <div class="content-detail-blog clearfix">
                                    <p class="heading-main">{{ $post->title }}</p>
                                    <div class="sub-heading-main">
                                        <ul>
                                            <li>{{ $post->tags->first()->name ?? 'Global' }}</li>
                                            <li> {{ $post->created_at ? \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F Y') : null }}
                                            </li>
                                            <li>{{ __('transf.posted_by') }}:
                                                <a href="#">{{ $post->users->first()->full_name ?? '' }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="desc">
                                        <p>
                                            {{ $post->description }}
                                        </p>
                                        <div class="read-more">
                                            <ul>
                                                <li>
                                                    <a class="btn btn-default"
                                                        href="{{ route('frontend.blog_single', $post->slug) }}"
                                                        role="button">Read
                                                        More</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Blog List Block End -->
                        @endforeach


                        <!-- Pagination Start -->
                        <div class="pagination-main visible-xs visible-sm">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <i class="fa fa-angle-left"></i> Previous</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">6</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">7</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Pagination End -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="blog-list-widget clearfix">
                        <!-- Search Widget Start -->
                        <div class="widget-block search-widget clearfix">
                            <h3 class="widget-title">search</h3>
                            <div class="search-box">
                                <input type="text" class="form-control" placeholder="Search here">
                                <a href="#" class="search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Search Widget End -->
                        <!-- News Post Widget Start -->
                        <div class="widget-block news-post-widget clearfix">
                            <div class="news-post-tab">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#recent" aria-controls="recent" role="tab" data-toggle="tab">Recent
                                            Post</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#popular" aria-controls="popular" role="tab"
                                            data-toggle="tab">Popular
                                            Post</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="recent">

                                        @foreach ($recent_posts->take(5) as $latest_post)
                                            <!-- News Block Start -->
                                            <div class="news-block">
                                                <div class="desc">
                                                    <div class="image">
                                                        @php
                                                            if (
                                                                $latest_post->photos->last() != null &&
                                                                $latest_post->photos->last()->file_name != null
                                                            ) {
                                                                $latest_post_img = asset(
                                                                    'assets/posts/' .
                                                                        $latest_post->photos->last()->file_name,
                                                                );

                                                                if (
                                                                    !file_exists(
                                                                        public_path(
                                                                            'assets/posts/' .
                                                                                $latest_post->photos->last()->file_name,
                                                                        ),
                                                                    )
                                                                ) {
                                                                    $latest_post_img = asset(
                                                                        'image/not_found/item_image_not_found.webp',
                                                                    );
                                                                }
                                                            } else {
                                                                $latest_post_img = asset(
                                                                    'image/not_found/item_image_not_found.webp',
                                                                );
                                                            }
                                                        @endphp
                                                        <img class="img-responsive" src="{{ $latest_post_img }}"
                                                            alt="news-post">
                                                    </div>
                                                    <span><i class="fa fa-clock-o" aria-hidden="true"></i>
                                                        {{ $latest_post->created_at ? \Carbon\Carbon::parse($latest_post->created_at)->translatedFormat('d F Y') : null }}
                                                    </span>
                                                    <a href="{{ route('frontend.blog_single', $latest_post->slug) }}"
                                                        class="news-title">{{ $latest_post->title }}</a>
                                                </div>
                                            </div>
                                            <!-- News Block End -->
                                        @endforeach

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="popular">...</div>
                                </div>
                            </div>
                        </div>
                        <!-- News Post Widget End -->

                        <!-- Advertisement Widget Start -->
                        <div class="widget-block advertisement-widget clearfix" style="display: none;">
                            <h3 class="widget-title">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i> advertisement
                            </h3>
                            <div class="row">
                                <!-- Col Start -->
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="advertisement-block full-block">
                                        <div class="image">
                                            <img class="img-responsive" src="assets/images/blog/advertisement-1.jpg"
                                                alt="advertisement">
                                        </div>
                                        <span class="title">video hive Deal 23off</span>
                                    </div>
                                </div>
                                <!-- Col End -->
                                <!-- Col Start -->
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="advertisement-block">
                                        <div class="image">
                                            <img class="img-responsive" src="assets/images/blog/advertisement-2.jpg"
                                                alt="advertisement">
                                        </div>
                                        <span class="title">WordPress Deals</span>
                                    </div>
                                </div>
                                <!-- Col End -->
                                <!-- Col Start -->
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="advertisement-block">
                                        <div class="image">
                                            <img class="img-responsive" src="assets/images/blog/advertisement-2.jpg"
                                                alt="advertisement">
                                        </div>
                                        <span class="title">WordPress Deals</span>
                                    </div>
                                </div>
                                <!-- Col End -->
                            </div>
                        </div>
                        <!-- Advertisement Widget End -->
                        <!-- Tags Widget Start -->
                        <div class="widget-block tags-widget clearfix">
                            <h3 class="widget-title">
                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i> tags widget
                            </h3>
                            <a href="#">wordpress</a>
                            <a href="#">psd template</a>
                            <a href="#">responsive</a>
                            <a href="#">web design</a>
                            <a href="#">great</a>
                            <a href="#">elegant</a>
                            <a href="#">wordpress</a>
                            <a href="#">psd template</a>
                            <a href="#">responsive</a>
                        </div>
                        <!-- Tags Widget End -->


                    </div>
                </div>
            </div>
            <!-- Pagination Start -->
            <div class="pagination-main hidden-xs hiddens-sm">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fa fa-angle-right"></i> Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">5</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">6</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">7</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Pagination End -->
        </div>
    </div>
    <!-- blog-list page start -->
</div>

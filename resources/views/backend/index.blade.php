@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('panel.dashboard') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">المعهد التقني</a></li>
                        <li class="breadcrumb-item active">{{ __('panel.dashboard') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.posts.index') }}" style="font-weight: bolder">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('panel.total_posts') }}</p>
                                <h4 class="mb-2">{{ $totalPosts }}</h4>

                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fab fa-blogger-b font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </a>
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.web_menus.index') }}" style="font-weight: bolder">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('panel.total_menus') }}</p>
                                <h4 class="mb-2">{{ $totalMainMenus }}</h4>

                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="fas fa-bars font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.supervisors.index') }}" style="font-weight: bolder">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('panel.total_supervisors') }}</p>
                                <h4 class="mb-2">{{ $totalSupervisor }}</h4>

                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-user-3-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </a>
        </div><!-- end col -->
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.pages.index') }}" style="font-weight: bolder">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">{{ __('panel.total_admin_pages') }}</p>
                                <h4 class="mb-2">{{ $totalPages }}</h4>

                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="far fa-file-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
        </div><!-- end col -->
    </div>
    </div><!-- end row -->
@endsection

@extends('admin::layouts.html')

@section('body')
    @stack('before_content')
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="#" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{admin()->miniLogo()}}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{admin()->logo()}}" alt="" height="17">
                                </span>
                            </a>
                            <a href="#" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{admin()->miniLogo()}}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{admin()->logo()}}" alt="" height="17">
                                </span>
                            </a>
                        </div>
                        <button type="button"
                                class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none"
                                id="topnav-hamburger-icon">
                                <span class="hamburger-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                    class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                                    data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        @auth()
                            <div class="dropdown ms-sm-3 header-item topbar-user">
                                <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                 src="{{auth()->user()->avatar??admin()->asset('/images/users/user-dummy-img.jpg')}}"
                                 alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    {{auth()->user()->name}}
                                </span>
                            </span>
                        </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @foreach($_this->userMenus() as $userMenu)
                                        <a class="dropdown-item" href="{{$userMenu->link()}}">
                                            @if($icon = $userMenu->icon())
                                                <i class="{{$icon}} text-muted fs-16 align-middle me-1"></i>
                                            @endif
                                            <span class="align-middle" data-key="t-logout">
                                        {{$userMenu->label()}}</span>
                                        </a>
                                    @endforeach

                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{admin()->miniLogo()}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{admin()->logo()}}" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="#" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{admin()->miniLogo()}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{admin()->logo()}}" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                        id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    @include('admin::layouts.partials.sidebar', ['menus' => $_this->menus()])
                </div>
            </div>
            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- title -->
                    @if($title = $_this->title())
                        <div class="row">
                            <div class="col-12">
                                <div
                                    class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                    <h4 class="mb-sm-0 d-flex align-items-center gap-2">
                                        @if($back = $_this->back())
                                            <a href="{{$back}}" class="text-black badge bg-light">
                                                <i class="ri-arrow-left-line"></i>
                                            </a>
                                        @endif
                                        <span>{!! $title !!}</span>
                                    </h4>
                                    <div class="page-title-right">
                                        {!! $_this->title_right() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- end title -->

                    <!-- alert-->
                    @if($__alert = session()->get('__alert'))
                        <x-admin::alert :closeable="$__alert['closeable']" :type="$__alert['type']"
                                        :icon="$__alert['icon']??null">
                            {!! $__alert['message'] !!}
                        </x-admin::alert>
                    @endif
                    <!--end alert-->

                    <!-- content -->
                    @include('admin::layouts.partials.children', ['children' => $_this->children ?? []])
                    <!-- end content -->
                </div>
            </div>
        </div>
    </div>
    @stack('after_content')
@endsection

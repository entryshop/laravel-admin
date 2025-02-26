<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                 viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
        <canvas class="particles-js-canvas-el" style="width: 100%; height: 100%;" width="3262" height="760"></canvas>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="#" class="d-inline-block auth-logo">
                                <img src="{{admin()->logo()}}" alt="" height="20">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">{{admin()->name()}}</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4 card-bg-fill">
                        <div class="card-body p-4">
                            <div class="p-2 mt-4">
                                @include('admin::partials.errors')
                                <form action="{{route(config('admin.as').'login.submit')}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="{{admin()->username()}}"
                                               class="form-label">{{admin()->usernameLabel()}}</label>
                                        <input type="text" class="form-control" name="{{admin()->username()}}"
                                               placeholder="{{admin()->usernameLabel()}}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"
                                               for="password-input">@lang('admin::auth.password')</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input"
                                                   placeholder="@lang('admin::auth.password')" name="password">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               id="auth-remember-check">
                                        <label class="form-check-label"
                                               for="auth-remember-check">@lang('admin::auth.remember')</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100"
                                                type="submit">@lang('admin::auth.login')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            ©{{date('Y')}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

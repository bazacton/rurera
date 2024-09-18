@extends(getTemplate().'.layouts.app')
@push('styles_top')
<style>
    body{background-color: #fafafa !important;}
</style>
@endpush
@section('content')
    <div class="container">
        <div class="text-center mb-30 mt-50">
            <a href="/" class="login-logo d-inline-flex justify-content-center align-items-center">
                <img src="/assets/default/img/sidebar/logo.svg" class="img-cover" alt="Rurera Logo" title="Rurera Logo" width="68" height="67" itemprop="image" loading="eager">
                <span class="logo-text font-30 font-weight-bold ml-10">Rurera</span>
            </a>
        </div>
        <div class="login-container mt-0">
            <div class="login-holder row" style="padding:0;">

            <div class="col-12 col-md-6 pl-0">
                <img src="{{ getPageBackgroundSettings('remember_pass') }}" class="img-cover" alt="Login">
            </div>

            <div class="col-12 col-md-6">

                <div class="login-card mt-20">
                    <h1 class="font-20 font-weight-bold">{{ trans('auth.forget_password') }}</h1>

                    <form method="post" action="/send-email" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="input-label" for="email">{{ trans('auth.email') }}:</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   aria-describedby="emailHelp">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-20">{{ trans('auth.reset_password') }}</button>
                    </form>

                    <div class="text-center mt-20">
                        <span class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center">or</span>
                    </div>

                    <div class="text-center mt-20">
                        <span class="text-secondary">
                            <a href="/login" class="text-secondary font-weight-bold">{{ trans('auth.login') }}</a>
                        </span>
                    </div>

                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')

@section('style')
<style>
.social-login .fa {
    font-size:1.1rem;
}
.social-login.github .btn,
.social-login.facebook .btn,
.social-login.naver .btn {
    background-color:#fff;
}

.social-login.github .btn {
    color:#6c757d;
}
.social-login.facebook .btn {
    color:#3b5998;
}

.social-login.naver .btn {
    color:#00C63B;
    border-color: #00C63B;
    background-color: #fff;
}
.social-login.kakao img {
    width:20px;
}
.social-login.kakao .btn {
    color:rgba(60, 30, 30, 1);
    border-color: rgba(255, 235, 0, 1);
    background-color: rgba(255, 235, 0, 1);
}

.social-login.github .btn:hover,
.social-login.github .btn.hover {
    border-color: #6c757d !important;
    background-color:#6c757d !important;
    color:#fff;
    -webkit-box-shadow: 0 0 0 0.2rem rgba(108, 117, 125,
0.5) !important;
    box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5) !important;
}

.social-login.facebook .btn:active,
.social-login.facebook .btn:hover,
.social-login.facebook .btn:focus,
.social-login.facebook .btn.active,
.social-login.facebook .btn.hover,
.social-login.facebook .btn.focus {
    border-color: #3b5998 !important;
    background-color:#3b5998 !important;
    color:#fff;
    -webkit-box-shadow: 0 0 0 0.2rem rgba(59, 89, 152,
0.5) !important;
    box-shadow: 0 0 0 0.2rem rgba(59, 89, 152, 0.5) !important;
}

.social-login.naver .btn:active,
.social-login.naver .btn:hover,
.social-login.naver .btn:focus,
.social-login.naver .btn.active,
.social-login.naver .btn.hover,
.social-login.naver .btn.focus {
    border-color: #00C63B !important;
    background-color:#00C63B !important;
    color:#fff;
    -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 198, 59,
0.5) !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 198, 59, 0.5) !important;
}

.social-login.kakao .btn:active,
.social-login.kakao .btn:hover,
.social-login.kakao .btn:focus,
.social-login.kakao .btn.active,
.social-login.kakao .btn.hover,
.social-login.kakao .btn.focus {
    border-color: rgba(255, 222, 0, 1) !important;
    background-color:rgba(255, 222, 0, 1) !important;
    -webkit-box-shadow: 0 0 0 0.2rem rgba(255, 222, 0, 0.5) !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 222, 0, 0.5) !important;
}

.text-divider {
    margin: 2em 0;
    line-height: 0;
    text-align: center;
}
.text-divider span {
    background-color: #fff;
    padding: 1em;
    color:#6c757d;
}
.text-divider:before {
    content: " ";
    display: block;
    border-top: 1px solid #dddddd;
    border-bottom: 1px solid #d1d1d1;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group social-login github">
                            <a href="{{ route('login.social.login', 'github') }}" class="btn btn-default btn-block btn-secondary" id="github-button">
                                <strong>
                                    {!! icon('github') !!}
                                    {{ __('auth.login_with_github') }}
                                </strong>
                            </a>
                        </div>

                        <div class="form-group social-login facebook">
                            <a href="{{ route('login.social.login', 'facebook') }}" class="btn btn-default btn-block btn-secondary">
                                <strong>
                                    {!! icon('facebook') !!}
                                    {{ __('auth.login_with_facebook') }}
                                </strong>
                            </a>
                        </div>

                        <div class="form-group social-login naver">
                            <a href="{{ route('login.social.login', 'naver') }}" class="btn btn-default btn-block btn-secondary">
                                <strong>
                                    <img src="/images/naver_logo.png" alt="naver">
                                    {{ __('auth.login_with_naver') }}
                                </strong>
                            </a>
                        </div><div class="form-group social-login kakao">
                            <a href="{{ route('login.social.login', 'naver') }}" class="btn btn-default btn-block btn-secondary">
                                <strong>
                                    <img src="/images/kakaolink_btn_small.png" alt="naver">
                                    {{ __('auth.login_with_kakao') }}
                                </strong>
                            </a>
                        </div>

                        <div class="text-divider">
                            <span><strong>OR</strong></span>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('auth.email_address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('auth.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('auth.title_login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('auth.button_remind_password') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

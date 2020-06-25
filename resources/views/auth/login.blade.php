<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
@include('layouts.header-mobile')
<!-- END HEADER MOBILE-->

    <!-- END MENU SIDEBAR-->
    <link href="{{ asset('assets/lib/codemirror.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/darcula.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/lib/codemirror.js') }}"></script>
    <script src="{{ asset('assets/mode/xml/xml.js') }}"></script>
    <!-- PAGE CONTAINER-->
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="{{asset('images/icon/fenix-logo-v4.png')}}" alt="Phoenix">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="login-checkbox">
{{--                                    <label>--}}
{{--                                        <input type="checkbox" name="remember">Remember Me--}}
{{--                                    </label>--}}
                                    <label>
                                        <a href="#">Забыли пароль?</a>
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Войти</button>
{{--                                <div class="social-login-content">--}}
{{--                                    <div class="social-button">--}}
{{--                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">sign in with facebook</button>--}}
{{--                                        <button class="au-btn au-btn--block au-btn--blue2">sign in with twitter</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </form>
                            <div class="register-link">
                                <p>
                                    У вас нет аккаунта?
                                    <a href="{{ route('register') }}">Зарегистрироваться</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@include('layouts.scripts')
</body>

</html>

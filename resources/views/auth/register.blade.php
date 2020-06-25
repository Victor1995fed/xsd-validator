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
                            <form action="{{ route('register') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('Логин') }}</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Повторите пароль</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
{{--                                <div class="login-checkbox">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" name="aggree">Agree the terms and policy--}}
{{--                                    </label>--}}
{{--                                </div>--}}
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Зарегистрироваться</button>
{{--                                <div class="social-login-content">--}}
{{--                                    <div class="social-button">--}}
{{--                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">register with facebook</button>--}}
{{--                                        <button class="au-btn au-btn--block au-btn--blue2">register with twitter</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </form>
                            <div class="register-link">
                                <p>
                                    Уже есть аккаунт?
                                    <a href="{{ route('login') }}">Вход</a>
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

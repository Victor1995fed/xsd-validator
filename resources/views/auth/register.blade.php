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
                            <!-- добавление элемента div -->
{{--                                {{print_r(Config::get('recaptcha'))}}--}}

                            <!-- добавление элемента div -->
                                <div class="g-recaptcha" data-sitekey="{{getenv('CAPTCHA_KEY_PUBLIC')}}"></div>

                                <!-- элемент для вывода ошибок -->
                                <div class="text-danger" id="recaptchaError"></div>

                                <!-- js-скрипт гугл капчи -->



                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Зарегистрироваться</button>
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Ошибка</span>
                                            {{$error}}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
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
    <style>
        .g-recaptcha {
            margin: 10px auto;
        }
    </style>
    @include('layouts.scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    // Работа с виджетом recaptcha
    // 1. Получить ответ гугл капчи
    var captcha = grecaptcha.getResponse();

    // 2. Если ответ пустой, то выводим сообщение о том, что пользователь не прошёл тест.
    // Такую форму не будем отправлять на сервер.
    if (!captcha.length) {
        // Выводим сообщение об ошибке
        $('#recaptchaError').text('* Вы не прошли проверку "Я не робот"');
    } else {
        // получаем элемент, содержащий капчу
        $('#recaptchaError').text('');
    }

    // 3. Если форма валидна и длина капчи не равно пустой строке, то отправляем форму на сервер (AJAX)
    if ((formValid) && (captcha.length)) {

        // добавить в formData значение 'g-recaptcha-response'=значение_recaptcha
        formData.append('g-recaptcha-response', captcha);

    }

    // 4. Если сервер вернул ответ error, то делаем следующее...
    // Сбрасываем виджет reCaptcha
    grecaptcha.reset();
    // Если существует свойство msg у объекта $data, то...
    if ($data.msg) {
        // вывести её в элемент у которого id=recaptchaError
        $('#recaptchaError').text($data.msg);
    }
    </script>
</body>

</html>

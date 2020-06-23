<header class="header-desktop3 d-none d-lg-block">
    <div class="section__content section__content--p35">
        <div class="header3-wrap">
            <div class="header__logo">
                <a href="{{url('/')}}">

{{--                    <img src="images/icon/logo-white.png" alt="CoolAdmin" />--}}
{{--                    <img src="images/icon/fenix-logo.png" alt="CoolAdmin" />--}}
                    <img src="{{asset('images/icon/fenix-logo-v4.png')}}" alt="Феникс" />
                    <span style="margin-left: 10px; color: #ccc">PHOENIX</span>
                </a>
            </div>
            <div class="header__navbar">
                <ul class="list-unstyled">
                    <li>
                        <a href="{{url('/')}}">
                            <i class="fas fa-th"></i>
                            <span class="bot-line"></span>Главная</a>
                    </li>


                    <li class="has-sub">
                        <a href="#">
                            <i class="fas fa-file-text"></i>
                            <span class="bot-line"></span>XSD</a>
                        <ul class="header3-sub-list list-unstyled">
                            <li>
                                <a href="{{url('/xsd')}}">Список</a>
                            </li>
                            <li>
                                <a href="{{url('validator')}}">Бытрая проверка по XSD</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{url('/help')}}">
                            <i class="fas fa-info"></i>
                            <span class="bot-line"></span>Помощь</a>
                    </li>

                </ul>
            </div>

            <div class="header__tool">
                @guest
                    <div class="header-button-item js-item-menu">
                        <i class="zmdi zmdi-settings"></i>
                        <div class="account-dropdown js-dropdown">
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="zmdi zmdi-account"></i>Войти</a>
                                </div>

                    @if (Route::has('register'))
                                    <div class="account-dropdown__item">
                                        <a class="nav-link" href="{{ route('register') }}">
                                            <i class="zmdi zmdi-settings"></i>Зарегистрироваться</a>
                                    </div>

                    @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="account-wrap">
                        <div class="account-item account-item--style2 clearfix js-item-menu">
                            <div class="image">
                                <img src="{{asset('images/icon/ava-v1.png')}}" alt="John Doe" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">{{Auth::user()->name}}</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
{{--                                <div class="info clearfix">--}}
{{--                                    <div class="image">--}}
{{--                                        <a href="#">--}}
{{--                                            <img src="{{asset('images/icon/ava-v1.png')}}"/>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="content">--}}
{{--                                        <h5 class="name">--}}
{{--                                            <a href="#">{{Auth::user()->name}}</a>--}}
{{--                                        </h5>--}}
{{--                                        <span class="email">{{Auth::user()->email}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Аккаунт</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Настройки</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                                        <i class="zmdi zmdi-power"></i>Выйти</a>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
{{--                                    <a href="#">--}}

                                </div>
                            </div>
                        </div>
                    </div>
                @endguest

            </div>
        </div>
    </div>
</header>

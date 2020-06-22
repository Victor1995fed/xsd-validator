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
{{--                            <li>--}}
{{--                                <a href="register.html">Публичные</a>--}}
{{--                            </li>--}}
                            <li>
                                <a href="{{url('validator')}}">Бытрая проверка по XSD</a>
                            </li>
                        </ul>
                    </li>
{{--                    <li class="has-sub">--}}
{{--                        <a href="#">--}}
{{--                            <i class="fas fa-file-text"></i>--}}
{{--                            <span class="bot-line"></span>Генератор форм</a>--}}
{{--                        <ul class="header3-sub-list list-unstyled">--}}
{{--                            <li>--}}
{{--                                <a href="{{url('/xsd')}}">Мои</a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="register.html">Публичные</a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a href="{{url('validator')}}">Бытрая генерация</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{url('/')}}">--}}
{{--                            <i class="fas fa-info"></i>--}}
{{--                            <span class="bot-line"></span>Новости</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{url('/')}}">--}}
{{--                            <i class="fas fa-question"></i>--}}
{{--                            <span class="bot-line"></span>Помощь</a>--}}
{{--                    </li>--}}

                </ul>
            </div>
            <div class="header__tool">
                <div class="header-button-item has-noti js-item-menu">
                    <i class="zmdi zmdi-notifications"></i>
                    <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                        <div class="notifi__title">
                            <p>You have 3 Notifications</p>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c1 img-cir img-40">
                                <i class="zmdi zmdi-email-open"></i>
                            </div>
                            <div class="content">
                                <p>You got a email notification</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c2 img-cir img-40">
                                <i class="zmdi zmdi-account-box"></i>
                            </div>
                            <div class="content">
                                <p>Your account has been blocked</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__item">
                            <div class="bg-c3 img-cir img-40">
                                <i class="zmdi zmdi-file-text"></i>
                            </div>
                            <div class="content">
                                <p>You got a new file</p>
                                <span class="date">April 12, 2018 06:50</span>
                            </div>
                        </div>
                        <div class="notifi__footer">
                            <a href="#">All notifications</a>
                        </div>
                    </div>
                </div>
                <div class="header-button-item js-item-menu">
                    <i class="zmdi zmdi-settings"></i>
                    <div class="setting-dropdown js-dropdown">
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-account"></i>Account</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-money-box"></i>Billing</a>
                            </div>
                        </div>
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-globe"></i>Language</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-pin"></i>Location</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-email"></i>Email</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-notifications"></i>Notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-wrap">
                    <div class="account-item account-item--style2 clearfix js-item-menu">
                        <div class="image">
                            <img src="{{asset('images/icon/ava-v1.png')}}" alt="John Doe" />
                        </div>
                        <div class="content">
                            <a class="js-acc-btn" href="#">Super User</a>
                        </div>
                        <div class="account-dropdown js-dropdown">
                            <div class="info clearfix">
                                <div class="image">
                                    <a href="#">
                                        <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                    </a>
                                </div>
                                <div class="content">
                                    <h5 class="name">
                                        <a href="#">john doe</a>
                                    </h5>
                                    <span class="email">johndoe@example.com</span>
                                </div>
                            </div>
                            <div class="account-dropdown__body">
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-account"></i>Account</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                </div>
                                <div class="account-dropdown__item">
                                    <a href="#">
                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                </div>
                            </div>
                            <div class="account-dropdown__footer">
                                <a href="#">
                                    <i class="zmdi zmdi-power"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

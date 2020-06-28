<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    @include('layouts.header-mobile')
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
{{--    @include('layouts.aside')--}}
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
    @include('layouts.header-desktop')
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Главная</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-25">
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c1">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                        <div class="text">
                                            <h2>{{$countXsd}}</h2>
                                            <span>Загружено схем</span>
                                        </div>
                                    </div>
                                    <div class="overview-chart">
{{--                                        <canvas id="widgetChart1"></canvas>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c2">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-account-o"></i>
                                        </div>
                                        <div class="text">
                                            <h2>{{$countUsers}}</h2>
                                            <span>Пользователей</span>
                                        </div>
                                    </div>
                                    <div class="overview-chart" >
{{--                                        <canvas id="widgetChart2"></canvas>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="col-sm-6 col-lg-3">--}}
{{--                            <div class="overview-item overview-item--c3">--}}
{{--                                <div class="overview__inner">--}}
{{--                                    <div class="overview-box clearfix">--}}
{{--                                        <div class="icon">--}}
{{--                                            <i class="fa  fa-comment"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="text">--}}
{{--                                            <h2>1,086</h2>--}}
{{--                                            <span>Комментариев </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="overview-chart">--}}
{{--                                        <canvas id="widgetChart3"></canvas>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-6 col-lg-3">--}}
{{--                            <div class="overview-item overview-item--c4">--}}
{{--                                <div class="overview__inner">--}}
{{--                                    <div class="overview-box clearfix">--}}
{{--                                        <div class="icon">--}}
{{--                                            <i class="fa   fa-desktop"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="text">--}}
{{--                                            <h2>500</h2>--}}
{{--                                            <span>Показов за сегодня</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="overview-chart">--}}
{{--                                        <canvas id="widgetChart4"></canvas>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                </div>
            </div>

        </div>
    @include('layouts.footer')

    <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
@include('layouts.scripts')


</body>

</html>
<!-- end document-->

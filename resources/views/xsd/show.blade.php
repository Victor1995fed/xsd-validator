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
    @include('layouts.header-desktop')
    <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">

                <div class="container custom-container" >
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="title-5" >Просмотр xsd-схемы
                            </h4>
                            <hr class="line-seprate">
                        </div>
                    </div>
                </div>

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header"><strong class="card-title">{{$xsd->title}}</strong></div>
                    <div class="card-body card-block">

                        <div>
                            <p><i class="fa fa-calendar"></i> <strong>Обновлено: </strong> {{$xsd->updated_at}}</p>
                        </div>
                        <hr>
                            @if($xsd->description != '')
                            <div>
                                <p><i class="fa fa-info-circle"></i> <strong>Описание:</strong> {{$xsd->description}}</p>
                            </div>
                            @endif


                        <hr>
                                @foreach ($xsd->files as $file)
                            <p><i class="fa fa-file-text"></i> <strong>Файл xsd:</strong> {{$file->title}}</p>
                                    <div>

{{--                                        <a href="{{url("file").'/'.$file->uuid}}" target="_blank" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Смотреть">--}}
{{--                                            <i class="fa fa-eye"></i>--}}
{{--                                        </a>--}}
                                        <a href="{{url("file").'/'.$file->uuid}}" target="_blank" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Скачать">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach

                                    <hr>

                        <div class="button-action">
                            <a class="btn btn-primary btn-sm" href="{{url("xsd/test").'/'.$xsd->id}}">
                                <i class="fa fa-code"></i>&nbsp; Тестировать XML</a>
                            <a  class="btn btn-success btn-sm">
                                <i class="fa fa-cog"></i>&nbsp; Изменить</a>
                            <a  class="btn btn-danger btn-sm">
                                <i class="zmdi zmdi-delete"></i>&nbsp; Удалить</a>
                        </div>



                    </div>
                </div>
            </div>
        </div>

    </div>
    <style>
        .button-action a {
            color: #fff;
            /*pointer-events: none;*/
        }
        .button-action a:hover {
            color: #fff;
        }
        .custom-container {
            margin: 0;
        }
    </style>
@include('layouts.scripts')

</body>

</html>

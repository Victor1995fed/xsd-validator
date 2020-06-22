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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong class="card-title">{{$xsd->title}}</strong></div>
                    <div class="card-body card-block">
                        <div class="card">
                            <div class="card-header">
                                <h4>Архив</h4>
                            </div>
                            <div class="card-body">
                                @foreach ($xsd->files as $file)
                                    <p class="muted">{{$file->title}}</p>
                                    <div>
                                        <a href="{{url("file").'/'.$file->uuid}}" target="_blank" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Скачать">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{url("file").'/'.$file->uuid}}" target="_blank" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Скачать">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach



                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5 class="mb-3">Описание</h5>
                            <div class="jumbotron">
                                {{$xsd->description}}
                            </div>
                        </div>
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
    </style>
@include('layouts.scripts')

</body>

</html>

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
            <div class="card">
                <div class="card-header">
                    Введите данные для XSD
                </div>
                <div class="card-body card-block">
                    <form action = "{{url("xsd")}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Название схемы</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" name="text-input"  class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="file-input" class=" form-control-label">Архив с xsd</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" id="file-input" name="file-input" class="form-control-file">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="text-input" class=" form-control-label">Путь к корневой схеме в архиве</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="text-input" name="text-input"  class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="textarea-input" class=" form-control-label">Описание(не обязательно)</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="textarea-input" id="textarea-input" rows="9" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i> Сохранить
                    </button>
                    <button type="reset" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Отменить
                    </button>
                </div>
            </div>
        </div>

    </div>
@include('layouts.scripts')

</body>

</html>

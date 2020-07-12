<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
@include('layouts.header-mobile')
<!-- END HEADER MOBILE-->

    <!-- END MENU SIDEBAR-->
    <link href="{{ asset('css/bootstrap-select.css') }}" rel="stylesheet">

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
                <div class="card-body card-block">
                    <form action = "{{url("xsd")}}" method="post" id="save-xsd" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="title" class=" form-control-label">Название схемы</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="title" name="title"  class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="xsd-file" class=" form-control-label">Архив с xsd</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" id="xsd-file" name="xsd-file" class="form-control-file">
                            </div>
                        </div>
                        <div class="row form-group" id="main-xsd-div">
                            <div class="col col-md-3">
                                <label for="xsdName">Название корневой xsd в архиве</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select class="form-control" id="xsdName" name="root_xsd">

                                </select>
                            </div>
                        </div>
{{--                        <div class="row form-group">--}}
{{--                            <div class="col col-md-3">--}}
{{--                                <label for="root_xsd" class=" form-control-label">Путь к корневой схеме в архиве</label>--}}
{{--                            </div>--}}
{{--                            <div class="col-12 col-md-9">--}}
{{--                                <input type="text" id="root_xsd" name="root_xsd"  class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="description" class="form-control-label">Описание(не обязательно)</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="description" id="description" rows="9" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="switch-public" class="form-control-label">Опубликовать</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <label class="switch switch-3d switch-success mr-3">
                                    <input id="switch-public" type="checkbox" name="public" class="switch-input">
                                    <span class="switch-label"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>

                        </div>
                        @if(count($tags) > 0)
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="xsd-file" class=" form-control-label">Метки</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <select class="selectpicker"  name="tags[]" multiple data-live-search="true" title="Выберите метки ...">
                                        @foreach($tags as $tag)
                                            <option value="{{$tag->id}}">{{$tag->title}}</option>
                                        @endforeach

                                    </select>


                                </div>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" form="save-xsd" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i> Сохранить
                    </button>
                    <button type="reset" onclick="history.back();" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Отменить
                    </button>
                </div>
            </div>
            @include('layouts.footer')
        </p>

    </div>

@include('layouts.scripts')
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
<script>
        $('.selectpicker').selectpicker();
    //TODO:: Произвести рефактор кода
    //Событие загрузки файла
    let selectRootXsd = $("#xsdName")
    let divSelect = $("#main-xsd-div")
    divSelect.hide()
    $("#xsd-file").change(function () {
        if (this.files.length > 0) {
            divSelect.hide()
            $("#xsdName").empty()
            //Загружаем на сервер
            let zip = new FormData();
            zip.append('zip', $('input[type=file]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{url("file/get-list-zip")}}',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                data: zip,
                complete: function() {
                    // alert('готово')
                },
                success: function(data){
                    divSelect.show()
                    //Заполнение данными
                    $.each(data,function(key, value)
                    {
                        // console.warn(key+value)
                        $("#xsdName").append('<option value=' + value + '>' + value + '</option>');
                    });
                    console.log(data)
                },
                error: function (request, error) {
                    alert(request.responseText)
                },
            });
        }
    });
</script>
</body>

</html>

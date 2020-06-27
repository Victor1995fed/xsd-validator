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
                <div class="card-body card-block">
                    <form action = "{{url("xsd/$xsd->id")}}" method="post" id="save-xsd" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="title" class=" form-control-label">Название схемы</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="title" value="{{$xsd->title}}" name="title"  class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="xsd-file" class=" form-control-label">Архив с xsd</label>
                            </div>
                            <div class="col-12 col-md-9" id="fileXsdDiv">
                                <input type="file" id="xsd-file" name="xsd-file" class="form-control-file">
                            </div>
                            <div class="col-12 col-md-9" id="div-xsd-file-text">
                                <input type="text" disabled id="xsd-file-text" value="{{$xsd->files[0]->title ?? ''}}" name="xsd-file-text" class="form-control-file">
                                <button type="button" id="removeFileXsd" class="item btn-danger btn-sm" data-toggle="tooltip" data-original-title="Удалить">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group" id="main-xsd-div">
                            <div class="col col-md-3">
                                <label for="xsdName">Название корневой xsd в архиве</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select class="form-control" id="xsdName" name="root_xsd">
                                    @foreach($listFilesZip as $oneFile)
                                        <option value="{{$oneFile}}" {{($oneFile == $xsd->root_xsd) ? 'selected' : ''}}>{{$oneFile}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="description" class="form-control-label">Описание(не обязательно)</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="description" id="description" value="{{$xsd->description}}" rows="9" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="switch-public" class="form-control-label">Опубликовать</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <label class="switch switch-3d switch-success mr-3">
                                    <input id="switch-public" type="checkbox" name="public" {{$xsd->public == 1 ? 'checked' : ''}} class="switch-input">
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
                                    <select class="selectpicker" name="tags[]" multiple data-live-search="true" title="Выберите метки ...">
                                        @foreach($tags as $tag)
                                            <option {{ in_array($tag->id,  $choiceTag) === true ? 'selected' : ''}} value="{{$tag->id}}">{{$tag->title}}</option>
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
        </div>

    </div>
    @include('layouts.scripts')
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    <script>
        $('.selectpicker').selectpicker();
        //TODO:: Произвести рефактор кода
        //Событие загрузки файла
        let selectRootXsd = $("#xsdName")
        let divSelect = $("#main-xsd-div")
        let fileXsdDiv = $("#fileXsdDiv")
        let divXsdFileText = $("#div-xsd-file-text")
        fileXsdDiv.hide()
        $("#removeFileXsd").click(function () {
            divSelect.hide()
            divXsdFileText.hide()
            fileXsdDiv.show()

        })
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

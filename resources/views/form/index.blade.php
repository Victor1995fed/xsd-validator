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
            <div class="section__content section__content--p30">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <h1 class="title-4">Генерация формы   по XSD</h1>
                            <hr class="line-seprate">
                        </div>
                        <form action = "{{url("validator")}}"  method="post" enctype="multipart/form-data" id="validatorXsd">
                            @csrf
                            <div class="form-group">
                                <label for="xsd">Архив с XSD</label>
                                <input id="xsdFile" type="file" class="form-control-file" name="zip">
                            </div>
                            <div class="row form-group" id="main-xsd-div">
                                <div class="col col-md-12">
                                    <label for="xsdName">Название корневой xsd в архиве</label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="xsdName" name="main-xsd">

                                    </select>
                                </div>
                            </div>

                            <div class="row form-group" id="main-xsd-div">
                                <div class="col col-md-12">
                                    <label for="xsdName">Укажите элемент относительно которого требуется сформировать форму</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="root-element" type="text">
                                </div>
                            </div>

                            <button class="btn btn-primary" id="submitAjax" type="button">
                                <span class="spinner-border spinner-border-sm displayNone" role="status" aria-hidden="true"></span>
                                Сгенерировать форму
                            </button>
                        </form>

                        <div id="alert-errors" style="margin-top: 10px"></div>

                        <div class="result-response">

                            <div class="alert alert-success result displayNone" role="alert" id="result_success" >
                                <span class="badge badge-pill badge-success">Успешно</span>
                                <div class="content_alert"></div>
                            </div>
                            <div class="alert alert-danger result displayNone" role="alert" id="result_error" >
                                <span class="badge badge-pill badge-danger">Найдены ошибки</span>
                                <div class="content_alert"></div>
                            </div>
                            <div class="alert alert-warning result displayNone" role="alert" id="warning_error" >
                                <span class="badge badge-pill badge-warning">Замечания</span>
                                <div class="content_alert"></div>
                            </div>

                        </div>
                        <div class="row form-group" id="main-xsd-div">
                            <div class="col col-md-12">
                                <label for="xsdName">Результат</label>
                            </div>
                            <div class="col-md-6">
                                <textarea id="json-renderer"></textarea>
                            </div>

                        </div>
                        <button class="btn btn-primary"  onclick="copyTextElem('json-renderer')" type="button">

                            Скопировать
                        </button>
{{--                        <button onclick="copyTextElem('json-renderer')">Скопировать</button><br>--}}


                    </div>

                </div>

            </div>
        </div>

        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
    @include('layouts.footer')
</div>
@include('layouts.scripts')
<script src="{{asset('assets/json-viewer/jquery.json-viewer.js')}}"></script>
<script>
    function recur( my_array ){
        if ( my_array && typeof my_array === "object" && Object.prototype.toString.call( my_array ) === "[object Object]" ) {
            for (let Name in my_array) {
                // document.write(Name + " = " + recur( my_array[Name] ) + "<br>");
            }
        } else {
            return my_array;
        }
    }

    {{--$("#get").click(function (){--}}
    {{--    let dataXml = $('#xml').val();--}}
    {{--    $("#result").empty()--}}
    {{--    $.ajax({--}}
    {{--        type: 'POST',--}}
    {{--        url: '{{url("xml/get/format")}}'+'?format=php_array&set_value=Helper::checkVal($OS, \'null\')&clear_value=1',--}}
    {{--        enctype: 'application/xml',--}}
    {{--        processData: false,--}}
    {{--        contentType: false,--}}
    {{--        cache: false,--}}
    {{--        timeout: 600000,--}}
    {{--        data: dataXml,--}}
    {{--        complete: function() {--}}

    {{--        },--}}
    {{--        success: function(data){--}}
    {{--            console.warn(data)--}}
    {{--            $('#json-renderer').jsonViewer(data, { withQuotes: true});--}}
    {{--            $('#json-renderer').renderPhpArray(data,{ withQuotes: true})--}}

    {{--        },--}}
    {{--        error: function (request, error) {--}}

    {{--        },--}}
    {{--    });--}}
    {{--});--}}


    function copyTextElem(idElem) {
        let elm = document.getElementById(idElem);
        // for Internet Explorer
        if(document.body.createTextRange) {
            let range = document.body.createTextRange();
            range.moveToElementText(elm);
            range.select();
            document.execCommand("Copy");
            document.selection.empty();
            alert("Copied div content to clipboard");
        }
        else if(window.getSelection) {
            // other browsers
            let selection = window.getSelection();
            let range = document.createRange();
            range.selectNodeContents(elm);
            selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand("Copy");
            window.getSelection().removeAllRanges();
            alert("Copied div content to clipboard");
        }
    }

    //TODO:: Произвести рефактор кода
    //Событие загрузки файла
    let selectRootXsd = $("#xsdName")
    let divSelect = $("#main-xsd-div")
    divSelect.hide()
    $("#xsdFile").change(function () {
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



    $('#submitAjax').click(function () {
        $('.result .content_alert').empty();
        $('.result').addClass('displayNone');
        let data = new FormData();
        data.append('main-xsd', $("select[name='main-xsd']").val());
        data.append('_token', $("input[name='_token']").val());
        data.append('zip', $('input[type=file]')[0].files[0]);
        data.append('root-element', $("input[name='root-element']").val());
        $('.spinner-border').removeClass('displayNone');
        $('#submitAjax').prop( "disabled", true );
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '{{url("get-form-json")}}',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                data: data,
                complete: function() {
                    $('.spinner-border').addClass('displayNone');
                    $('#submitAjax').prop( "disabled", false );
                },
                success: function(data){
                    $('#json-renderer').val(JSON.stringify(data));

                },

                error: function (request, error) {
                    if(request.status == 422 || request.status == 400){
                        for (let prop in request.responseJSON.errors) {
                            $('#alert-errors').append( '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show"> <span class="badge badge-pill badge-danger">Ошибка</span> '+request.responseJSON.errors[prop]+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>')
                        }
                    }
                    else {
                        $('#result_error').removeClass('displayNone');
                        $('#result_error .content_alert').html("Ошибка " + request.status+": <p>"+request.responseText+"</p>");
                    }

                },
            });
        }, 200);
    })
</script>
<style>

    #json-renderer {
        width: 700px;
        height: 700px;
    }
    input {
        margin-bottom: 10px;
        max-width: 400px;
    }

    textarea {
        width: 100%;
        overflow-y: scroll;
        resize: none;

    }
    .xml {
        width: 100%;
    }

    h1 {
        margin-bottom: 40px;
        text-align: center;
    }
    label {
        font-weight:600;
    }

    #result_success {
        border: 1px solid green;
    }

    #result_error {
        border: 1px solid red;
    }
    .displayNone {
        display: none;
    }

    .result {
        margin-top: 10px;
    }

    .result-response {
        min-height: 50px;
    }
</style>

</body>

</html>
<!-- end document-->

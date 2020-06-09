<!doctype html>
<html>
<head>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('assets/lib/codemirror.js') }}"></script>
    <script src="{{ asset('assets/mode/xml/xml.js') }}"></script>
{{--    <link rel="stylesheet" href="lib/codemirror.css">--}}
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/codemirror.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/darcula.css') }}" rel="stylesheet">
{{--    <link rel="stylesheet" href="codemirror/theme/default.css">--}}
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Валидатор XSD</h1>{{--Загрузка архива--}}
            <form action = "{{url("validator")}}"  method="post" enctype="multipart/form-data" id="validatorXsd">
                {{--    @csrf--}}
                <div class="form-group">
                    <label for="xsd">Архив с XSD</label>
                    <input id="xsdFile" type="file" class="form-control-file" name="zip">
                </div>
                <div class="form-group">
                    <label for="xml-field">XML для проверки</label>
                    <div class="xml">
                        <textarea name="xml" id="xml-field"></textarea>
                    </div>
                </div>
                <div class="form-group">
                <label for="xsdName">Название корневой xsd в архиве</label>
                   <input type="text" class="form-control" id="#xsdName" name="main-xsd">
                </div>
                <button type="button" id="submitAjax" class="btn btn-primary">Проверить</button>

            </form>
            <div id="result_success" class="result displayNone"></div>
            <div id="result_error" class="result displayNone"></div>
        </div>
    </div>
</div>


<script src="{{ asset('js/lib/jQuery.js') }}"></script>
<script>
    let myCodeMirror = CodeMirror.fromTextArea(document.getElementById('xml-field'), {
        lineNumbers: true,               // показывать номера строк
        matchBrackets: true,             // подсвечивать парные скобки
        mode: 'application/xml', // стиль подсветки
        indentUnit: 4                    // размер табуляции
    });


    $('#submitAjax').click(function () {
        $('.result').empty();
        $('.result').addClass('displayNone');
        let data = new FormData();
        data.append('xml', myCodeMirror.getValue());
        data.append('main-xsd', $("input[name='main-xsd']").val());
        data.append('zip', $('input[type=file]')[0].files[0]);
        $.ajax({
            type: 'POST',
            url: '{{url("validator")}}',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            data: data,
            success: function(data){
                // let result =jQuery.parseJSON( data);
                if(data.status == true) {
                    $('#result_success').removeClass('displayNone');
                    $('#result_success').html(data.message);
                }
                else {
                    $('#result_error').removeClass('displayNone');
                    $('#result_error').html(data.message+"<p>"+data.errors+"</p>");
                }

            },

            error: function (request, error) {
                console.log(arguments);
                alert(" Ошибка: " + request.responseText);
            },
        });

    })
</script>
<style>
    input {
        margin-bottom: 10px;
        max-width: 400px;
    }

    textarea {
        width: 100%;
        height: 500px;
        overflow-y: scroll;
        resize: none; /* Remove this if you want the user to resize the textarea */

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
        border-radius: 5px;
        padding: 5px;
    }
</style>
</body>

</html>



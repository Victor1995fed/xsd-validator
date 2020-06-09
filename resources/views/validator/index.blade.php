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

<div class="container float-left">
    <div class="row">
        <div class="col-md-12">
            <h1>Валидатор XSD</h1>{{--Загрузка архива--}}
            <form action = "{{url("validator")}}"  method="post" enctype="multipart/form-data">
                {{--    @csrf--}}
                <label for="xsd">Архив с XSD</label><br>
                <input type="file" name="zip"><br>
                <div class="xml">
                    <textarea name="xml" id="xml-field"></textarea><br>
                </div>
                <label for="main-xsd">Название файла с корневой   xsd в архиве</label><br>
                <input type="text" name="main-xsd"><br>
                <button type="submit" class="btn btn-primary">Проверить</button>
            </form></div>
    </div>
</div>



<script>
    var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('xml-field'), {
        lineNumbers: true,               // показывать номера строк
        matchBrackets: true,             // подсвечивать парные скобки
        mode: 'application/xml', // стиль подсветки
        indentUnit: 4                    // размер табуляции
    });

</script>
<style>
    input {
        margin-bottom: 10px;
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
</style>
</body>

</html>



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
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Валидатор XML по XSD</h1>{{--Загрузка архива--}}
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
                <button class="btn btn-primary" id="submitAjax" type="button">
                    <span class="spinner-border spinner-border-sm displayNone" role="status" aria-hidden="true"></span>
                    Проверить
                </button>

            </form>
          <div class="result-response">

<div class="alert alert-success result displayNone" role="alert" id="result_success" >
</div>
            <div class="alert alert-danger result displayNone" role="alert" id="result_error" >

</div>
        </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/lib/jQuery.js') }}"></script>
<script>
    const markers = [];
    function highlightText(myCodeMirror, line)
    {
        let lineInside = line - 1
        let tokens = myCodeMirror.getLineTokens(1, true);
        let start = CodeMirror.Pos(lineInside, tokens[0].start);
        let end = CodeMirror.Pos(lineInside, tokens[0].end);
        let markOptions =
            {
                css: "background-color: #f9d6d5"
            };
        markers.push(myCodeMirror.markText(start, end, markOptions));
    }
    let myCodeMirror = CodeMirror.fromTextArea(document.getElementById('xml-field'), {
        lineNumbers: true,
        matchBrackets: true,
        mode: 'application/xml',
        indentUnit: 4
    });

    $('.result').on('click', '.highlight-text', function() {
        let line = Number($(this).text()) - 1
        myCodeMirror.setCursor( line,0)
    });
    myCodeMirror.setSize(null, "550px");
    $('#submitAjax').click(function () {
        myCodeMirror.setValue(myCodeMirror.getValue().trim())
        markers.forEach(marker => marker.clear());
        $('.result').empty();
        $('.result').addClass('displayNone');
        let data = new FormData();
        data.append('xml', myCodeMirror.getValue());
        data.append('main-xsd', $("input[name='main-xsd']").val());
        data.append('zip', $('input[type=file]')[0].files[0]);
        $('.spinner-border').removeClass('displayNone');
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '{{url("validator")}}',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                data: data,
                complete: function() {
                        $('.spinner-border').addClass('displayNone');
                },
                success: function(data){
                    if(data.status == true) {
                        $('#result_success').removeClass('displayNone');
                        $('#result_success').html(data.message);
                    }
                    else {
                        $('#result_error').removeClass('displayNone');
                        let html = ''
                        let i = 1
                        for (var key in data.errors) {
                            highlightText(myCodeMirror, Number(data.errors[key].line))
                            html = html + '<p>'+i+'. Ошибка: '+data.errors[key].code+' '+data.errors[key].message+' Строка: '+'<a href="#" class="highlight-text">'+data.errors[key].line+'</a></p>'
                            i++
                        }
                        $('#result_error').html(html);
                    }

                },

                error: function (request, error) {
                    $('#result_error').removeClass('displayNone');
                    $('#result_error').html("Ошибка " + request.status+": <p>"+request.responseText+"</p>");
                },
            });
        }, 200);
    })
</script>
<style>
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



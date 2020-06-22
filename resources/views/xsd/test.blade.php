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
                            <h1 class="title-4">Тестирование <mark >{{$xsd->title}}</mark></h1>
                            <hr class="line-seprate">
                        </div>
                        <form action = "{{url("validator")}}"  method="post" enctype="multipart/form-data" id="validatorXsd">
                            {{--    @csrf--}}
                            <div class="form-group">
                                <label for="xsd">Архив с XSD</label>
                                <input type="text" disabled value="{{$xsd->files[0]->title ?? ''}}" class="form-control" id="#xsdName" name="main-xsd">
{{--                                <input id="xsdFile" disabled class="form-control-file" name="zip">--}}
                            </div>
                            <div class="form-group">
                                <label for="xsdName">Название корневой xsd в архиве</label>
                                <input type="text" disabled value="{{$xsd->root_xsd}}" class="form-control" id="#xsdName" name="main-xsd">
                            </div>
                            <div class="form-group">
                                <label for="xml-field">XML для проверки</label>
                                <div class="xml">
                                    <textarea name="xml" id="xml-field"></textarea>
                                </div>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Copyright © 2018 Colorlib. Все права защищены. Использовался шаблон от <a href="https://colorlib.com">Colorlib</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
@include('layouts.scripts')
<script>
    $("#validatorXsd").keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    })
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
        data.append('_token', '{{ csrf_token() }}');
        $('.spinner-border').removeClass('displayNone');
        $('#submitAjax').prop( "disabled", true );
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '{{url("xsd/test/$xsd->id")}}',
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
                    if(data.status == true) {
                        $('#result_success').removeClass('displayNone');
                        $('#result_success').html(data.message);
                    }
                    else {
                        $('#result_error').removeClass('displayNone');
                        let html = ''
                        let i = 1
                        let line = '';
                        for (var key in data.errors) {
                            if(data.errors[key].line == "-1") {
                                line = '';
                            }
                            else {
                                line = 'Строка: <a href="#" class="highlight-text">'+data.errors[key].line+'</a>';
                            }
                            highlightText(myCodeMirror, Number(data.errors[key].line))
                            html = html + '<p>'+i+'. Ошибка: '+data.errors[key].code+' '+data.errors[key].message+line+'</p>'
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
<!-- end document-->

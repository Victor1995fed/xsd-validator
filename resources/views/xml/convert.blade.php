<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('assets/json-viewer/jquery.json-viewer.css')}}">
</head>
<body class="animsition">
<h1>Convert</h1>
<textarea id="xml"></textarea> <br>
<button id="get" type="button">get</button>
<pre id="json-renderer"></pre>

<div id="result">

</div>
<script src="{{asset('assets/vendor/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/json-viewer/jquery.json-viewer.js')}}"></script>
<script>
    // const myData = {
    //     "name":"John",
    //     "age":30,
    //     "cars": {
    //         "car1":"Ford",
    //         "car2":"BMW",
    //         "car3":"Fiat"
    //     }
    // };

    // $('#example').html(prettyPrintJson.toHtml(myData));

    function recur( my_array ){
        if ( my_array && typeof my_array === "object" && Object.prototype.toString.call( my_array ) === "[object Object]" ) {
            for (let Name in my_array) {
                // document.write(Name + " = " + recur( my_array[Name] ) + "<br>");
            }
        } else {
            return my_array;
        }
    }

$("#get").click(function (){
    let dataXml = $('#xml').val();
    $("#result").empty()
    $.ajax({
        type: 'POST',
        url: '{{url("xml/get/format")}}'+'?format=php_array&set_value=null&clear_value=1',
        enctype: 'application/xml',
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        data: dataXml,
        complete: function() {

        },
        success: function(data){
            console.warn(data)
            $('#json-renderer').jsonViewer(data, { withQuotes: true});

        },
        error: function (request, error) {

        },
    });
});
</script>


{{--    <script>--}}
{{--   --}}
{{--    recur({--}}
{{--        "lev1": {--}}
{{--            "lev2": {--}}
{{--                "lev3": {--}}
{{--                    "lev4": "test"--}}
{{--                }--}}
{{--            }--}}
{{--        },--}}
{{--        "alev1": {--}}
{{--            "alev2": {--}}
{{--                "alev3": {--}}
{{--                    "alev4": null--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}


<style>
    textarea {
        width: 900px;
        height: 800px;
    }
</style>
</body>

</html>

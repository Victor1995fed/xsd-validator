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
<button onclick="copyTextElem('json-renderer')">Copy text</button>
<div id="result">

</div>
<script src="{{asset('assets/vendor/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/json-viewer/jquery.json-viewer.js')}}"></script>
<script src="{{asset('assets/json-viewer/jquery.php-array-viewer.js')}}"></script>
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

$("#get").click(function (){
    let dataXml = $('#xml').val();
    $("#result").empty()
    $.ajax({
        type: 'POST',
        url: '{{url("xml/get/format")}}'+'?format=php_array&set_value=Helper::checkVal($OS, \'null\')&clear_value=1',
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
            $('#json-renderer').renderPhpArray(data,{ withQuotes: true})

        },
        error: function (request, error) {

        },
    });
});


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
</script>


<style>
    textarea {
        width: 900px;
        height: 800px;
    }
</style>
</body>

</html>

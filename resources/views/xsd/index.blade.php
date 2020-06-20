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
            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                <i class="zmdi zmdi-plus"></i>Добавить схему</button>
        </div>

    </div>
@include('layouts.scripts')

</body>

</html>

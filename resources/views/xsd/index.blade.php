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
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Список  XSD</h3>
                <div class="table-data__tool">
{{--                    <div class="table-data__tool-left">--}}
{{--                        <div class="rs-select2--light rs-select2--md">--}}
{{--                            <select class="js-select2" name="property">--}}
{{--                                <option selected="selected">All Properties</option>--}}
{{--                                <option value="">Option 1</option>--}}
{{--                                <option value="">Option 2</option>--}}
{{--                            </select>--}}
{{--                            <div class="dropDownSelect2"></div>--}}
{{--                        </div>--}}
{{--                        <div class="rs-select2--light rs-select2--sm">--}}
{{--                            <select class="js-select2" name="time">--}}
{{--                                <option selected="selected">Today</option>--}}
{{--                                <option value="">3 Days</option>--}}
{{--                                <option value="">1 Week</option>--}}
{{--                            </select>--}}
{{--                            <div class="dropDownSelect2"></div>--}}
{{--                        </div>--}}
{{--                        <button class="au-btn-filter">--}}
{{--                            <i class="zmdi zmdi-filter-list"></i>filters</button>--}}
{{--                    </div>--}}
                    <div class="table-data__tool-right float-right">
                        <a href="{{url('xsd/create')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>Добавить схему</a>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                        <tr>
                            <th>
                                <label class="au-checkbox">
                                    <input type="checkbox">
                                    <span class="au-checkmark"></span>
                                </label>
                            </th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Обновлено</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($xsd as $xsdOne)
                            <tr class="tr-shadow">
                                <td>
                                    <label class="au-checkbox">
                                        <input type="checkbox">
                                        <span class="au-checkmark"></span>
                                    </label>
                                </td>
                                <td>{{$xsdOne->title}}</td>

                                <td>{{mb_strimwidth($xsdOne->description, 0, 40, "...")}}</td>
                                <td>{{$xsdOne->created_at}}</td>
                                <td>
                                    <div class="table-data-feature">
                                        <a href="{{url("xsd/test").'/'.$xsdOne->id}}"  class="item test" data-toggle="tooltip" data-placement="top" title="" data-original-title="Тестировать xml">
                                            <i class="fa fa-code"></i>
                                        </a>
                                        <a href="{{url("xsd").'/'.$xsdOne->id}}"  class="item see" data-toggle="tooltip" data-placement="top" title="" data-original-title="Посмотреть">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{url("xsd").'/'.$xsdOne->id.'/edit'}}"  class="item change" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить">
                                            <i class="fa fa-cog"></i>
                                        </a>
                                        <a href="#"  class="item delete" data-xsd-id= "{{$xsdOne->id}}"  data-toggle="modal" data-placement="top" title="" data-original-title="Удалить"   data-target="#deleteModal">
                                            <i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
                <!-- END DATA TABLE -->
            </div>
            @if($xsd->lastPage() > 1)
            <div class="col-md-12">
                <nav  class="pagination">
                    <ul class=" pagination justify-content-center">
                                                <li class="page-item  {{($xsd->currentPage() == 1 ? 'disabled' : '')}}">
                                                    <a class="page-link" href="{{url('/xsd?page=').($xsd->currentPage() - 1)}}" tabindex="-1"><</a>
                                                </li>
                        @for($i = 1; $i <= $xsd->lastPage(); $i++  )
                                                    @if($xsd->currentPage() == $i)
                                                    <li class="page-item active"><a class="page-link" href="{{url("/xsd?page=$i")}}">{{$i}}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{url("/xsd?page=$i")}}">{{$i}}</a></li>
                                                    @endif

                        @endfor
                        <li class="page-item {{($xsd->currentPage() == $xsd->lastPage() ? 'disabled' : '')}}" >
                                                    <a class="page-link"  href="{{url('/xsd?page=').($xsd->currentPage() + 1)}}"> > </a>
                                                </li>

                    </ul>
                </nav>
             </div>
            @endif
        </div>

        @include('layouts.modal-delete',['text' => "Вы точно хотите удалить?"])

    </div>
    <style>
        .table-data-feature a.delete i  {
            color: #f00;

        }
        .table-data-feature a.see i  {
            color: #63c76a;
        }
         .table-data-feature a.change i  {
             color: #3490dc;
        }
        .pagination {
            margin-top: 1px;
        }

    </style>
@include('layouts.scripts')
    <script>
        let removeAgree = $('#agree')
        $(".delete").click(function() {
            let xsdId = $(this).attr('data-xsd-id')
            removeAgree.attr('action','{{url('/xsd/')}}/'+xsdId)
        });
    </script>
</body>

</html>

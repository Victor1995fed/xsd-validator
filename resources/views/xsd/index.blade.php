<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
@include('layouts.header-mobile')
<!-- END HEADER MOBILE-->

    <!-- END MENU SIDEBAR-->
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
                    @if(count($xsd) > 0)
                        <table class="table table-data2">
                            <thead>
                            <tr>
                                <th>
                                    <label class="au-checkbox">
                                        <input type="checkbox">
                                        <span class="au-checkmark"></span>
                                    </label>
                                </th>
                                {{--                            {{$sortName = Request::get('sort')}}--}}
                                {{--                            {{$sortType = Request::get('sort')}}--}}
                                <th> <a class="sort-link" data-name="title" href="#" data-sort-type="asc">Название</a><span class="html-content"></span></th>
                                <th> <a class="sort-link" data-name="description" href="#" data-sort-type="asc">Описание</a> <span class="html-content"></span></th>
                                <th> <a class="sort-link" data-name="updated_at" href="#" data-sort-type="asc">Обновлено</a> <span class="html-content"></span></th>
                                <th>Дополнительно</th>
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
                                       <p>Опубликовано: {{$xsdOne->public == 1 ? 'Да': 'Нет'}}</p>
                                       <p>Метки:
                                           @foreach($xsdOne->tags as $tagOne)
                                               <a href="#">{{$tagOne->title}}</a>
                                           @endforeach
                                           </p>

                                    </td>
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
                    @else
                        <p>Ничего не найдено</p>
                    @endif
                </div>
                <!-- END DATA TABLE -->
            </div>
            @if($xsd->lastPage() > 1)
            <div class="col-md-12">
                <nav  class="pagination">
                    <ul class=" pagination justify-content-center">
                                                <li class="page-item  {{($xsd->currentPage() == 1 ? 'disabled' : '')}}">
                                                    <a class="page-link" href="{{Request::url().'?page='.($xsd->currentPage() - 1)}}" tabindex="-1"><</a>
                                                </li>
                        @for($i = 1; $i <= $xsd->lastPage(); $i++  )
                                                    @if($xsd->currentPage() == $i)
                                                    <li class="page-item active"><a class="page-link" href="{{url("/xsd?page=$i")}}">{{$i}}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{Request::url()."?page=$i"}}">{{$i}}</a></li>
                                                    @endif

                        @endfor
                        <li class="page-item {{($xsd->currentPage() == $xsd->lastPage() ? 'disabled' : '')}}" >
                                                    <a class="page-link"  href="{{Request::url().'?page='.($xsd->currentPage() + 1)}}"> > </a>
                                                </li>

                    </ul>
{{--                    TODO:: Допилить указание сортировки при переходе между страницами--}}
                </nav>
             </div>
            @endif
        </div>

        @include('layouts.modal-delete',['textHeader' => "Вы точно хотите удалить?", 'textBody'=>"XSD будет удалена безвозвратно"])

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
        @if(isset($params['sortType'],$params['sortAttr']) && $params['sortType'] !== null && $params['sortAttr'] !== null)
            let sortType = '{{$params['sortType']}}'
            let sortAttr = '{{$params['sortAttr']}}'
            let sortHtml = '&#8659;'
        if(sortType == 'desc'){
             sortHtml = '&#8657;'
        }

        $('a[data-name='+sortAttr+']').attr('data-sort-type',sortType);
        $('a[data-name='+sortAttr+']').siblings('.html-content').html(sortHtml);
        @endif
        let removeAgree = $('#agree')
        $(".delete").click(function() {
            let xsdId = $(this).attr('data-xsd-id')
            removeAgree.attr('action','{{url('/xsd/')}}/'+xsdId)
        });

        $(".sort-link").click(function (e) {
            e.preventDefault()
            let  url   = window.location.pathname;
            let typeSort = changeTypeSort($(this).attr('data-sort-type'))
            let page = getUrlParameter('page');
            page = page === undefined ? '' : '&page='+page
            // debugger
            $(this).attr('href',url+'?sort='+typeSort+$(this).attr('data-name')+page)
            window.location.href=$(this).attr('href');
        })

        function changeTypeSort(typeSort) {
            if(typeSort == 'asc')
                return '-'
            else
                return ''
        }

        function getUrlParameter(sParam) {
            let sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };
    </script>
</body>

</html>

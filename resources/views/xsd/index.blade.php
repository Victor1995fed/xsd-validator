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
                    <div class="table-data__tool-left">
                        <div class="rs-select2--light rs-select2--md" id="tags-select">
                            <select class="js-select2" name="tagsSelect">
                                <option {{(Request::get('tag')   == null) ? "selected=\"selected\"" : '' }} value="0">Все метки</option>
                                @foreach($tags as $tag)
                                    <option {{(Request::get('tag')   == $tag->id) ? "selected=\"selected\"" : '' }} value="{{$tag->id}}">{{$tag->title}}</option>
                                @endforeach
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                        @if (Auth::check())
                        <div class="rs-select2--light rs-select2--md">
                            <select class="js-select2" name="typeXsdSelect">
                                <option {{(Request::get('page')   == null) ? "selected=\"selected\"" : '' }} value="0">Все</option>
                                <option {{(Request::get('user_id')   == Auth::id()) ? "selected=\"selected\"" : '' }} value="{{Auth::id()}}">Мои</option>
                                <option {{(Request::get('public')   == 1) ? "selected=\"selected\"" : '' }} value="public">Опубликованные</option>
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                        @endif
                        <button class="au-btn-filter" id="applyFilter">
                            <i class="zmdi zmdi-filter-list"></i>Применить</button>
                    </div>
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
                                <th> <a class="sort-link" data-name="title" href="{{Request::url()}}" data-sort-type="asc">Название</a><span class="html-content"></span></th>
                                <th> <a class="sort-link" data-name="description" href="{{Request::url()}}" data-sort-type="asc">Описание</a> <span class="html-content"></span></th>
                                <th> <a class="sort-link" data-name="updated_at" href="{{Request::url()}}" data-sort-type="asc">Обновлено</a> <span class="html-content"></span></th>
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
                                               <a href="{{url("xsd").'?tag='.$tagOne->id}}"> #{{$tagOne->title}} </a>
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
                </nav>
             </div>
            @endif
        </div>

        @include('layouts.modal-delete',['textHeader' => "Вы точно хотите удалить?", 'textBody'=>"XSD будет удалена безвозвратно"])

    </div>
    <script src="{{asset('js/filters/helper.js')}}"></script>
    <style>
        #tags-select {
            width: 260px!important;
        }

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


    // let urlParamsNew = getUrlVars()
    // let objFilter = new XsdFilter(urlParamsNew)
    // //Применить фильтры
    // objFilter.apply()
//TODO:: Улучшить код, написать отдельные функции-класс для фильтрации
//    ***************************
let urlParams = getUrlVars()
let sortData = getSort(urlParams)
if(sortData){
    let sortTitle = sortData.title.replace(/-/g, "")
    let sortHtml = '&#8659;'
    if(sortData.type == 'desc'){
        sortHtml = '&#8657;'
    }
    $('a[data-name='+sortTitle+']').attr('data-sort-type',sortData.type);
    $('a[data-name='+sortTitle+']').siblings('.html-content').html(sortHtml);
}

//Заполнение ссылок навигации параметрами, которые переданы в url
delete urlParams["page"];
$('a.page-link').map(function(){
    for (let prop in urlParams) {
        let curentHref = $(this).attr('href')
        $(this).attr('href',curentHref+'&'+prop+'='+urlParams[prop])
    }
});

//Заполнение ссылок сортировки параметрами, которые переданы в url
delete urlParams["sort"];
 $('a.sort-link').map(function(){
     let first = true
    for (let prop in urlParams) {
        let currentHref = $(this).attr('href')
        if(first){
            $(this).attr('href',currentHref+'?'+prop+'='+urlParams[prop])
        }
        else{
            $(this).attr('href',currentHref+'&'+prop+'='+urlParams[prop])
        }
        first = false
    }
});

let removeAgree = $('#agree')
$(".delete").click(function() {
    let xsdId = $(this).attr('data-xsd-id')
    removeAgree.attr('action','{{url('/xsd/')}}/'+xsdId)
});

//Обработка события по клику на элимент сортировки
$(".sort-link").click(function (e) {
    e.preventDefault()
    let typeSort = changeTypeSort($(this).attr('data-sort-type'))
    let page = getUrlParameter('page');
    page = page === undefined ? '' : '&page='+page
    let currentUrl = $(this).attr('href')
    let dop = '&'
    if($.isEmptyObject(urlParams))
        dop = '?'
    $(this).attr('href',currentUrl+dop+'sort='+typeSort+$(this).attr('data-name')+page)
    window.location.href=$(this).attr('href');
})

//Событие при нажатии кнопки применить
    $('#applyFilter').click(function (e) {
        // let urlParams = getUrlVars()
        let pathUrl = window.location.pathname
        //Добавление параметров и отправка
        let typeXsdSelect = $('select[name="typeXsdSelect"]').val()
        let tagsSelect = $('select[name="tagsSelect"]').val()
        let arrListParams = []
        switch (typeXsdSelect) {
            case('public'):
                arrListParams['public'] = 1;
                break;

            case('0'):
                break;
            case(undefined):

                break;
            default:
                arrListParams['user_id'] = typeXsdSelect;
                break;
        }

        if(tagsSelect != 0) {
            arrListParams['tag'] = tagsSelect
        }
        let first = true
        for (let prop in arrListParams) {
            if(first){
                pathUrl = pathUrl+'?'+prop+'='+arrListParams[prop]
            }
            else{
                pathUrl = pathUrl+'&'+prop+'='+arrListParams[prop]
            }
            first = false
        }
        window.location.href=pathUrl;
    })


    </script>
</body>

</html>

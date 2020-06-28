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
                        <div class="rs-select2--light rs-select2--md">
                            <select class="js-select2" name="property">
                                <option value="0" selected="selected">Все метки</option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->title}}</option>
                                @endforeach
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                        @if (Auth::check())
                        <div class="rs-select2--light rs-select2--md">
                            <select class="js-select2" name="property">
                                <option selected="selected">Все</option>
                                <option value="{{Auth::id()}}">Мои</option>
                                <option value="">Опубликованные</option>
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                        @endif
                        <button class="au-btn-filter">
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
                                               <a href="#"> #{{$tagOne->title}} </a>
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
let urlParams = getUrlVars()
//Добавление стрелок в зависимости от типа сортировки
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

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    let vars = [], hash;
    let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    if(hashes[0] == window.location.href || hashes[0] == '')
        return []
    for(let i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        // vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return  vars;
}

function getSort(urlParams) {
    let objSort = {}
    if ('sort' in urlParams && typeof urlParams['sort'] == 'string'){
        objSort.title = urlParams['sort']
        objSort.type = getTypeSort(urlParams['sort'])
        return objSort;
    }
    else
        return false
}

function getTypeSort(str) {
   return (str[0] == '-') ? 'desc' : 'asc'
}

//TODO::Переписать все со входом в единственную функцию по генерации url
function genUrl(except) {
    let pathUrl = window.location.pathname
    let urlParams = getUrlVars()
    if(except !== undefined){
        delete urlParams[except];
    }
    for (let prop in urlParams) {
        let first = true
        if(first){
            pathUrl = pathUrl+'?'+prop+'='+urlParams[prop]
        }
        else {
            pathUrl = pathUrl+'&'+prop+'='+urlParams[prop]
        }
        first = false
    }
    return pathUrl
}

    </script>
</body>

</html>

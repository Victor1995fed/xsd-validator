<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
@include('layouts.header-mobile')
<!-- END HEADER MOBILE-->

    <!-- PAGE CONTAINER-->
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
    @include('layouts.header-desktop')
    <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="col-md-12">
                <h3 class="title-5 m-b-35">Метки</h3>
                <div class="card">
                    <div class="card-header">
                        <strong>Список доступных меток </strong>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($tag as $tagOne)
                                <li class="list-group-item">#<a href="{{url("xsd?tag=$tagOne->id")}}">{{$tagOne->title}}</a>   <a href="#"  class="item change" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить">
                                        <i class="fa fa-cog"></i>
                                    </a>
                                    <a href="#"  class="item delete" data-tag-id= "{{$tagOne->id}}"  data-toggle="modal" data-placement="top" title="" data-original-title="Удалить"   data-target="#deleteModal">
                                        <i class="zmdi zmdi-delete"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="table-data__tool-right float-right">
                    <a href="#" data-toggle="modal" data-placement="top" title="" data-original-title="Создать"   data-target="#createTagModal" class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>Добавить метку</a>
                </div>
            </div>
        </div>

        @include('layouts.modal-delete',['textHeader' => "Вы точно хотите удалить?", 'textBody'=>'Метка будет удалена, привязанные к ней данные не будут тронуты'])
        @include('layouts.modal-create-tag',['textHeader' => "Создание метки", 'textBody'=>''])

    </div>
    <style>
        .list-group a.delete i  {
            color: #f00;

        }
        .list-group a.see i  {
            color: #63c76a;
        }
        .list-group a.change i  {
            color: #3490dc;
        }

    </style>
@include('layouts.scripts')
    <script>
        let removeAgree = $('#agree')
        $(".delete").click(function() {
            let tagId = $(this).attr('data-tag-id')
            removeAgree.attr('action','{{url('/tag/')}}/'+tagId)
        });
    </script>
</body>

</html>

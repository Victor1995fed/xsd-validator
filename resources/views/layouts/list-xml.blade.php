@if(count($xsd->xml) > 0)

    @foreach ($xsd->xml as $xml)
        @if(isset($type) && $type = 'test-page')
            <?php $buttonsAdd = '<button type="button" data-id="'.$xml->id.'" class="item btn-sm upload-xml" data-toggle="tooltip" data-original-title="Загрузить"><i class="fa fa-upload"></i></button>' ?>

        @else
            <?php $buttonsAdd = '<button type="button" data-id="'.$xml->id.'" class="item btn-sm remove-xml-link" data-toggle="tooltip" data-original-title="Удалить"><i class="fa fa-times"></i></button>' ?>
        @endif
        {{--                                        TODO:: Дублирование кода--}}
        <div class="xml-link-div-{{$xml->id}}">
            <a href="#" class="xml-link" data-id={{$xml->id}} data-title="{{$xml->title}}">{{$xml->title}}<textarea style="display:none;" class="content-xml" type=hidden name=xml-content disabled="disabled" >{{$xml->content}}</textarea><input class="id-xml" type=hidden name=xml[] value="{{$xml->id}}"></a>{!! $buttonsAdd !!}
        </div>
    @endforeach
@endif

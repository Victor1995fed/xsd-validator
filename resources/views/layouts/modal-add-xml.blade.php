<!-- modal scroll -->

<link href="{{ asset('assets/lib/codemirror.css') }}" rel="stylesheet">
<link href="{{ asset('assets/theme/darcula.css') }}" rel="stylesheet">
<script src="{{ asset('assets/lib/codemirror.js') }}"></script>
<script src="{{ asset('assets/mode/xml/xml.js') }}"></script>

<div class="modal fade" id="XmlModal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавьте текст xml</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url("xml")}}" id="createXmlForm">
                    @csrf
                    @method('POST')
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="title" class=" form-control-label">Название xml</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="title" name="title"  class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col col-md-3">
                            <label for="content" class=" form-control-label">Контент</label>
                        </div>
                        <div class="xml">
                            <textarea name="content" id="xml-field"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary create-xml-send" form="createXmlForm">Добавить</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/views/layouts/modal-add-xml.js') }}"></script>



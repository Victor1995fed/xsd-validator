<div class="modal fade" id="updateTagModal" tabindex="-1" role="dialog" aria-labelledby="updateTagModalLabel" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTagModalLabel">{{$textHeader}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                  <form method="post" action="{{url("tag")}}" id="updateForm">
                      @csrf
                      @method('PUT')
                      <div class="row form-group">
                          <div class="col col-md-12">
                              <label for="title" class=" form-control-label">Название</label>
                          </div>
                          <div class="col-12 col-md-9">
                              <input type="text" id="title"  name="title"  class="form-control">
                          </div>
                      </div>
                  </form>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" form="updateForm" class="btn btn-success">Изменить</button>
            </div>
        </div>
    </div>
</div>

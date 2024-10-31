<div class="modal fade" id="metaModal" tabindex="-1" aria-labelledby="metaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="metaModalLabel">Meta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formMeta">
            <input type="hidden" value="{{$typeId}}" name="page_id">
            <div class="form-group">
                <label for="name">Title: </label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Description: </label>
                <textarea type="text" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="name">Keyword: </label>
                <input type="text" name="keyword" class="form-control">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSubmitMeta">Submit</button>
      </div>
    </div>
  </div>
</div>

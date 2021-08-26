<div class="modal" id="confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal_header"></h4>
            </div>
            <div class="modal-body">
                <p id="modal_content"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" id="delete-btn">{!! trans('app.btn.delete') !!}</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{!! trans('app.btn.cancel') !!}</button>
            </div>
        </div>
    </div>
</div>
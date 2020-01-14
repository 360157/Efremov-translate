<div id="groupDeleteModal" class="modal fade">
    <input type="hidden" name="_method" value="PATCH" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Attention</h4>
                <button class="close" type="button" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Ви дійсно бажаєте видалити групу перекладів?<br>* Дану дію не можна буде відмінити.</p>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary"><i class="icon-trash"></i>  @lang('main.delete')</button>
                    <button type="button" class="btn btn-danger" name="cancel"><i class="icon-cancel-circle2"></i> @lang('main.cancel')</button>
                </div>
            </div>
        </div>
    </div>
</div>
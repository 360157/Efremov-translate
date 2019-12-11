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
                <div class="value-group">
                    <button type="submit" class="btn button btn-center">@lang('system::main.delete') <i class="icon-arrow-right14 position-right"></i></button>
                    <button type="button" class="btn button btn-center btn-red" name="cancel">@lang('system::main.cancel') <i class="icon-arrow-right14 position-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
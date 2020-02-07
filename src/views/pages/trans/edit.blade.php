<div id="keyEditModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="keyEditForm" action="{{ route('translate.translates.update', [ 'id' => 0 ]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH" />
                <input type="hidden" name="obj" value="key">
                <input id="id" type="hidden" name="id">
                <div class="modal-header">
                    <h4 class="modal-title">Edit key</h4>
                    <button class="close" type="button" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('main.key')</label>
                        <input type="text" name="key" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>@lang('main.description')</label>
                        <textarea name="description" class="form-control description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="update" value="update"><i class="icon-floppy-disk"></i> @lang('main.update')</button>
                        <button type="submit" class="btn btn-warning" name="delete" value="delete"><i class="icon-trash-alt"></i> @lang('main.delete')</button>
                        <button type="button" class="btn btn-danger" name="cancel"><i class="icon-cancel-circle2"></i> @lang('main.cancel')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="tranlateEditModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="tranlateEditForm" action="{{ route('translate.translates.update', [ 'id' => 0 ]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH" />
                <input type="hidden" name="obj" value="translate">
                <input type="hidden" name="key">
                <input type="hidden" name="lang">
                <div class="modal-header">
                    <h4 class="modal-title">Edit translation</h4>
                    <button class="close" type="button" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('main.translation')</label>
                        <textarea name="translation" class="form-control description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="status" value="2"><i class="icon-check"></i> @lang('main.verify')</button>
                        <button type="submit" class="btn btn-primary" name="status" value="1"><i class="icon-floppy-disk"></i> @lang('main.update')</button>
                        <button type="button" class="btn btn-danger" name="cancel"><i class="icon-cancel-circle2"></i> @lang('main.cancel')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
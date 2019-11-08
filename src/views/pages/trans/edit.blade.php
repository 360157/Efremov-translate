<div id="keyEditModal" class="modal fade">
    <form id="keyEditForm" action="{{ route('translate.translates.update', [ 'id' => 0 ]) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH" />
        <input type="hidden" name="obj" value="key">
        <input id="id" type="hidden" name="id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('system::main.key')</label>
                        <input type="text" name="key" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>@lang('system::main.description')</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary">@lang('system::main.update') <i class="icon-arrow-right14 position-right"></i></button>
                        <button type="submit" class="btn btn-danger action-delete">@lang('system::main.delete') <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="tranlateEditModal" class="modal fade">
    <form id="tranlateEditForm" action="{{ route('translate.translates.update', [ 'id' => 0 ]) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH" />
        <input type="hidden" name="obj" value="translate">
        <input type="hidden" name="key">
        <input type="hidden" name="lang">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('system::main.translation')</label>
                        <textarea name="translation" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary" name="status" value="1">@lang('system::main.save') <i class="icon-arrow-right14 position-right"></i></button>
                        <button type="submit" class="btn btn-success" name="status" value="2">@lang('system::main.verify') <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
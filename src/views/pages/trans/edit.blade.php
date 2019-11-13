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
                        <textarea name="description" class="form-control description"></textarea>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn button btn-icon"><div class="update-icon"></div>@lang('system::main.update') </button>
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
                        <textarea name="translation" class="form-control description"></textarea>
                    </div>
                    <div class="btn-center">                        
                        <button type="submit" class="button btn-light btn-icon" name="status" value="1"><div class="check-icon"></div>@lang('system::main.verify')</button>
                        <button type="submit" class="button btn-icon" name="status" value="2"><div class="update-icon"></div>@lang('system::main.save')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
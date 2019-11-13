<div id="langEditModal" class="modal fade">
    <form id="langEditForm" action="{{ route('translate.langs.update', [ 'id' => 0 ]) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit langs</h4>
                    <button class="close" type="button" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="value-group">
                            <input id="id" type="hidden" name="id" value="" class="form-control">
                            <div class="col-md-6">
                                <label>@lang('system::main.name')</label>
                                <input id="name" type="text" name="name" value="" class="lang-value">
                            </div>
                            <div class="col-md-6">
                                <label>@lang('system::main.index')</label>
                                <input id="index" type="text" name="index" value="" class="lang-value">
                            </div>
                        </div>
                    </div>
                    <div class="active-status-wrapper">
                        <input id="isActiveCheck" type="checkbox" name="is_active" value="1">               
                        <label>@lang('system::main.index')</label>                                               
                    </div>
                    <div class="value-group">
                        <button type="submit" class="btn button btn-center">@lang('system::main.save') <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
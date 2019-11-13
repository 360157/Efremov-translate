<form id="transCreateForm" action="{{ route('translate.translates.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="{{ $type }}" class="form-control full-width">
    <input type="hidden" name="group_id" value="{{ $group->id }}" class="form-control full-width">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>@lang('system::main.new_key')</label>
                <input type="text" placeholder="@lang('system::main.new_key')" name="key" value="" class="form-control full-width">
                {!! $errors->first('key', '<span class="help-block text-danger">:message</span>') !!}
            </div>
            <div class="col-md-6">
                <label>@lang('system::main.new_description')</label>
                <input type="text" placeholder="@lang('system::main.new_description')" name="description" value="" class="form-control">
                {!! $errors->first('description', '<span class="help-block text-danger">:message</span>') !!}
                <div class="text-right">
                    <button type="submit" class="btn button">@lang('system::main.create')<i class="icon-arrow-right14 position-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
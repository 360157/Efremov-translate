<form  id="groupCreateForm" action="{{ route('translate.groups.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                <label class="control-label" for="name">@lang('system::main.group')</label>
                <input type="text" name="name" value="" class="form-control">
                {!! $errors->first('name', '<span class="help-block text-danger">:message</span>') !!}

                <div class="text-left">
                    <button type="submit" class="btn btn-primary">@lang('system::main.create')<i class="icon-arrow-right14 position-right"></i></button>
                </div>
            </div>

        </div>
    </div>
</form>
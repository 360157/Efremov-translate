<div class="panel-body">
    <form id="transCreateForm" action="{{ route('translate.translates.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ $type }}" class="form-control full-width">
        <input type="hidden" name="group_id" value="{{ $group->id }}" class="form-control full-width">
        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>@lang('main.key')</label>
                    <input type="text" placeholder="@lang('main.new_key')" name="key" value="" class="form-control full-width">
                    {!! $errors->first('key', '<span class="help-block text-danger">:message</span>') !!}
                </div>
                <div class="col-md-5">
                    <label>@lang('main.description')</label>
                    <input type="text" placeholder="@lang('main.new_description')" name="description" value="" class="form-control">
                    {!! $errors->first('description', '<span class="help-block text-danger">:message</span>') !!}
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary align-bottom" name="status"><i class="icon-floppy-disk"></i> @lang('main.create')</button>
                </div>
            </div>
        </div>
    </form>
</div>
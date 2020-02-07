<div class="panel-body">
    <form id="groupCreateForm" action="{{ route('translate.groups.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                    <label class="control-label" for="name">@lang('main.group')</label>
                    <input type="text" name="name" value="" class="form-control">
                    {!! $errors->first('name', '<span class="help-block text-danger">:message</span>') !!}
                </div>
                <div class="col-md-6">
                    <div class="align-bottom">
                        <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk"></i> @lang('main.create')</button>
                        <button type="button" class="btn btn-warning" id="importGroup"><i class="icon-import"></i> @lang('main.import')</button>
                        <button type="button" class="btn btn-danger" id="restartType" data-type="{{ $type }}"><i class="icon-rotate-cw"></i> @lang('main.restart')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
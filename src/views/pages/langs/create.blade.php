<div class="panel-body">
    <form id="langCreateForm" action="{{ route('translate.langs.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <label>@lang('main.name')</label>
                    <input type="text" name="name" placeholder="@lang('main.name')" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>@lang('main.index')</label>
                    <input type="text" name="index" placeholder="@lang('main.index')" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>@lang('main.flag')</label>
                    <input type="text" name="flag" placeholder="@lang('main.flag')" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary align-bottom" name="status"><i class="icon-floppy-disk"></i> @lang('main.create')</button>
                </div>
            </div>
        </div>
    </form>
</div>
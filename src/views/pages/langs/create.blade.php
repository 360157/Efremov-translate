<div class="panel-body">
    <form id="langCreateForm" action="{{ route('translate.langs.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label>@lang('system::main.name')</label>
                    <input type="text" name="name" placeholder="@lang('system::main.name')" class="form-control">
                    {!! $errors->first('name', '<span class="help-block text-danger">:message</span>') !!}
                </div>
                <div class="col-md-5">
                    <label>@lang('system::main.index')</label>
                    <input type="text" name="index" placeholder="@lang('system::main.index')" class="form-control">
                    {!! $errors->first('index', '<span class="help-block text-danger">:message</span>') !!}
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">@lang('system::main.create')<i class="icon-arrow-right14 position-right"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
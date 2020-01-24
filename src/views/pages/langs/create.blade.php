<div class="panel-body">
    <form id="langCreateForm" action="{{ route('translate.langs.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <label>@lang('main.name')</label>
                    <select name="name" class="form-control">
                        <option>...</option>
                        @foreach($langs as $code => $lang)
                        <option value="{{ $lang[1] }}" data-code="{{ $code }}" data-flag="{{ strtoupper($lang[3]) }}" data-dir="{{ $lang[4] }}">{{ $lang[1] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>@lang('main.index')</label>
                    <input type="text" name="index" placeholder="@lang('main.index')" class="form-control">
                </div>
                <div class="col-md-2">
                    <label>@lang('main.flag')</label>
                    <select name="flag" class="form-control">
                        <option>...</option>
                        @foreach($flags as $code => $name)
                            <option value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>@lang('main.dir')</label>
                    <select name="dir" class="form-control">
                        <option value="ltr">ltr</option>
                        <option value="rtl">rtl</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>@lang('main.countries')</label>
                    <input type="text" name="countries" placeholder="@lang('main.countries')" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary align-bottom" name="status"><i class="icon-floppy-disk"></i> @lang('main.create')</button>
                </div>
            </div>
        </div>
    </form>
</div>
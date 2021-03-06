<div id="langEditModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="langEditForm" action="{{ route('translate.langs.update', [ 'id' => 0 ]) }}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Edit langs</h4>
                    <button class="close" type="button" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PATCH" />
                    <div class="form-group">
                        <input type="hidden" name="id" value="" class="form-control">
                        <input type="hidden" name="countries" value="" class="form-control">
                        <div class="row">
                            <div class="col-md-6">
                                <label>@lang('main.name')</label>
                                <input id="name" type="text" name="name" value="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>@lang('main.index')</label>
                                <input id="index" type="text" name="index" value="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>@lang('main.flag')</label>
                                <input id="flag" type="text" name="flag" value="" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>@lang('main.dir') <span class="badge badge-primary" title="@lang('main.changeTextDir')">?</span></label>
                                <select id="dir" name="dir" class="form-control">
                                    <option value="ltr">@lang('main.ltr')</option>
                                    <option value="rtl">@lang('main.rtl')</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>@lang('main.countries')</label>
                                <select id="country" class="form-control" multiple="multiple">
                                    <option value="*">Other</option>
                                    @foreach($countries as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_active" value="1">
                            @lang('main.is_active')
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_default" value="1">
                            @lang('main.is_default')
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="status"><i class="icon-floppy-disk"></i> @lang('main.update')</button>
                        <button type="button" class="btn btn-danger" name="cancel"><i class="icon-cancel-circle2"></i> @lang('main.cancel')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
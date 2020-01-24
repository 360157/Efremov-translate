@extends('translate::layouts.' . (config('translate.layout') ? 'empty' : 'main'))

@section('content_part')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a href="{{ url(config('translate.url.admin', 'admin')) }}">@lang('main.main_page')</a> /
                <a href="{{ route('translate.index') }}">@lang('main.translation')</a> /
                <span>@lang('main.languages')</span>
            </h5>
        </div>
        <div class="panel-content">
            @include('translate::pages.langs.create')

            <div class="panel-body">
                <table id="langTable" class="table table_wrapper hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th scope="col">@lang('main.id')</th>
                        <th scope="col">@lang('main.flag')</th>
                        <th scope="col">@lang('main.index')</th>
                        <th scope="col">@lang('main.name')</th>
                        <th scope="col">@lang('main.dir')</th>
                        <th scope="col">@lang('main.countries')</th>
                        <th scope="col">@lang('main.is_active')</th>
                        <th scope="col">@lang('main.is_default')</th>
                        <th scope="col">@lang('main.created_at')</th>
                        <th scope="col">@lang('main.updated_at')</th>
                        <th scope="col">@lang('main.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="btn-group aside">
        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon options"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-options">
                <div id="statusLink" class="field-wrapper">status</div>
                <div id="statusOptions">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="not-translated" value="">
                        <label class="form-check-label" for="not-translated">All</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="not-translated" value="yes">
                        <label class="form-check-label" for="not-translated">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="translated" value="no">
                        <label class="form-check-label" for="translated">Not active</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon find"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-find">
                <div class="field-wrapper">
                    <form id="langSearchForm">
                        <input type="text" placeholder="@lang('main.search')" class="find-field">
                        <button type="submit" class="button find-field">@lang('main.search')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('translate::pages.langs.edit')
    @include('translate::pages.langs.country')
@endsection
@section('translate-js')
    <script type='text/javascript'>
    $(function () {
        langApp.csrf = '{{ csrf_token() }}';
        langApp.url = {
            get:'{{ route('translate.langs.get') }}',
            store:'{{ route('translate.langs.store') }}',
            update:'{{ route('translate.langs.update') }}',
            destroy:'{{ route('translate.langs.destroy') }}',
        };
        langApp.dict = {
            edit:'@lang('main.edit')',
            delete:'@lang('main.delete')',
        };
        langApp.init();
    });
</script>
@endsection

@extends('translate::layouts.main')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a href="{{ url(config('translate.url', 'admin')) }}">@lang('system::main.main_page')</a> /
                <a href="{{ route('translate.index') }}">@lang('system::main.translation')</a> /
                <span>@lang('system::main.langs')</span>
            </h5>
        </div>
        <div class="panel-content">
            <div class="panel-body">
                @include('translate::pages.langs.create')
            </div>
                <table id="langTable" class="table table_wrapper hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th scope="col">@lang('system::main.id')</th>
                        <th scope="col">@lang('system::main.index')</th>
                        <th scope="col">@lang('system::main.name')</th>
                        <th scope="col">@lang('system::main.is_active')</th>
                        <th scope="col">@lang('system::main.created_at')</th>
                        <th scope="col">@lang('system::main.updated_at')</th>
                        <th scope="col">@lang('system::main.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </tr>
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
                        <input type="text" placeholder="@lang('system::main.search')" class="find-field">
                        <button type="submit" class="button find-field">@lang('system::main.search')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('translate::pages.langs.edit')
@endsection
@section('translate-js')
    <script type='text/javascript'>
    $(function () {
        langApp.url = {
            get:'{{ route('translate.langs.get') }}',
                store:'{{ route('translate.langs.store') }}',
                update:'{{ route('translate.langs.update') }}',
                destroy:'{{ route('translate.langs.destroy') }}',
        };
        langApp.dict = {
            edit:'@lang('system::main.edit')',
                delete:'@lang('system::main.delete')',
        };
        langApp.init();
    });
</script>
@endsection

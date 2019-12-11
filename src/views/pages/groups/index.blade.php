@extends('translate::layouts.main')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a href="{{ url(config('translate.url', 'admin')) }}">@lang('system::main.main_page')</a> /
                <a href="{{ route('translate.index') }}">@lang('system::main.translation')</a> /
                <span>@lang('system::main.'.$type.'-trans')</span>
            </h5>
        </div>
        <div class="panel-content">
            <div class="panel-body">
                @include('translate::pages.groups.create')

                <table id="groupTable" class="table table_wrapper hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">@lang('system::main.id')</th>
                            <th scope="col">@lang('system::main.group')</th>
                            <th scope="col">@lang('system::main.trans')/@lang('system::main.not_trans')</th>
                            <th scope="col">@lang('system::main.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="btn-group btn-group-one-element aside">
        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon find"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-find-groups">
                <div class="field-wrapper">
                    <form id="groupSearchForm">
                        <input type="text" placeholder="@lang('system::main.search')" class="find-field">
                        <button type="submit" class="button find-field">@lang('system::main.search')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('translate::pages.groups.delete')
@endsection
@section('translate-js')
<script type='text/javascript'>
    $(function () {
        groupApp.type = '{{ request()->type }}';
        groupApp.csrf = '{{ csrf_token() }}';
        groupApp.url = {
            index:'{{ route('translate.translates.index') }}',
                get:'{{ route('translate.groups.get') }}',
                store:'{{ route('translate.groups.store') }}',
                destroy:'{{ route('translate.groups.destroy') }}',
        };
        groupApp.dict = {
            delete:'@lang('system::main.delete')',
        };
        groupApp.init();
    });
</script>
@endsection

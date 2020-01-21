@extends('translate::layouts.' . (config('translate.layout') ? 'empty' : 'main'))

@section('content_part')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a href="{{ url(config('translate.url.admin', 'admin')) }}">@lang('main.main_page')</a> /
                <a href="{{ route('translate.index') }}">@lang('main.translation')</a> /
                <span>@lang('main.'.$type.'-trans')</span>
            </h5>
        </div>
        <div class="panel-content">
            @include('translate::pages.groups.create')

            <div class="panel-body">
                <table id="groupTable" class="table table_wrapper hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">@lang('main.id')</th>
                            <th scope="col">@lang('main.group')</th>
                            <th scope="col">@lang('main.trans')/@lang('main.not_trans')</th>
                            <th scope="col">@lang('main.actions')</th>
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
                        <input type="text" placeholder="@lang('main.search')" class="find-field">
                        <button type="submit" class="button find-field">@lang('main.search')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('translate::pages.groups.import')
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
            restart:'{{ route('translate.translates.restart') }}',
            import:'{{ route('translate.groups.import') }}',
            parse:'{{ route('translate.groups.parse') }}',
            destroy:'{{ route('translate.groups.destroy') }}',
        };
        groupApp.dict = {
            restart:'@lang('main.restart')',
            delete:'@lang('main.delete')',
        };
        groupApp.init();
    });
</script>
@endsection

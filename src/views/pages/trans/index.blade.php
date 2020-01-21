@extends('translate::layouts.' . (config('translate.layout') ? 'empty' : 'main'))

@section('content_part')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a href="{{ url(config('translate.url.admin', 'admin')) }}">@lang('main.main_page')</a> /
                <a href="{{ route('translate.index') }}">@lang('main.translation')</a> /
                <a href="{{ route('translate.groups.type', ['type' => $type]) }}">{{ $type }}</a> /
                <span>{{ $group->name }}</span>
            </h5>
        </div>
        <div class="panel-content">
            @include('translate::pages.trans.create')

            <div class="panel-body">
                <form action="{{ route('translate.translates.index', ['type' => $type, 'group_id' => $group->id]) }}" method="get" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                                <input type="hidden" name="id" value="{{ $group->id }}" class="form-control">
                                <input type="hidden" name="isFilter" value="1" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>

                <table id="transTable" class="table table-sm table_wrapper hover" cellspacing="0" width="100%">
                    <thead>
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
            <div class="dropdown-menu dropdown-menu-options-trans" >
                <div class="accordion">
                    <div class="accordion-header field-wrapper">translate</div>
                    <div class="accordion-body" id="translateOptions" hidden>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="translate" value="">
                            <label class="form-check-label">All</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="translate" value="2">
                            <label class="form-check-label">translated</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="translate" value="1">
                            <label class="form-check-label">not translated</label>
                        </div>
                    </div>
                </div>
                <div class="accordion">
                    <div class="accordion-header field-wrapper">verify</div>
                    <div class="accordion-body" id="verifyOptions" hidden>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="">
                            <label class="form-check-label">All</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="2">
                            <label class="form-check-label">verified</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="1">
                            <label class="form-check-label">not verified</label>
                        </div>
                    </div>
                </div>
                <div class="accordion">
                    <div class="accordion-header field-wrapper">languages</div>
                    <div class="accordion-body" id="langOptions" hidden>
                        <div class="field-wrapper">
                            <input id="searchLangFilter" type="text" placeholder="language" name="name" class="find-field" autocomplete="off">
                        </div>
                        <div class="field-list dataTables_scrollBody">
                            @foreach($langs as $lang)
                            <div class="form-check" data-lang="{{ $lang->name }}">
                                <input class="form-check-input" type="checkbox" name="lang[{{ $lang->id }}]" value="{{ $lang->id }}">
                                <label class="form-check-label" for="not-translated">{{ $lang->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon find"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-find-trans">
                <div class="field-wrapper">
                    <form id="searchFilter">
                        <input type="text" placeholder="Key" name="key" class="find-field">
                        <input type="text" placeholder="Translation" name="translation" class="find-field">
                        <button type="submit" class="button find-field">@lang('main.search')</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    @include('translate::pages.trans.edit')
@endsection
@section('translate-js')
    <script>
        $(function () {
            transApp.group = {{ $group->id }};
            transApp.langs = {!! $langs->pluck('name', 'id') !!};
            transApp.url = {
                get:'{{ route('translate.translates.get') }}',
                store:'{{ route('translate.translates.store') }}',
                update:'{{ route('translate.translates.update') }}',
                destroy:'{{ route('translate.translates.destroy') }}',
            };
            transApp.init();
        });
    </script>
@endsection

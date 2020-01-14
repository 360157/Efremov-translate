<nav id="navbar" class="navbar">
    <span class="navbar-brand">@lang('main.translation')</span>
    @php
        $route = request()->route()->getName();
        $type = request()->route('type') ?? request()->get('type');
    @endphp
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link{{ $route == 'translate.langs.index' ? ' active' : '' }}" href="{{ route('translate.langs.index') }}">@lang('main.langs')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ $type == 'interface' ? ' active' : '' }}" href="{{ route('translate.groups.type', ['type' => 'interface']) }}">@lang('main.interface-trans')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ $type == 'system' ? ' active' : '' }}" href="{{ route('translate.groups.type', ['type' => 'system']) }}">@lang('main.system-trans')</a>
        </li>
    </ul>
</nav>
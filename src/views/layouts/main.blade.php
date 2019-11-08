<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{config('app.favicon')}}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Title</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="/vendor/vocabulare/css/style.css" rel="stylesheet" type="text/css">

    <style>
        body {
            background-color: #F1F1F1;
        }
        .navbar {
            margin: 0 300px;
            border-radius: 4px;
            padding: 0 30px;
            margin-bottom: 10px;
            background-color: #FFFFFF;
        }
        .navbar-brand {
            font: 400 20px/26px Roboto;
            text-transform: capitalize;
        }
        .nav-link span {
            font: 300 14px/19px Roboto;
            color: #212121;
        }
        .nav-link:hover span {
            font-weight: 400;
            color: #5670FF;
        }
        .nav-link:active span {
            font-weight: 400;
            color: #212121;
            text-decoration: underline;
        }

        .page-content {
            margin: 0 300px;
            border-radius: 4px;
            background-color: #FFFFFF;
        }
        
        .nav-link {
            padding: 8px 60px;
        }
        .btn-group {
            position: absolute;
            top: 60px;
            left: 0;
            background: #FFFFFF;
            width: 265px;
            height: 57px;
            border-radius: 4px;
            -moz-box-shadow: 0px 0px 5px #939292;
            -webkit-box-shadow: 0px 0px 5px #939292;
            box-shadow: 0px 0px 5px #939292;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .icon {
            width: 38px;
            height: 38px;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .icon:active {
            background: #5670FF;
        }
        .save::after {
            content: '';
            width: 28px;
            height: 17px;            
            background: url("/img/save.svg") no-repeat;
        }
        .save:hover::after {          
            background: url("/img/save-hover.svg") no-repeat;
        }
        .save:active::after { 
            margin-top: 6px;         
            background: url("/img/save-active.svg") no-repeat;
        }
        .sort::after {
            content: '';
            width: 27px;
            height: 22px;
            background: url("/img/sort.svg") no-repeat;
        }
        .sort:hover::after { 
            background: url("/img/sort-hover.svg") no-repeat;
        }
        .sort:active::after { 
            background: url("/img/sort-active.svg") no-repeat;
        }
        .options::after {
            content: '';
            width: 26px;
            height: 25px;
            background: url("/img/options.svg") no-repeat;
        }
        .options:hover::after { 
            background: url("/img/options-hover.svg") no-repeat;
        }
        .options:active::after { 
            background: url("/img/options-active.svg") no-repeat;
        }
        .find::after {
            content: '';
            width: 27px;
            height: 27px;
            background: url("/img/find.svg") no-repeat;
        }
        .find:hover::after { 
            background: url("/img/find-hover.svg") no-repeat;
        }
        .find:active::after { 
            background: url("/img/find-active.svg") no-repeat;
        }

        .dropdown {
            position: relative;
        }
        .dropdown-toggle-aside {
            position: absolute !important;
            width: 38px !important;
            height: 100% !important;
            background: transparent !important;
        }
        .aside-menu {
            border-top-left-radius: 0px !important;
            border-top-right-radius: 0px !important;
            -moz-box-shadow: 0px 0px 0px #939292;
            -webkit-box-shadow: 0px 0px 0px #939292;
            box-shadow: 0px 3px 3px #939292 !important;
            width: 265px;
            position: absolute !important;
            left: 0 !important;
        }
       
        .dropdown-options {
            left: -147px !important;
            border: none !important;
            padding: 0 !important;
        }
        .dropdown-find {
            left: -213px !important;
            border: none !important;
            padding: 0 !important;
        }
        .field-wrapper {
            margin-top: 8px;
            border-top: 1px solid #E8EBED;
            width: 100%;            
            padding: 15px 20px !important;
        }
        .find-field {
            border: 1px solid #6E6E6E;
            outline: none;
            border-radius: 4px;
            width: 100%;
            padding: 4px 14px;
            font: 300 14px/19px Roboto;
        }
        .find-field:focus {
            border-color: #5670FF;
        }
        .find-field::placeholder {
            color: #D6D6D6;
            font: 300 14px/19px Roboto;
        }
        #statusOptions {
            display: none;
        }
        #lang-options {
            display: none;
            padding: 10px 19px;
            border-top: 1px solid #E8EBED;
        }
        #lang-options ul {
            margin: 0;
            padding: 0;
            padding-top: 10px;
        }
        #lang-options ul li {
            padding: 0 10px;
        }
        #langFilter, #statusFilter {
            position: relative;
            margin: 0;
            padding: 10px 20px !important;
        }
        #langFilter:after, #statusFilter:after {
            content: '';
            position: absolute;
            top: 21px;
            right: 12px;
            width: 12px;
            height: 7px;
            background: url("/img/arrow.svg") no-repeat;
            cursor: pointer;
            transform: rotate(-90deg);
            transition-duration: 500ms;
        }
        .show-options {
            display: block !important;
        }

        .form-check {
            height: 44px;
            border-top: 1px solid #E8EBED;
            display: flex;
            align-items: center;
            font: 400 14px/19px Roboto;
            padding-left: 20px;
        }
        .form-check-label {
            padding-left: 30px;
            color: #919191;
        }
        .form-check-input:checked + .form-check-label {
            color: #000000;
        }
        .form-check-input {
            margin: 0;
            width: 22px;
            height: 22px;
        }
        .form-check-input:after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 22px;
            height: 22px;
            background: #919191;
            border-radius: 4px;
        }
        #not-translated:checked:after {
            background: #EC4439;
        }
        #translated:checked:after {
            background: #1595BA;
        }
        #checked:checked:after {
            background: #8CB302;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <nav id="navbar" class="navbar">
            <span class="navbar-brand">@lang('system::main.translate')</span>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('translate.langs.index') }}"><span>@lang('system::main.langs')</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('translate.groups.type', ['type' => 'interface']) }}"><span>@lang('system::main.interface-trans')</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('translate.groups.type', ['type' => 'system']) }}"><span>@lang('system::main.system-trans')</span></a>
                </li>
            </ul>
        </nav>

        <section class="page-content">
        @foreach(['success', 'error'] as $type)
            @if (Session::has($type))
            <div class="alert alert-{{ $type !== 'error' ? $type : 'danger' }}" role="alert">
                {!! Session::get($type) !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            @endif
        @endforeach

        </section>

        <section class="page-content">
            @yield('content')
        </section>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="/vendor/vocabulare/js/script.js"></script>
@yield('vocabulare-js')
</html>

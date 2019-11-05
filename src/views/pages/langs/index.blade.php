@extends('vocabulare::layouts.main')

@section('content')
    <style>
        .panel{
            background-color: #fff;
            border-radius: 4px;
        }
        .panel-heading {
            height: 40px;
            border-bottom: 1px solid #E8EBED;
            padding: 0 30px;
            margin-bottom: 42px;
        }
        .panel-title {
            font: 400 14px/40px Roboto;
        }
        .panel-content {
            padding: 0 30px;
        }
        label {
            padding-left: 7px;
        }
        .form-control {
            height: 30px;
            border: 1px solid #E5E5E5;
            padding: 4px 7px;
            font: 300 14px/19px Roboto;
        }
        .form-control::placeholder {
            color: #E5E5E5;
        }
        .select {
            width: calc(100% - 124px - 15px);
        }        
        .btn {
            width: 124px;
            height: 30px;
            position: absolute;
            bottom: 0;
            right: 15px;
            border-radius: 15px;
            background: #5670FF;
            padding: 0;
        }
        .table th {
            border: none;
        }
        .table thead th {
            border-bottom: 1px solid #E8EBED;
            font: 400 14px/19px Roboto;
            text-align: left;
            max-width: 25%;
        }
        .table tbody tr td {
            height: 48px;
            font: 300 14px/19px Roboto;
            text-align: left;
            max-width: 25%;
        }
        td {
            overflow-y: hidden;
        }
        th:last-child, td:last-child{
            text-align: right !important;
        }
        .dropdown {
            overflow-y: visible;
        }
        .icons-list {
            padding: 0;
            margin: 0;
            padding-right: 17px;
            list-style: none;
            text-align: right;
        }


        .modal-dialog {
            margin-top: 283px;
            width: 500px;
        }
        .modal-dialog .col-md-6 {
            padding: 5px;
        }
        .modal-header {
            height: 45px;
            padding-left: 29px;
            padding-right: 15px;
        }
        .modal-title {
            font: 500 18px/24px Roboto;
        }
        .close {
            border-radius: 50%;
            width: 17px;
            height: 17px;
            padding: 0 !important;
            margin: 0 !important;
            background-color: #F3F5F6!important;
            line-height: 16px !important;
            color: #fff;
            position: relative;
            font-size: 1rem;
            font-weight: 400;
            opacity: 1;
            outline: none;
        }
        .close:after {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            width: 7px;
            height: 7px;
            background: url("/img/close.svg");
        }
        .modal-body {
            height: 190px;
            padding: 15px 29px 30px 29px;
        }
        .modal-body .btn {
            position: relative;
            right: 0;
            margin: 0 auto;
        }
        .row {
            padding: 0 -5px;
        }

        td {
            overflow-y: hidden;
        }
        .dropdown {
            overflow-y: visible;
        }
        .dropdown-menu {
            padding: 0;
            border-radius: 4px;
            border: none;
            -moz-box-shadow: 0px 1px 2px #939292;
            -webkit-box-shadow: 0px 1px 2px #939292;
            box-shadow: 0px 1px 2px #939292;
        }
        .dropdown-menu li {
            height: 37px;
            padding: 0 25px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .dropdown-menu li:hover {
            background: #E8EBED;
        }
        th:last-child, td:last-child{
            text-align: right !important;
        }
        .dropdown-toggle {
            position: absolute;
            top: 19px;
            right: 12px;
            width: 12px;
            height: 7px;
            background: url("/img/arrow.svg") no-repeat;
            cursor: pointer;
        }
        .dropdown-toggle::after {
            display: none;
        }
        .form .delete-text {
            line-height: 100%;
            -webkit-appearance: none;
        }
        .delete-text {
            line-height: 100%;
            -webkit-appearance: none;
            background: transparent;
            border: none;
            font: 300 14px/19px Roboto;
            outline: none;
        }
        .delete-icon {
            width: 18px;
            height: 21px;
            margin-right: 12px;
            background: url("/img/delete.svg") no-repeat;
        }
        .edit-icon {
            width: 16px;
            height: 17px;
            margin-right: 12px;
            background: url("/img/edit.svg") no-repeat;
        }
        #isActiveCheck {
            margin: 0;
            width: 27px;
            position: relative;
        }
        #isActiveCheck:after {
            content: '';
            position: absolute;
            top: -50%;
            right: 0;
            width: 27px;
            height: 27px;
            border-radius: 50%;
            border: 2px solid #6E6E6E;
            background: #fff;
        }
        #isActiveCheck:checked:after {
            content: '';
            position: absolute;
            top: -50%;
            right: 0;
            width: 27px;
            height: 27px;
            border: none;
            background: url("/img/isActive.svg") no-repeat;
        }
    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Langs</h5>
        </div>
        <div class="panel-content">
            <div class="panel-body">
                @include('vocabulare::pages.langs.create')
            </div>
            <form action="{{ route('translate.langs.index') }}" method="get" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                <div class="form-group col-md-5">
                    <label for="exampleFormControlSelect1">Example select</label>
                    <select name="isActive" class="form-control select" id="exampleFormControlSelect1">
                        <option value="">All</option>
                        <option value="yes" {{ request()->isActive === 'yes'  ? 'selected' : '' }}>Active</option>
                        <option value="no" {{ request()->isActive === 'no'  ? 'selected' : '' }}>Not active</option>
                    </select>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">@lang('main.filter')<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
                </div>
            </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">@lang('main.id')</th>
                        <th scope="col">@lang('main.index')</th>
                        <th scope="col">@lang('main.name')</th>
                        <th scope="col">@lang('main.isActive')</th>
                        <th scope="col">@lang('main.created_at')</th>
                        <th scope="col">@lang('main.updated_at')</th>
                        <th scope="col">@lang('main.actions')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($langs as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->index }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{!! $value->is_active ? '<span class="badge badge-success">active</span>' : '<span class="badge badge-danger">not active</span>' !!}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>{{ $value->updated_at }}</td>
                            <td class="text-center dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown"></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li data-toggle="modal" data-target="#myModal" OnClick="edit('{{ $value->id }}', '{{ $value->index }}', '{{ $value->name }}', '{{ $value->is_active }}');">
                                        <div class="edit-icon"></div>
                                        <span>@lang('main.edit')</span>
                                    </li>
                                    <li>
                                        <div class="delete-icon"></div>
                                        <form id="destroy-form-{{ $value->id }}" action="{{ route('translate.langs.destroy', ['id'=>$value->id]) }}" method="post" onsubmit="return submitForm()">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                            <button type="submit" class="delete-text">@lang('main.delete') </button>
                                        </form>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                @endforeach
                    </tbody>
                </table>
        </div>
    </div>

    @include('vocabulare::pages.langs.edit')

    <script type='text/javascript'>
        function edit(id, index, name, isActive){
            $("#id").attr("value", id);
            $("#name").attr("value", index);
            $("#index").attr("value", name);
            document.getElementById("isActiveCheck").checked = isActive == 1;
        }
    </script>

@endsection
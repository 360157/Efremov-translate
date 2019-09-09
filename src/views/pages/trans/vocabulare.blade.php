@extends('vocabulare::layouts.main')

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">

            <h5 class="panel-title">Groups</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <form action="{{ route('groups.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>@lang('main.group')</label>
                                    <input type="text" name="name" value="" class="form-control">
                                    <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">@lang('main.create')<i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>@lang('main.id')</th>
                <th>@lang('main.group')</th>
                <th>@lang('main.trans')/@lang('main.not_trans')</th>
                <th>@lang('main.actions')</th>
            </tr>
            </thead>

            <tbody>
            @if (!empty($success))
                <h1>{{$success}}</h1>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach($groups as $value)
                <tr onclick="trClick({{ $value['id']  }})">
                    <td>{{ $value['id'] }}</td>
                    <td>{{ $value['name'] }}</td>
                    <td>{{ $value['trans'] }}/{{ $value['not_trans'] }}</td>
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <form id="destroy-form-{{ $value['id'] }}" action="{{ route('groups.destroy', ['id'=>$value['id']]) }}" method="post" onsubmit="return submitForm()">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary">@lang('main.delete') <i class="icon-arrow-right14 position-right"></i></button>
                                        </form>
                                        <a onclick="$('#destroy-form-{{ $value['id'] }}').submit()"><i class="icon-trash"></i>@lang('main.delete')</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
    </div>
    <form id="transForm" action="{{ route('translate.index') }}" method="get" enctype="multipart/form-data">
        <input type="hidden" name="type" value="{{ $type }}" class="form-control">
        <input id="group_id" type="hidden" name="id" value="" class="form-control">
    </form>
    <script type='text/javascript'>
        function trClick(id){
            $("#group_id").attr("value", id);
            document.getElementById("transForm").submit();
        }
    </script>

@endsection
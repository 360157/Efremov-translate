@extends('vocabulare::layouts.main')

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">

            <h5 class="panel-title">Langs</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if (!empty($success))
                    <h1>{{$success}}</h1>
                @endif
                <div class="panel-body">
                    <form action="{{ route('langs.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>@lang('main.name')</label>
                                    <input type="text" name="name" value="" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>@lang('main.index')</label>
                                    <input type="text" name="index" value="" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">@lang('main.create') <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </form>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>@lang('main.id')</th>
                        <th>@lang('main.index')</th>
                        <th>@lang('main.name')</th>
                        <th>@lang('main.isActive')</th>
                        <th>@lang('main.actions')</th>
                    </tr>
                    </thead>

                    <tbody>
                    <div id="myModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                                    <h4 class="modal-title">Edit langs</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('langs.update', [ 'id' => 0 ]) }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="form-group">
                                            <div class="row">
                                                <input id="id" type="hidden" name="id" value="" class="form-control">
                                                <div class="col-md-4">
                                                    <label>@lang('main.name')</label>
                                                    <input id="name" type="text" name="name" value="" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>@lang('main.index')</label>
                                                    <input id="index" type="text" name="index" value="" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>@lang('main.index')</label>
                                                    <input id="isActive" type="checkbox" name="is_active">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">@lang('main.create') <i class="icon-arrow-right14 position-right"></i></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button></div>
                            </div>
                        </div>
                    </div>
                    @foreach($langs as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->index }}</td>
                            <td>{{ $value->name }}</td>
                            <td><input type="checkbox" name @if($value->is_active) checked @endif>{{ $value->is_active }}</td>
                            <td class="text-center">
                                <ul class="icons-list">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <button class="btn btn-info" id="but1" type="button" data-toggle="modal" data-target="#myModal" OnClick="edit('{{ $value->id }}', '{{ $value->index }}', '{{ $value->name }}', '{{ $value->is_active }}');">Edit</button>
                                            </li>
                                            <li>
                                                <form id="destroy-form-{{ $value->id }}" action="{{ route('langs.destroy', ['id'=>$value->id]) }}" method="post" onsubmit="return submitForm()">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    {{ csrf_field() }}
                                                </form>
                                                <a onclick="$('#destroy-form-{{ $value->id }}').submit()"><i class="icon-trash"></i>@lang('main.delete')</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>


    </div>
    <script type='text/javascript'>
        function edit(id, index, name, isActive){
            $("#id").attr("value", id);
            $("#name").attr("value", index);
            $("#index").attr("value", name);
            document.getElementById("isActive").checked = isActive;
        }
    </script>

@endsection
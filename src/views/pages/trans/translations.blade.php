@extends('vocabulare::layouts.main')

@section('content')
    <style>
        .td-aproved{
            background-color: #00FFAF;
        }
        .td-default{
            background-color: #5D8AA8;
        }
        .td-warning{
            background-color: #FF0000;
        }

    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">

            <h5 class="panel-title">Translations</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <form action="{{ route('translate.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>@lang('main.new_translation')</label>
                                    <input type="text" name="key" value="" class="form-control">
                                    <input type="hidden" name="group_id" value="{{ $group_id }}" class="form-control">
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

        <form action="{{ route('translate.index') }}" method="get" enctype="multipart/form-data">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="id" value="{{ $group_id }}" class="form-control">
                        <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                        <input type="hidden" name="isFilter" value="1" class="form-control">
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">@lang('main.filter')<i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </form>

        <form action="{{ route('translate.index') }}" method="get" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $group_id }}" class="form-control">
            <input type="hidden" name="type" value="{{ $type }}" class="form-control">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Lang select</label>
                <select name="lang_id" class="form-control" id="exampleFormControlSelect1">
                    <option value="all">All</option>
                    @foreach($all_langs as $lang)
                        <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                    @endforeach
                </select>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">@lang('main.filter')<i class="icon-arrow-right14 position-right"></i></button>
                </div>
            </div>
        </form>

        <form id="translate" action="{{ route('translate.update', [ 'id' => $group_id ]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT" />
            {{--<input type="hidden" name="group_id" value="{{ $group_id }}" class="form-control">--}}
            <input type="hidden" name="type" value="{{ $type }}" class="form-control">
        <table class="table">
            <thead>
            <tr>
                <th>@lang('main.key')</th>
                @foreach($langs as $lang)
                    <th>{{ $lang->name }}</th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @foreach($trans as $value)
                <tr>
                    <td>{{ $value->key }}</td>
                    @foreach($transData[$value->id] as $data)
                    <td @if($data['status'] == 0 || $data['value'] == '') class="td-warning" @elseif($data['status'] == 1) class="td-default" @elseif($data['status'] == 2) class="td-aproved" @endif>
                        <input type="text" name="{{ 'trans['.$value->id.']['. $data['lang_id'] .']' }}" value="{{ $data['value'] }}" class="form-control checkClass">
                        <label class="custom-control-label" for="defaultUnchecked">Checked</label>
                        <input name="isChecked[{{ $data['id'] }}]" type="checkbox" @if($data['status'] == 2) checked @endif>
                    </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
            {{ $trans->links() }}
            <div class="text-right">
                <button type="submit" class="btn btn-primary">@lang('main.update')<i class="icon-arrow-right14 position-right"></i></button>
            </div>
        </form>
    </div>
    <script type='text/javascript'>
        const elements = document.querySelectorAll('input.checkClass');
        elements.forEach(function(el) {
           el.addEventListener('input', function(e) {
               console.log('name: ' + e.target.name, 'new value: '+e.target.value);
                const tdParent = e.target.parentNode;
                tdParent.classList.remove('td-aproved');
                tdParent.classList.add('td-default');
                const checkbox = tdParent.querySelector("input[type='checkbox']");
                checkbox.checked = false;
               console.log( );
           });
        });

    </script>

@endsection
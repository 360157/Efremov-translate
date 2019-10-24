@extends('vocabulare::layouts.main')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">@lang('main.translations')</h5>
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

        <form id="transFilter">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="key" value="" class="form-control" placeholder="key">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="translation" value="" class="form-control" placeholder="translation">
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="status">
                            <option value="">All</option>
                            <option value="2">Checked</option>
                            <option value="1">Not checked</option>
                            <option value="0">Not translate</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">@lang('main.filter')<i class="icon-arrow-right14 position-right"></i></button>
                            <a class="btn btn-success" data-toggle="modal" data-target="#myModal" href="#">@lang('main.create')</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table class="table table-striped table-hover" id="transTable">
            <thead>
            <tr>
                <th>@lang('main.key')</th>
                @foreach($langs as $lang)
                    <th>{{ $lang->name }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>
                <th colspan="{{ count($langs) + 1 }}">
                    <ul class="pagination justify-content-center"></ul>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('main.new_translation')</h4>
                    <button class="close" type="button" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form id="transCreate" action="{{ route('translates.store') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="group_id" value="{{ $group_id }}" class="form-control">
                            <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                            <input type="text" name="key" class="form-control" placeholder="key">
                            <br>
                            @foreach($langs as $lang)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $lang->index }}</span>
                                    </div>
                                    <input name="translates[{{ $lang->id }}]" type="text" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><input type="checkbox" name="statuses[{{ $lang->id }}]" value='1'></span>
                                    </div>
                                </div>
                            @endforeach
                            <br>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">@lang('main.create')<i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script type='text/javascript'>
        const langIds = {{ $langs->pluck('id') }};
        const elements = document.querySelectorAll('input.checkClass');
        elements.forEach(function(el) {
           el.addEventListener('input', function(e) {
               console.log('name: ' + e.target.name, 'new value: '+e.target.value);
                const tdParent = e.target.parentNode;
                tdParent.classList.remove('td-aproved');
                tdParent.classList.add('td-default');
                const checkbox = tdParent.querySelector("input[type='checkbox']");
                checkbox.checked = false;
           });
        });

        $(function($) {
            let paginator = function (current, last, total = 4) {
                if (last === 1) {return '';}
                if (total > last) {total = last;}

                let pages = '';
                let start_delta = current - Math.round(total / 2);
                let start = current < total ? 1 : (start_delta < last ? start_delta : last);
                let end_delta = current + Math.round(total / 2);
                let end = last < total ? total : (end_delta < last ? end_delta : last);
                if (start > 1 && current >= end - total / 2) {
                    pages += '<li class="page-item"><a class="page-link" href="#page='+ (start - 1) +'" data-id="'+ (start - 1) +'">...</a></li>';
                }
                for (let i = start; i < end + 1; i++) {
                    pages += '<li class="page-item ' + (i === current ? 'active' : '') + '"><a class="page-link" href="#page='+ i +'" data-id="'+ i +'">' + i + '</a></li>';
                }
                if (end < last && current >= end - total / 2) {
                    pages += '<li class="page-item"><a class="page-link" href="#page='+ (end + 1) +'" data-id="'+ (end + 1) +'">...</a></li>';
                }

                return pages;
            };

            let bgcolor = function (status) {
                color = ['bg-danger text-white', 'bg-warning text-white', 'bg-success text-white'];
                return ' ' + color[status]
            };

            let tds = function (tds, key_id) {
                let tdStr = '';
                langIds.forEach(function (lang_id) {
                    let tdObj = {status: 0, translation: '', lang: lang_id, key: key_id};
                    tds.items.forEach(function (td) {
                        if (lang_id === td.lang_id) {
                            tdObj.status = td.status;
                            tdObj.translation = td.translation;
                        }
                    });

                    tdStr += '<td><div class="input-group mb-3">' +
                        '<input data-key="'+ tdObj.key +'" data-lang="' + tdObj.lang + '" type="text" value="' + tdObj.translation + '" class="form-control translation' + bgcolor(tdObj.status) + '">' +
                        '<div class="input-group-append">' +
                        (tdObj.status != 0 ? '<span class="input-group-text">' +
                        '<input class="status" type="checkbox" data-key="'+ tdObj.key +'" data-lang = "' + tdObj.lang + '" value="1" ' + (tdObj.status === 2 ? 'checked' : '') + '>' +
                        '</span>' : '') +
                        '</div>' +
                        '</div></td>';
                });

                return tdStr;
            };

            function loadTtrans(page = null, filter = {}) {
                let params = new URLSearchParams(window.location.hash.replace("#","?"));
                page = page || params.get('page') || 1;

                filter.key = filter.key || params.get('key');
                filter.translation = filter.translation || params.get('translation');
                filter.status = filter.status || params.get('status');

                filter.group = '{{ $group_id }}';
                filter.type = '{{ $type }}';

                $.ajax({
                    type: "GET",
                    url: '{{ route('translates.list') }}',
                    data: {page: page, filter: filter},
                    success: function(res) {
                        let trs = '';
                        res.data.forEach(function (key) {
                            trs += '<tr>'+ '<td><input data-id="'+key.id+'" type="text" value="'+key.key+'" class="form-control key"></td>' + tds(key, key.id) +'</tr>';
                        });
                        $('#transTable tbody').html(trs);

                        $('#transTable .pagination').html(paginator(res.meta.current_page, res.meta.last_page));

                        $('.page-link').on('click', function () {
                            loadTtrans($(this).data('id'));
                        });

                        $('#transTable .form-control.key, #transTable .form-control.translation, #transTable .status').on('change', function() {
                            updateTrans(this);
                        });
                    }
                });
            }
            loadTtrans();

            let transCreateForm = $('#transCreate');
            transCreateForm.submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: transCreateForm.attr('action'),
                    data: transCreateForm.serialize(),
                    success: function(data) {
                        $('#myModal').modal('hide');
                        loadTtrans();
                    }
                });
            });

            let transFilterForm = $('#transFilter');
            transFilterForm.submit(function(e) {
                e.preventDefault();
                var data = new FormData(transFilterForm[0]);

                loadTtrans(1, {
                    key: data.get('key'),
                    translation: data.get('translation'),
                    status: data.get('status'),
                });
            });

            let updateTrans = function (e) {
                let dataObj = {};
                if ($(e).hasClass('translation')) {
                    dataObj = {obj: 'translation', type: '{{ $type }}', key: $(e).data('key'), lang: $(e).data('lang'), translation: $(e).val()};
                } else if ($(e).hasClass('status')) {
                    dataObj = {obj: 'translation', key: $(e).data('key'), lang: $(e).data('lang'), status: $(e).is(':checked') === true ? 2 : 1};
                } else {
                    dataObj = {obj: 'key', id: $(e).data('id'), value: $(e).val()};
                }

                $.ajax({
                    type: "PATCH",
                    url: '{{ route('translates.update') }}',
                    data: dataObj,
                    success: function(data) {
                        $('#myModal').modal('hide');
                        loadTtrans();
                    }
                });
            }
        })
    </script>
    @endpush
@endsection
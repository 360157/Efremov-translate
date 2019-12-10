@extends('translate::layouts.main')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a href="{{ url(config('translate.url', 'admin')) }}">@lang('system::main.main_page')</a> /
                <a href="{{ route('translate.index') }}">@lang('system::main.translate')</a> /
                <span>{{ $type }}</span>
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
                        <input type="text" placeholder="Search" class="find-field">
                        <button type="submit" class="button find-field">Search</button>
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
        let groupApp = {
            dataTable: {},
            type: '{{ request()->type }}',
            searchText: null,
            get() {
                this.dataTable = $('#groupTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    stateSave: true,
                    order: [[0, "desc"]],
                    scrollX: true,
                    scrollY: false,
                    ajax: {
                        url: '{{ route('translate.groups.get') }}',
                        'data': function(data){
                            data.type = groupApp.type;
                            data.search = groupApp.searchText;
                        }
                    },
                    columns: [
                        {
                            data: 'id',
                            width: "26px",
                            'render': function (data, type, full, meta) {
                                return '<div class="action-link">' + data + '</div>';
                            }
                        },
                        {
                            data: 'name',
                            'render': function (data, type, full, meta) {
                                return '<div class="action-link">' + data + '</div>';
                            }
                        },
                        {
                            data: 'trans',
                            'render': function (data, type, full, meta) {
                                return '<div class="action-link">' + full.trans + ' / ' + full.not_trans + '</div>';
                            }
                        },
                        {
                            data: null,
                            width: "48px",
                            defaultContent: '<div class="edit-wrapper">' +
                                '<div class="dropdown dropdown-arrow">' +
                                    '<div class="dropdown-toggle" data-toggle="dropdown">' +
                                        '<a class="dropdown-toggle-arrow"></a>' +
                                    '</div>' +
                                    '<div class="dropdown-menu dropdown-menu-right dropdown-menu-edit">' +                             
                                        '<div class="action-delete"><div class="delete-icon"></div>@lang('system::main.delete')</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>'
                        }
                    ],
                    columnDefs: [
                        {targets: 2, orderable: false},
                        {targets: 3, orderable: false}
                    ]
                });
            },
            show(el) {
                let data = el.data();
                window.location = '{{ route('translate.translates.index') }}' + '?type=' + data.type + '&group=' + data.id;
            },
            create(data) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('translate.groups.store') }}',
                    data: data,
                    success: function (res) {
                        if (res.status === 'success') {
                            groupApp.dataTable.ajax.reload();
                            $.notify({message: res.message},{type: 'success'});
                        } else {
                            $.notify({message: res.message},{type: 'danger'});
                        }
                    },
                    error: function (res) {
                        $.notify({message: res.message},{type: 'danger'});
                    },
                });
            },
            delete(el, data) {
                $.ajax({
                    type: "DELETE",
                    url: '{{ route('translate.groups.destroy') }}',
                    data: {id: el.data().id, trans: true, _token: '{{ csrf_token() }}'},
                    success: function (res) {
                        if (res.status === 'success') {
                            el.remove().draw(false);
                            $.notify({message: res.message},{type: 'success'});
                        } else {
                            $.notify({message: res.message},{type: 'danger'});
                        }
                    }
                });
            },
            init() {
                this.get();

                $('#groupCreateForm').on('submit', function (e) {
                    e.preventDefault();
                    groupApp.create($(this).serializeArray())
                });

                $('#groupTable tbody').on('click', 'div.action-link', function () {
                    let el = groupApp.dataTable.row($(this).parents('tr'));
                    groupApp.show(el)
                });

                $('#groupTable tbody').on('click', 'div.action-delete', function () {
                    let el = groupApp.dataTable.row($(this).parents('tr'));
                    let allTrans = el.data().trans + el.data().not_trans;

                    if (allTrans > 0) {
                        $('#groupDeleteModal').modal('show');

                        $('#groupDeleteModal button[type="submit"]').on('click', function (e) {
                            $('#groupDeleteModal').modal('hide');
                            groupApp.delete(el)
                        });
                    } else {
                        groupApp.delete(el)
                    }
                });

                $('#groupSearchForm').on('submit', function (e) {
                    e.preventDefault();
                    groupApp.searchText = $(this).find('input').val();
                    groupApp.dataTable.draw();
                });
            },
        };
        groupApp.init();
    });
</script>
@endsection

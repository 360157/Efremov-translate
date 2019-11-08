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
        .panel-footer {
            padding: 10px 0;
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
        .col-md-6 .form-control {
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
        }
        .dropdown-menu li:hover {
            background: #E8EBED;
        }
        th:last-child, td:last-child{
            text-align: right !important;
        }
        .form .delete-text {
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

        .modal-body .btn {
            position: relative;
            right: 0;
            margin: 0 auto;
        }
        .row {
            padding: 0 -5px;
        }
        span.action-link {
            display: block;
            width: 100%;
            cursor: pointer;
        }
    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Groups: {{ $type }}</h5>
        </div>
        <div class="panel-content">
            <div class="panel-body">
                @include('vocabulare::pages.groups.create')

                <table id="groupTable" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">@lang('system::main.id')</th>
                        <th scope="col">@lang('system::main.group')</th>
                        <th scope="col">@lang('system::main.trans')/@lang('system::main.not_trans')</th>
                        <th scope="col">@lang('system::main.created_at')</th>
                        <th scope="col">@lang('system::main.updated_at')</th>
                        <th scope="col">@lang('system::main.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="btn-group">
        <div class="icon save"></div>
        <div class="icon sort">
            <a class="dropdown-toggle-aside" data-toggle="dropdown" href="#"></a>
            <div class="dropdown-menu aside-menu">
                <div class="field-wrapper">@lang('system::main.index')</div>
                <div class="field-wrapper">@lang('system::main.name')</div>
            </div>
        </div>
        <div class="icon find">
            <a class="dropdown-toggle-aside" data-toggle="dropdown" href="#"></a>
            <div class="dropdown-menu aside-menu dropdown-find">
                <div class="field-wrapper">
                    <form id="groupSearchForm">
                        <input type="text" placeholder="Search" class="find-field">
                        <button type="submit" class="find-field">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vocabulare-js')

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
                            'render': function (data, type, full, meta) {
                                return '<span class="action-link">' + data + '</span>';
                            }
                        },
                        {
                            data: 'name',
                            'render': function (data, type, full, meta) {
                                return '<span class="action-link">' + data + '</span>';
                            }
                        },
                        { data: 'trans' },
                        { data: 'created_at' },
                        { data: 'updated_at' },
                        { data: null, defaultContent: '<span class="action-delete"><div class="delete-icon"></div> @lang('system::main.delete')</span>' }
                    ],
                    columnDefs: [
                        {targets: 2, orderable: false},
                        {targets: 5, orderable: false}
                    ]
                });
            },
            show(el) {
                let data = el.data();
                window.location = '{{ route('translate.translates.index') }}' + '?type=' + data.type + '&group=' + data.id;
            },
            create(el) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('translate.groups.store') }}',
                    data: {
                        type: $(el).find('[name="type"]').val(),
                        name: $(el).find('[name="name"]').val(),
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            groupApp.dataTable.ajax.reload();
                            console.log(res.message);
                        } else {
                            console.log(res.message);
                        }
                    }
                });
            },
            delete(el) {
                $.ajax({
                    type: "DELETE",
                    url: '{{ route('translate.groups.destroy') }}',
                    data: {id: el.data().id},
                    success: function (res) {
                        if (res.status === 'success') {
                            el.remove().draw(false);
                            console.log(res.message);
                        } else {
                            console.log(res.message);
                        }
                    }
                });
            },
            init() {
                this.get();

                $('#groupCreateForm').on('submit', function (e) {
                    e.preventDefault();
                    groupApp.create(this)
                });

                $('#groupTable tbody').on('click', 'span.action-link', function () {
                    let el = groupApp.dataTable.row($(this).parents('tr'));
                    groupApp.show(el)
                });

                $('#groupTable tbody').on('click', 'span.action-delete', function () {
                    let el = groupApp.dataTable.row($(this).parents('tr'));
                    groupApp.delete(el)
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

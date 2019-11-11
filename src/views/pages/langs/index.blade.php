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
                <table id="langTable" class="table table-striped" style="width: 100%;">
                    <thead>
                    <tr>
                        <th scope="col">@lang('system::main.id')</th>
                        <th scope="col">@lang('system::main.index')</th>
                        <th scope="col">@lang('system::main.name')</th>
                        <th scope="col">@lang('system::main.is_active')</th>
                        <th scope="col">@lang('system::main.created_at')</th>
                        <th scope="col">@lang('system::main.updated_at')</th>
                        <th scope="col">@lang('system::main.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </tr>
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
        <div class="icon options">
            <a class="dropdown-toggle-aside" data-toggle="dropdown" href="#"></a>
            <div class="dropdown-menu aside-menu dropdown-options" >
                <div id="statusLink" class="field-wrapper">status</div>
                <div id="statusOptions">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="not-translated" value="">
                        <label class="form-check-label" for="not-translated">All</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="not-translated" value="yes">
                        <label class="form-check-label" for="not-translated">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="translated" value="no">
                        <label class="form-check-label" for="translated">Not active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="icon find">
            <a class="dropdown-toggle-aside" data-toggle="dropdown" href="#"></a>
            <div class="dropdown-menu aside-menu dropdown-find">
                <div class="field-wrapper">
                    <form id="langSearchForm">
                        <input type="text" placeholder="Search" class="find-field">
                        <button type="submit" class="find-field">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('vocabulare::pages.langs.edit')
@endsection
@section('vocabulare-js')
    <script type='text/javascript'>
    statusLink.onclick = function(e) {
        e.preventDefault();
        e.stopPropagation();
        const options = document.getElementById("statusOptions");
        options.classList.toggle("show-options");
    };
    statusOptions.onclick = function(e) {
        e.stopPropagation();
    }

    $(function () {
        let langApp = {
            dataTable: {},
            isActive: null,
            searchText: null,
            get() {
                this.dataTable = $('#langTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    stateSave: true,
                    order: [[0, "desc"]],
                    ajax: {
                        url: '{{ route('translate.langs.get') }}',
                        'data': function(data){
                            data.isActive = langApp.isActive;
                            data.search = langApp.searchText;
                        }
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'index' },
                        { data: 'name' },
                        {
                            data: 'is_active',
                            'render': function (data, type, full, meta) {
                                return '<span class="badge badge-' + (data ? 'success' : 'danger') + '">' + data + '</span>';
                            }
                        },
                        { data: 'created_at' },
                        { data: 'updated_at' },
                        {
                            data: null, defaultContent: '<span class="action-edit"><div class="edit-icon"></div> @lang('system::main.edit')</span>' +
                                '<span class="action-delete"><div class="delete-icon"></div> @lang('system::main.delete')</span>'
                        }
                    ],
                    columnDefs: [
                        {targets: 6, orderable: false}
                    ]
                });
            },
            create(data) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('translate.langs.store') }}',
                    data: data,
                    success: function (res) {
                        if (res.status === 'success') {
                            langApp.dataTable.ajax.reload();
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
            update(data, modal) {
                $.ajax({
                    type: "PATCH",
                    url: '{{ route('translate.langs.update') }}',
                    data: data,
                    success: function (res) {
                        if (res.status === 'success') {
                            langApp.dataTable.ajax.reload(null, false);
                            modal.modal('hide');
                            $.notify({message: res.message},{type: 'success'});
                        } else {
                            $.notify({message: res.message},{type: 'danger'});
                        }
                    }
                });
            },
            delete(el) {
                $.ajax({
                    type: "DELETE",
                    url: '{{ route('translate.langs.destroy') }}',
                    data: {id: el.data().id},
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

                $('#langCreateForm').on('submit', function (e) {
                    e.preventDefault();
                    langApp.create($(this).serializeArray())
                });

                $('#langTable tbody').on('click', 'span.action-edit', function () {
                    let tr = langApp.dataTable.row($(this).parents('tr'));
                    let el = tr.data();
                    $('#langEditModal [name="id"]').val(el.id);
                    $('#langEditModal [name="index"]').val(el.index);
                    $('#langEditModal [name="name"]').val(el.name);
                    $('#langEditModal [name="is_active"]').prop('checked', el.is_active);
                    $('#langEditModal').modal()
                });

                $('#langEditForm').on('submit', function (e) {
                    e.preventDefault();
                    langApp.update($(this).serializeArray(), $('#langEditModal'))
                });

                $('#langTable tbody').on('click', 'span.action-delete', function () {
                    let el = langApp.dataTable.row($(this).parents('tr'));
                    langApp.delete(el)
                });

                $('#statusOptions input').on('click', function () {
                    langApp.isActive = $(this).val();
                    langApp.dataTable.draw();
                });

                $('#langSearchForm').on('submit', function (e) {
                    e.preventDefault();
                    langApp.searchText = $(this).find('input').val();
                    langApp.dataTable.draw();
                });
            },
        };
        langApp.init();
    });
</script>
@endsection

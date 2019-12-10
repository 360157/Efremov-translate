@extends('translate::layouts.main')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Langs</h5>
        </div>
        <div class="panel-content">
            <div class="panel-body">
                @include('translate::pages.langs.create')
            </div>
                <table id="langTable" class="table table_wrapper hover" style="width: 100%;">
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

    <div class="btn-group aside">
        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon options"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-options">
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

        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon find"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-find">
                <div class="field-wrapper">
                    <form id="langSearchForm">
                        <input type="text" placeholder="Search" class="find-field">
                        <button type="submit" class="button find-field">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('translate::pages.langs.edit')
@endsection
@section('translate-js')
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
                    scrollX: true,
                    // scrollY: false,                    
                    deferRender:    true,
                    scrollCollapse: true,
                    scroller:       true,
                    ajax: {
                        url: '{{ route('translate.langs.get') }}',
                        'data': function(data){
                            data.isActive = langApp.isActive;
                            data.search = langApp.searchText;
                        }
                    },
                    columns: [
                        { data: 'id', width: "24px" },
                        { data: 'index', width: "26px" },
                        { data: 'name', width: "100px" },
                        {
                            data: 'is_active',
                            width: "42px",
                            'render': function (data, type, full, meta) {
                                return '<div class="badge badge-' + (data ? 'active' : 'not-active') + '"></div>';
                            }
                        },
                        { data: 'created_at', width: "60px"},
                        { data: 'updated_at', width: "60px"},
                        {
                            data: null,
                            width: "48px",
                            defaultContent: '<div class="edit-wrapper">' +
                                '<div class="dropdown dropdown-arrow">' +
                                    '<div class="dropdown-toggle" data-toggle="dropdown">' +
                                        '<a class="dropdown-toggle-arrow"></a>' +
                                    '</div>' +
                                    '<div class="dropdown-menu dropdown-menu-right dropdown-menu-edit">' +
                                        '<div class="action-edit"><div class="edit-icon"></div>@lang('system::main.edit')</div> '  +                                
                                        '<div class="action-delete"><div class="delete-icon"></div>@lang('system::main.delete')</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>'
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

                $('#langTable tbody').on('click', 'div.action-edit', function () {
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

                $('#langTable tbody').on('click', 'div.action-delete', function () {
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

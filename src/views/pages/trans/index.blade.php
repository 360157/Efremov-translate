<?php
use \Sashaef\TranslateProvider\Models\Trans;
?>

@extends('vocabulare::layouts.main')

@section('content')

    <style>
        .td-aproved {
            border: 1.5px solid #00FFAF !important;
        }

        .td-default {
            border: 1.5px solid #5D8AA8 !important;
        }

        .td-warning {
            border: 1.5px solid #FF0000 !important;
        }

        .panel {
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
            outline: none;
            padding: 4px 7px;
            font: 300 14px/19px Roboto;
            cursor: pointer;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .form-control::placeholder {
            color: #E5E5E5;
        }

        .col-md-6 .form-control {
            width: calc(100% - 124px - 15px);
        }

        .col-md-6 .full-width {
            width: 100%;
        }

        .btn {
            width: 124px;
            height: 30px;
            position: absolute;
            bottom: 0;
            right: 15px;
            border-radius: 15px;
            padding: 0;
        }

        .btn-update {
            right: 0;
            bottom: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-update-icon {
            margin-right: 6px;
            width: 12px;
            height: 12px;
            background: url("/img/update.svg") no-repeat;
        }

        .table_wrapper {
            width: 1260px !important;
            max-width: 1260px !important;
            overflow-x: scroll !important;
            margin-bottom: -100px;
        }

        .table_wrapper::-webkit-scrollbar {
            background-color: #E8EBED;
            height: 4px;
            width: 4px;
        }

        .table_wrapper::-webkit-scrollbar-thumb {
            border-radius: 60px;
            max-width: 100px
        }

        .block {
            max-height: 48px !important;
            font: 300 14px/30px Roboto;
            text-align: left;
            padding: 9px !important;
            border-right: 1px solid #E5E5E5;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        .table.dataTable thead th {
            border: none;
        }

        .table.dataTable thead th:first-child {
            border-right: 1px solid #E5E5E5;
        }

        .dropdown {
            overflow-y: visible;
        }

        .dropdown .checked{
            background: #28a7454d;
        }

        .dropdown .unchecked{
            background: #dc35454d;
        }

        .dropdown-value {
            z-index: 50;
            width: 320px;
            left: -197px !important;
            padding: 0;
            border-radius: 4px;
            border: none;
            -moz-box-shadow: 0px 1px 3px #939292;
            -webkit-box-shadow: 0px 1px 3px #939292;
            box-shadow: 0px 1px 3px #939292;
        }

        .dropdown-translate-controller {
            left: -1px !important;
            top: -32px !important;
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

        .modal-dialog {
            margin-top: 283px;
            width: 500px;
        }

        .modal-dialog .col-md-6 {
            padding: 5px;
        }

        .modal-header {
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
            background-color: #F3F5F6 !important;
            line-height: 16px !important;
            color: #fff;
            position: relative;
            font-size: 1rem;
            font-weight: 400;
            opacity: 1;
            outline: none;
        }

        .dropdown-toggle {
            float: right;
            width: 28px;
            height: 28px;
            background: #FCFCFC;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-toggle::before {
            position: absolute;
            content: "";
            top: 7px;
            left: 7px;
            width: 14px;
            height: 14px;
            background: url("/img/stretch.svg") center no-repeat;
        }

        .dropdown-toggle:hover {
            background: #536CF5;
        }

        .dropdown-toggle:hover::before {
            background: url("/img/stretch-active.svg") center no-repeat;
        }

        .dropdown-item {
            white-space: normal;
            font: 400 14px/19px Roboto;
            padding: 10px;
            padding-bottom: 5px;
        }

        .dropdown-item:hover {
            background: transparent;
        }

        .dropdown-item:active {
            color: inherit;
        }

        .dropdown-content {
            width: 100%;
            border-radius: 6px;
            padding: 6px 8px;
            outline: none;
            border: 1px solid #E5E5E5;
            resize: none
        }

        .dropdown-footer {
            height: 41px;
            position: relative;
            border-top: 1px solid #E8EBED;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dropdown-footer .btn {
            height: 24px;
            position: relative;
            margin: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            right: 0;
        }

        .btn-disable {
            background: transparent;
            cursor: default !important;
        }

        .dropdown-footer .btn span {
            margin-left: 5px;
            font: 300 14px/19px Roboto;
        }

        .dropdown-footer .btn .restart {
            width: 12px;
            height: 12px;
            background: url("/img/restart.svg") center no-repeat;
        }

        .dropdown-footer .btn .check {
            width: 12px;
            height: 12px;
            background: url("/img/check.svg") center no-repeat;
        }

        .modal-body .btn {
            position: relative;
            right: 0;
            margin: 0 auto;
        }

        .row {
            padding: 0 -5px;
        }

        .custom-control-label:after,
        .custom-control-label:before {
            display: none;
        }

        .collapse {
            max-width: 320px;
        }

        .value {
            float: left;
            width: 110px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #translate {
            position: relative;
        }

        /* css for pagination plugin */
        /* #myTable {
            table-layout: fixed;
        } */

        .dataTables_wrapper .dataTables_paginate {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        #myTable_previous, #myTable_next {
            font-size: 0;
            position: relative;
        }

        #myTable_next:after {
            content: '';
            position: absolute;
            top: 16px;
            width: 12px;
            height: 7px;
            left: 20px;
            background: url("/img/arrow.svg") no-repeat;
            transform: rotate(270deg);
            cursor: pointer;
        }

        #myTable_previous:after {
            content: '';
            position: absolute;
            top: 16px;
            right: 20px;
            width: 12px;
            height: 7px;
            background: url("/img/arrow.svg") no-repeat;
            cursor: pointer;
            transform: rotate(90deg);
        }

        .disabled#myTable_next:after, .disabled#myTable_previous:after {
            top: 13px;
            width: 7px;
            height: 12px;
            background: url("/img/disabled.svg") no-repeat;
            transform: rotate(180deg);
            cursor: default;
        }

        .disabled#myTable_previous:after {
            transform: rotate(360deg);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: none !important;
            background: transparent !important;
            padding: 0.5em !important;
            box-shadow: inset 0 0 0px transparent !important;
            color: #868686 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            font-weight: 500;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #010101 !important;
        }

        .table.dataTable thead .sorting {
            background: transparent;
        }

        .table.dataTable thead th {
            border-bottom: none;
        }

        .dataTables_wrapper.no-footer .dataTables_scrollBody {
            border: none;
        }

        .dataTables_wrapper.no-footer .dataTables_scrollBody::-webkit-scrollbar {
            background-color: #E8EBED;
            height: 4px;
        }

        .dataTables_wrapper.no-footer .dataTables_scrollBody::-webkit-scrollbar-thumb {
            border-radius: 60px;
            max-width: 100px
        }

        table.dataTable thead .sorting_asc {
            background: transparent;
        }

        .dataTables_scrollBody {
            margin-top: -18px !important;
        }
    </style>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Translations: {{ $type }}::{{ $group->name }}</h5>
        </div>
        <div class="panel-content">
            <div class="panel-body">
                @include('vocabulare::pages.trans.create')
                <form action="{{ route('translate.translates.index', ['type' => $type, 'group_id' => $group->id]) }}" method="get" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                                <input type="hidden" name="id" value="{{ $group->id }}" class="form-control">
                                <input type="hidden" name="isFilter" value="1" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>

                <table id="transTable" class="table table-striped" style="width: 100%;">
                    <thead>
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
        <div class="icon options">
            <a class="dropdown-toggle-aside" data-toggle="dropdown" href="#"></a>
            <div class="dropdown-menu aside-menu dropdown-options" >
                <div id="statusFilter" class="field-wrapper">status</div>
                <div id="statusOptions" hidden>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="">
                        <label class="form-check-label" for="translated">All</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="2">
                        <label class="form-check-label" for="translated">Checked</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="1">
                        <label class="form-check-label" for="not-translated">Not checked</label>
                    </div>
                </div>
                <div id="langFilter" class="field-wrapper">languages</div>
                <div id="langOptions" hidden>
                    @foreach($langs as $lang)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="lang[{{ $lang->id }}]" value="{{ $lang->id }}">
                            <label class="form-check-label" for="not-translated">{{ $lang->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="icon find">
            <a class="dropdown-toggle-aside" data-toggle="dropdown" href="#"></a>
            <div class="dropdown-menu aside-menu dropdown-find">
                <div class="field-wrapper">
                    <form id="searchFilter">
                        <input type="text" placeholder="key" name="key" class="find-field">
                        <input type="text" placeholder="translation" name="translation" class="find-field">
                        <button type="submit" class="find-field">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('vocabulare::pages.trans.edit')
@endsection
@section('vocabulare-js')
    <script>
        statusFilter.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            const options = document.getElementById("statusOptions");
            options.classList.toggle("show-options");
        };
        langFilter.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            const options = document.getElementById("langOptions");
            options.classList.toggle("show-options");
        };
        statusOptions.onclick = function(e) {
            e.stopPropagation();
        }

        let main = {
            'group': {{ $group->id }},
            'langs': {!! $langs->pluck('name', 'id') !!},
        };

        $(function () {
            let transApp = {
                dataTable: {},
                groupId: main.group,
                keyText: null,
                translationText: null,
                status: null,
                langs: main.langs,
                get() {
                    this.dataTable = $('#transTable').DataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        stateSave: true,
                        order: [[0, "desc"]],
                        ajax: {
                            url: '{{ route('translate.translates.get') }}',
                            'data': function(data) {
                                data.group_id = transApp.groupId;
                                data.keyText = transApp.keyText;
                                data.translationText = transApp.translationText;
                                data.status = transApp.status;
                                data.langs = Object.keys(transApp.langs);
                            }
                        },
                        columns: transApp.columns(),
                        drawCallback: function(settings) {
                            $('[data-toggle="tooltip"]').tooltip();
                        }
                    });
                },
                create(el) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('translate.translates.store') }}',
                        data: {
                            type: $(el).find('[name="type"]').val(),
                            group_id: $(el).find('[name="group_id"]').val(),
                            key: $(el).find('[name="key"]').val(),
                            description: $(el).find('[name="description"]').val(),
                        },
                        success: function (res) {
                            if (res.status === 'success') {
                                transApp.dataTable.ajax.reload();
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
                        url: '{{ route('translate.translates.update') }}',
                        data: data,
                        success: function (res) {
                            if (res.status === 'success') {
                                transApp.dataTable.ajax.reload(null, false);
                                modal.modal('hide')
                                $.notify({message: res.message},{type: 'success'});
                            } else {
                                $.notify({message: res.message},{type: 'danger'});
                            }
                        }
                    });
                },
                delete(data, modal) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ route('translate.translates.destroy') }}',
                        data: data,
                        success: function (res) {
                            if (res.status === 'success') {
                                transApp.dataTable.ajax.reload(null, false);
                                modal.modal('hide')
                                $.notify({message: res.message},{type: 'success'});
                            } else {
                                $.notify({message: res.message},{type: 'danger'});
                            }
                        }
                    });
                },
                columns() {
                    let columns = [];
                    columns.push({
                        data: 'id',
                        title: 'ID'
                    });
                    columns.push({
                        data: 'key',
                        title: 'Key',
                        'render': function (data, type, full, meta) {
                            return '<div class="form-control key alert-primary" data-toggle="tooltip" title="' + full.description + '">' + data + '</div>';
                        }
                    });
                    for (let id in transApp.langs) {
                        console.log(transApp.langs);
                        columns.push({
                            data: 'items._' + id,
                            title: transApp.langs[id],
                            orderable: false,
                            'render': function (data, type, full, meta) {
                                let translation = '';
                                let transStatus = 'secondary';
                                if (data) {
                                    translation = data.translation || '';
                                    transStatus = (data.status === 1 ? 'danger' : (data.status === 2 ? 'success' : 'secondary'));
                                }
                                return '<div data-lang="' + id + '" class="translate form-control alert-' + transStatus + '">' + translation + '</div>';
                            }
                        });
                    };

                    return columns;
                },
                init() {
                    this.get();

                    $('#transCreateForm').on('submit', function (e) {
                        e.preventDefault();
                        transApp.create(this)
                    });

                    $('#transTable tbody').on('click', '.form-control', function () {
                        let tr = transApp.dataTable.row($(this).parents('tr'));
                        let el = tr.data();
                        if ($(this).hasClass('key')) {
                            $('#keyEditForm [name="id"]').val(el.id);
                            $('#keyEditForm [name="key"]').val(el.key);
                            $('#keyEditForm [name="description"]').val(el.description);
                            $('#keyEditModal').modal()
                        } else {
                            let lang_id = $(this).data('lang');
                            let translation = el.items['_' + lang_id] ? el.items['_' + lang_id].translation : '';
                            $('#tranlateEditForm [name="key"]').val(el.id);
                            $('#tranlateEditForm [name="lang"]').val(lang_id);
                            $('#tranlateEditForm [name="translation"]').val(translation);
                            $('#tranlateEditModal').modal()
                        }
                    });

                    $('#keyEditForm button').on('click', function (e) {
                        e.preventDefault();
                        if ($(this).hasClass('action-delete')) {
                            transApp.delete($(this).closest('form').serializeArray(), $('#keyEditModal'))
                        } else {
                            transApp.update($(this).closest('form').serializeArray(), $('#keyEditModal'))
                        }
                    });

                    $('#tranlateEditForm button').on('click', function (e) {
                        e.preventDefault();
                        let data = $(this).closest('form').serializeArray();
                        data.push({name: "status", value: $(this).val()});
                        transApp.update(data, $('#tranlateEditModal'));
                    });

                    $('#statusOptions input').on('click', function () {
                        transApp.status = $(this).val();
                        transApp.dataTable.draw();
                    });

                    $('#langOptions input').on('click', function () {
                        let langs = {};
                        $('#langOptions input:checked').each(function(index, el) {
                            langs[el.value] = main.langs[el.value];
                        });
                        transApp.langs = Object.keys(langs).length === 0 ? main.langs : langs;
                        transApp.dataTable.clear().destroy();
                        $('#transTable tr').remove();
                        transApp.get();
                    });

                    $('#searchFilter').on('submit', function(e) {
                        e.preventDefault();
                        transApp.keyText = $(this).find('[name="key"]').val();
                        transApp.translationText = $(this).find('[name="translation"]').val();
                        transApp.dataTable.draw();
                    });
                },
            };
            transApp.init();
        });
    </script>
@endsection

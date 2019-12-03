<?php
use \Sashaef\TranslateProvider\Models\Trans;
?>

@extends('vocabulare::layouts.main')

@section('content')

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

                <table id="transTable" class="table table-sm table_wrapper hover" cellspacing="0" width="100%">
                    <thead>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="btn-group aside">
        <!-- <div class="aside-icon save"></div>

        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon sort"></div>
            </div >
        </div> -->

        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon options"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-options-trans" >
                <div id="statusFilter" class="field-wrapper">status</div>
                <div id="statusOptions" hidden>
                    <div class="form-check">
                        <input class="form-check-input" id="all" type="radio" name="status" value="">
                        <label class="form-check-label" for="translated">All</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="checked"  type="radio" name="status" value="2">
                        <label class="form-check-label" for="translated">Checked</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="not-checked" type="radio" name="status" value="1">
                        <label class="form-check-label" for="not-translated">Not checked</label>
                    </div>
                </div>
                <div id="langFilter" class="field-wrapper">languages</div>
                <div id="langOptions" hidden>
                    <div class="field-wrapper">
                        <input id="searchLangFilter" type="text" placeholder="language" name="name" class="find-field" autocomplete="off">
                    </div>
                    <div class="field-list dataTables_scrollBody">
                        @foreach($langs as $lang)
                        <div class="form-check" data-lang="{{ $lang->name }}">
                            <input class="form-check-input" type="checkbox" name="lang[{{ $lang->id }}]" value="{{ $lang->id }}">
                            <label class="form-check-label" for="not-translated">{{ $lang->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown dropdown-btn">
            <div class="dropdown-toggle" data-toggle="dropdown">
                <div class="aside-icon find"></div>
            </div >
            <div class="dropdown-menu dropdown-menu-find-trans">
                <div class="field-wrapper">
                    <form id="searchFilter">
                        <input type="text" placeholder="Key" name="key" class="find-field">
                        <input type="text" placeholder="Translation" name="translation" class="find-field">
                        <button type="submit" class="button find-field">Search</button>
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
        };
        searchLangFilter.onkeyup = function(e) {
            let formChecks = $('#langOptions .form-check');
            let value = this.value;
            let valueUF = value.charAt(0).toUpperCase() + value.slice(1);
            formChecks.hide();
            if (value !== '') {
                formChecks.each(function (index, element) {
                    if ($(element).data('lang').match(value+".*") || $(element).data('lang').match(valueUF+".*")) {
                        $(element).show();
                    }
                });
            } else {
                formChecks.show();
            }
        };

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
                        scrollX: 200,
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
                create(data) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('translate.translates.store') }}',
                        data: data,
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
                    // columns.push({
                    //     data: 'id',
                    //     title: 'ID'
                    // });
                    columns.push({
                        data: 'key',
                        title: 'Key',
                        width: "180px",
                        'render': function (data, type, full, meta) {
                            return '<div class="form-control field key-field" >' + data + '</div>' + ' <div class="dropdown-toggle key" id="dropdownMenuButton" data-toggle="tooltip" title="' + full.description + '"></div>';
                        }
                    });
                    for (let id in transApp.langs) {
                        columns.push({
                            data: 'items._' + id,
                            title: transApp.langs[id],
                            width: "180px",
                            orderable: false,
                            'render': function (data, type, full, meta) {
                                let translation = '';
                                let transStatus = 'td-default';
                                if (data) {
                                    translation = data.translation || '';
                                    transStatus = (data.status === 2 ? 'td-aproved' : (data.status === 1 ? 'td-warning' : 'td-default'));
                                }
                                return '<div data-lang="' + id + '" class="translate form-control field ' + transStatus + '">' + translation + '</div>';
                            }
                        });
                    };

                    return columns;
                },
                init() {
                    this.get();

                    $('#transCreateForm').on('submit', function (e) {
                        e.preventDefault();
                        transApp.create($(this).serializeArray())
                    });

                    $('#transTable tbody').on('click', '.dropdown-toggle', function () {
                        let tr = transApp.dataTable.row($(this).parents('tr'));
                        let el = tr.data();
                        if ($(this).hasClass('key')) {
                            $('#keyEditForm [name="id"]').val(el.id);
                            $('#keyEditForm [name="key"]').val(el.key);
                            $('#keyEditForm [name="description"]').val(el.description);
                            $('#keyEditModal').modal()
                        } else {
                            // let lang_id = $(this).data('lang');
                            // let translation = el.items['_' + lang_id] ? el.items['_' + lang_id].translation : '';
                            // $('#tranlateEditForm [name="key"]').val(el.id);
                            // $('#tranlateEditForm [name="lang"]').val(lang_id);
                            // $('#tranlateEditForm [name="translation"]').val(translation);
                            // $('#tranlateEditModal').modal()
                        }
                    });
                    $('#transTable tbody').on('click', '.translate', function () {
                        let tr = transApp.dataTable.row($(this).parents('tr'));
                        let el = tr.data();
                            let lang_id = $(this).data('lang');
                            let translation = el.items['_' + lang_id] ? el.items['_' + lang_id].translation : '';
                            $('#tranlateEditForm [name="key"]').val(el.id);
                            $('#tranlateEditForm [name="lang"]').val(lang_id);
                            $('#tranlateEditForm [name="translation"]').val(translation);
                            $('#tranlateEditModal').modal();
                    });

                    $('#keyEditForm button').on('click', function (e) {
                        e.preventDefault();                        
                        transApp.update($(this).closest('form').serializeArray(), $('#keyEditModal'))                        
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

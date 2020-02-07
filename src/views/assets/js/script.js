let langApp = {
    dataTable: {},
    url: {},
    dict: {},
    csrf: null,
    isActive: null,
    searchText: null,
    get() {
        this.dataTable = $('#langTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            stateSave: true,
            language: {
                paginate: {
                    next: '<img src="/vendor/translate/img/arrow.svg">',
                    previous: '<img src="/vendor/translate/img/arrow.svg">'
                }
            },
            order: [[0, "desc"]],
            scrollX: true,
            // scrollY: false,
            deferRender:    true,
            scrollCollapse: true,
            scroller:       true,
            ajax: {
                url: langApp.url.get,
                'data': function(data) {
                    data.isActive = langApp.isActive;
                    data.search = langApp.searchText;
                }
            },
            columns: [
                { data: 'id', width: "24px" },
                {
                    data: 'flag_path',
                    width: "26px",
                    'render': function (data, type, full, meta) {
                        return '<img src="'+data+'">';
                    }
                },
                { data: 'index', width: "26px" },
                { data: 'name', width: "100px" },
                { data: 'dir', width: "26px" },
                { data: 'countries', width: "100px" },
                {
                    data: 'is_active',
                    width: "42px",
                    'render': function (data, type, full, meta) {
                        return '<div class="badge badge-' + (data ? 'active' : 'not-active') + '"></div>';
                    }
                },
                {
                    data: 'is_default',
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
                    defaultContent: '<div class="dropdown dropdown-arrow">' +
                        '<div class="dropdown-toggle" data-toggle="dropdown"><a class="dropdown-toggle-arrow"></a></div>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-edit">' +
                        '<div class="action action-edit"><div class="icon icon-edit"></div>'+langApp.dict.edit+'</div>'  +
                        '<div class="action action-delete"><div class="icon icon-delete"></div>'+langApp.dict.delete+'</div>' +
                        '</div>' +
                        '</div>'
                }
            ],
            columnDefs: [
                {targets: 7, orderable: false},
                {targets: 8, orderable: false},
            ]
        });
    },
    create(data) {
        $.ajax({
            type: "POST",
            url: langApp.url.store,
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
            url: langApp.url.update,
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
            url: langApp.url.destroy,
            data: {id: el.data().id, _token: langApp.csrf},
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

        let formEditCountries = $('#langEditForm select#country').select2({
            placeholder: "Other",
            templateSelection: function (state) {
                if (state.id === 'Other') {return state.text;}

                return $('<span><img class="img-flag" src="/vendor/translate/img/flags/'+state.element.value.toLowerCase()+'.png"/> <span>'+state.text+'</span></span>');
            }
        });

        $('#langTable tbody').on('click', 'div.action-edit', function () {
            let tr = langApp.dataTable.row($(this).parents('tr'));
            let el = tr.data();
            $('#langEditModal [name="id"]').val(el.id);
            $('#langEditModal [name="index"]').val(el.index);
            $('#langEditModal [name="name"]').val(el.name);
            $('#langEditModal [name="flag"]').val(el.flag);
            $('#langEditModal [name="dir"]').val(el.dir);
            let countries = el.countries ? el.countries.split(',') : null;
            formEditCountries.val(countries).trigger('change');
            $('#langEditModal [name="is_active"]').prop('checked', el.is_active);
            $('#langEditModal [name="is_default"]').prop('checked', el.is_default);
            $('#langEditModal').modal()
        });

        $('#langEditForm').on('submit', function (e) {
            e.preventDefault();
            transApp.translationText = $(this).find('[name="translation"]').val();
            $(this).find('input[name="countries"]').val(formEditCountries.val());
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

        $('#statusLink').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById("statusOptions").classList.toggle("show-options");
        });

        $('#statusOptions').on('click', function(e) {
            e.stopPropagation();
        });

        $('#langCreateForm select[name="name"]').select2({
            placeholder: "...",
        }).on('select2:select', function (e) {
            $('#langCreateForm input[name="index"]').val(e.params.data.element.dataset.code || null);
            $('#langCreateForm select[name="flag"]').val(e.params.data.element.dataset.flag || null).trigger('change');
            $('#langCreateForm select[name="dir"]').val(e.params.data.element.dataset.dir || null);
        });

        $('#langCreateForm select[name="flag"]').select2({
            placeholder: "...",
            templateSelection: function (state) {
                if (!state.id || state.id === '...') {return state.text;}

                return $('<span><img class="img-flag" src="/vendor/translate/img/flags/'+state.element.value.toLowerCase()+'.png"/> <span>'+state.text+'</span></span>');
            }
        });

        let formCountry = $('#langCreateForm input[name="countries"]').on('click', function () {
            $('#langCountryModal').modal();
        });

        let modalCountry = $('#langCountryModal select[name="country"]').select2({
            placeholder: "Other",
            templateSelection: function (state) {
                if (!state.id || state.id === 'Other') {return state.text;}

                return $('<span><img class="img-flag" src="/vendor/translate/img/flags/'+state.element.value.toLowerCase()+'.png"/> <span>'+state.text+'</span></span>');
            }
        });

        $('#langCountryModal button[name="add"]').on('click', function (e) {
            formCountry.val(modalCountry.val());
            $('#langCountryModal').modal('hide');
        });
    },
};

let groupApp = {
    dataTable: {},
    url: {},
    dict: {},
    type: null,
    csrf: null,
    searchText: null,
    get() {
        this.dataTable = $('#groupTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            stateSave: true,
            language: {
                paginate: {
                    next: '<img src="/vendor/translate/img/arrow.svg">',
                    previous: '<img src="/vendor/translate/img/arrow.svg">'
                }
            },
            order: [[0, "desc"]],
            scrollX: true,
            scrollY: false,
            ajax: {
                url: groupApp.url.get,
                'data': function(data) {
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
                    defaultContent: '<div class="dropdown dropdown-arrow">' +
                        '<div class="dropdown-toggle" data-toggle="dropdown"><a class="dropdown-toggle-arrow"></a></div>' +
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-edit">' +
                        '<div class="action action-delete"><div class="icon icon-delete"></div>'+groupApp.dict.delete+'</div>' +
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
        window.location = groupApp.url.index + '?type=' + data.type + '&group=' + data.id;
    },
    create(data) {
        $.ajax({
            type: "POST",
            url: groupApp.url.store,
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
    restart(type) {
        $.ajax({
            type: "POST",
            url: groupApp.url.restart,
            data: {type: type, _token: groupApp.csrf},
            success: function (res) {
                if (res.status === 'success') {
                    groupApp.dataTable.ajax.reload();
                    $.notify({message: res.message},{type: 'success'});
                } else {
                    $.notify({message: res.message},{type: 'danger'});
                }
            }
        });
    },
    import() {
        $.ajax({
            type: "GET",
            url: groupApp.url.import,
            data: {type: groupApp.type},
            success: function (res) {
                if (res.status === 'success') {
                    let trs = '';
                    for (let group in res.items) {
                        trs += '<tr class="'+(res.items[group].exists ? 'success' : '')+'">' +
                            '<td>'+group+'</td>' +
                            '<td>'+res.items[group].lang.join(', ')+'</td>' +
                            '<td><input type="checkbox" class="form-control input-xs" name="group['+group+']" value="1"></td>' +
                            '</tr>';
                    }
                    $('#groupImportForm tbody').html(trs);
                    $('#groupImportModal').modal('show');
                }
            },
            error: function (res) {
                $.notify({message: 'Server error!'},{type: 'danger'});
            },
        });
    },
    parse(data) {
        $.ajax({
            type: "POST",
            url: groupApp.url.parse,
            data: data,
            success: function (res) {
                if (res.status === 'success') {
                    groupApp.dataTable.ajax.reload();
                    $('#groupImportModal').modal('hide');
                    $.notify({message: res.message},{type: 'success'});
                } else {
                    $.notify({message: res.message},{type: 'danger'});
                }
            },
            error: function (res) {
                $.notify({message: 'Server error!'},{type: 'danger'});
            },
            complete: function(data) {
                $('#groupImportForm .modal-footer button').prop('disabled', false);
            }
        });
    },
    delete(el) {
        $.ajax({
            type: "DELETE",
            url: groupApp.url.destroy,
            data: {id: el.data().id, trans: true, _token: groupApp.csrf},
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

        $('#importGroup').on('click', function () {
            groupApp.import();
        });

        $('#groupImportForm').on('submit', function (e) {
            e.preventDefault();
            $(this).find('.modal-footer button').prop('disabled', true);
            groupApp.parse($(this).serializeArray())
        });

        $('#groupTable tbody').on('click', 'div.action-delete', function () {
            let el = groupApp.dataTable.row($(this).parents('tr'));
            if (el.data().trans + el.data().not_trans > 0) {
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

        $('#restartType').on('click', function () {
            groupApp.restart($(this).data('type'));
        });
    },
};

let transApp = {
    dataTable: {},
    url: {},
    dict: {},
    group: null,
    keyText: null,
    translationText: null,
    verified: null,
    translated: null,
    langs: {},
    get() {
        this.dataTable = $('#transTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            stateSave: true,
            language: {
                paginate: {
                    next: '<img src="/vendor/translate/img/arrow.svg">',
                    previous: '<img src="/vendor/translate/img/arrow.svg">'
                }
            },
            scrollX: 200,
            order: [[0, "desc"]],
            ajax: {
                url: transApp.url.get,
                'data': function(data) {
                    data.group_id = transApp.group;
                    data.keyText = transApp.keyText;
                    data.translationText = transApp.translationText;
                    data.verified = transApp.verified;
                    data.translated = transApp.translated;
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
            url: transApp.url.store,
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
            url: transApp.url.update,
            data: data,
            success: function (res) {
                if (res.status === 'success') {
                    transApp.dataTable.ajax.reload(null, false);
                    modal.modal('hide')
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
    delete(data, modal) {
        $.ajax({
            type: "DELETE",
            url: transApp.url.destroy,
            data: data,
            success: function (res) {
                if (res.status === 'success') {
                    transApp.dataTable.ajax.reload(null, false);
                    modal.modal('hide');
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
    columns() {
        let columns = [];
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

        $('#transTable tbody').on('click', '.dropdown-toggle.key', function () {
            let tr = transApp.dataTable.row($(this).parents('tr'));
            let el = tr.data();
            $('#keyEditForm [name="id"]').val(el.id);
            $('#keyEditForm [name="key"]').val(el.key);
            $('#keyEditForm [name="description"]').val(el.description);
            $('#keyEditModal').modal()
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

        $('#keyEditForm button[type="submit"]').on('click', function (e) {
            e.preventDefault();
            if ($(this).val() === 'delete') {
                transApp.delete($(this).closest('form').serializeArray(), $('#keyEditModal'))
            } else {
                transApp.update($(this).closest('form').serializeArray(), $('#keyEditModal'))
            }
        });

        $('#tranlateEditForm button[type="submit"]').on('click', function (e) {
            e.preventDefault();
            let data = $(this).closest('form').serializeArray();
            data.push({name: "status", value: $(this).val()});
            transApp.update(data, $('#tranlateEditModal'));
        });

        $('#verifyOptions input').on('click', function () {
            transApp.verified = $(this).val();
            transApp.dataTable.draw();
        });

        $('#translateOptions input').on('click', function () {
            transApp.translated = $(this).val();
            transApp.dataTable.draw();
        });

        $('#langOptions input').on('click', function () {
            let langs = {};
            $('#langOptions input:checked').each(function(index, el) {
                langs[el.value] = transApp.langs[el.value];
            });
            transApp.langs = Object.keys(langs).length === 0 ? transApp.langs : langs;
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

        $('.accordion-header').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).parent().find('.accordion-body').toggleClass('show-options');
        });

        $('#searchLangFilter').on('keyup', function(e) {
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
        });
    },
};

$(function($) {
    $('.modal-dialog button[name="cancel"]').on('click', function () {
        $(this).closest('.modal').modal('hide');
    })
});

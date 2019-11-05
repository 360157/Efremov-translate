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
            background: #5670FF;
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
            background-color: #5670FF;
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
            color: #5670FF;
            border: 1px solid #5670FF;
            cursor: default !important;
        }

        .btn-disable:hover {
            color: #5670FF;
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

        .modal-body {
            height: 190px;
            padding: 15px 29px 30px 29px;
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

        #myTable_filter, #myTable_info, .dataTables_length {
            display: none;
        }

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
            background-color: #5670FF;
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
            <h5 class="panel-title">Translations</h5>
        </div>
        <div class="panel-content">
            <div class="panel-body">
                @include('vocabulare::pages.trans.create')
                <form action="{{ route('translate.translates.index', ['type' => $type, 'group_id' => $group_id]) }}" method="get" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="type" value="{{ $type }}" class="form-control">
                                <input type="hidden" name="id" value="{{ $group_id }}" class="form-control">
                                <input type="hidden" name="isFilter" value="1" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>

                <table id="myTable" class="table table-sm" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="block">@lang('main.key')</th>
                        @foreach($langs as $lang)
                            <th class="block">{{ $lang->name }}</th>
                        @endforeach
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($trans as $translate)
                        <tr>
                            <td class="dropdown block">
                                <span class="value" title="@lang('main.key')">{{ $translate->key }}</span>
                                <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></div>
                                <div class="dropdown-menu dropdown-value" aria-labelledby="dropdownMenuButton" data-id="{{ $translate->id }}">
                                    <div class="dropdown-item">
                                        <input name="key" cols="22" rows="2" class="dropdown-content" value="{{ $translate->key }}">
                                        <textarea name="description" cols="22" rows="2" class="dropdown-content">{{ $translate->description }}</textarea>
                                    </div>
                                    <div class="dropdown-footer">
                                        <button class="btn btn-primary save">
                                            <div class="restart"></div>
                                            <span>Save</span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <?php $translations = $translate->data; ?>
                            @foreach($langs as $lang)
                                <?php $translation = $translations->where('lang_id', $lang->id)->first() ?? new Trans; ?>
                                <td class="dropdown block">
                                    <div class="form-control {{$translation->status === 1 ? 'unchecked' : ($translation->status === 2 ? 'checked' : '')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $translation->translation }}</div>
                                    <div class="dropdown-menu dropdown-translate-controller" aria-labelledby="dropdownButton" data-id="{{ $translation->id }}" data-key="{{ $translate->id }}" data-lang="{{ $lang->id }}">
                                        <div class="dropdown-item">
                                            <textarea cols="22" rows="2" class="dropdown-content">{{ $translation->translation }}</textarea>
                                        </div>
                                        <div class="dropdown-footer">
                                            <button class="btn btn-disable check">
                                                <div class="check"></div>
                                                <span>Checked</span>
                                            </button>
                                            <button class="btn btn-primary save">
                                                <div class="restart"></div>
                                                <span>Save</span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="panel-footer">
                    {{ $trans->appends(['filter' => ['type' => $type, 'group' => $group_id]])->links('vocabulare::includes.pagination') }}
                </div>
            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type='text/javascript'>

        /*$(document).ready(function () {
            $('#myTable').DataTable({
                "scrollX": true
            });
        });*/

        const elements = document.querySelectorAll('input.checkClass');
        elements.forEach(function (el) {
            el.addEventListener('input', function (e) {
                e.target.classList.remove('td-aproved');
                e.target.classList.add('td-default');
            });
        });

        $(function() {
            $('.dropdown-translate-controller .btn.save, .dropdown-translate-controller .btn.check').on('click', function () {
                let translation = $(this).parent().parent();
                let updateData = {
                    obj: 'translation',
                    key: translation.data('key'),
                    lang: translation.data('lang'),
                    translation: translation.find('.dropdown-content').val(),
                    status: $(this).hasClass('check') ? 2 : 1
                };

                $.ajax({
                    type: "PATCH",
                    url: '{{ route('translate.translates.update') }}',
                    data: updateData,
                    success: function(data) {
                        if (data.status === 'success') {
                            translation.parent().find('.form-control')
                                .html(updateData.translation)
                                .attr('class', 'form-control' + (updateData.status === 1 ? ' unchecked' : ' checked'));
                        }
                    }
                });
            })
        });

        $(function() {
            $('.dropdown-value .btn.save').on('click', function () {
                let key = $(this).parent().parent();
                let updateData = {
                    obj: 'key',
                    id: key.data('id'),
                    key: key.find('[name="key"]').val(),
                    description: key.find('[name="description"]').val(),
                };

                $.ajax({
                    type: "PATCH",
                    url: '{{ route('translate.translates.update') }}',
                    data: updateData,
                    success: function(data) {
                        if (data.status === 'success') {
                            console.log(key.parent().find('span.value'));
                            key.parent().find('span.value').html(updateData.key);
                        }
                    }
                });
            })
        });
    </script>
@endsection
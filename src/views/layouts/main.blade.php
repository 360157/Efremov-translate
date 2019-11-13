<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{config('app.favicon')}}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Title</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="/vendor/vocabulare/css/style.css" rel="stylesheet" type="text/css">

    <style>
        body {
            background-color: #F1F1F1;
        }

        .navbar {
            margin: 0 300px;
            border-radius: 4px;
            padding: 0 30px;
            margin-bottom: 10px;
            background-color: #FFFFFF;
        }

        .navbar-brand {
            font: 400 20px/26px Roboto;
            text-transform: capitalize;
        }

        .nav-link span {
            font: 300 14px/19px Roboto;
            color: #212121;
        }

        .nav-link:hover span {
            font-weight: 400;
            color: #5670FF;
        }

        .nav-link:active span {
            font-weight: 400;
            color: #212121;
            text-decoration: underline;
        }

        .page-content {
            margin: 0 300px;
            border-radius: 4px;
            background-color: #FFFFFF;
        }

        .nav-link {
            padding: 8px 60px;
        }

        .btn-group {
            position: absolute;
            top: 60px;
            left: 2px;
            background: #FFFFFF;
            width: 265px;
            height: 57px;
            border-radius: 4px;
            -moz-box-shadow: 0px 0px 5px #939292;
            -webkit-box-shadow: 0px 0px 5px #939292;
            box-shadow: 0px 0px 5px #939292;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }


        /* aside css */


        .aside-icon {
            width: 38px;
            height: 38px;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .aside-icon:active {
            background: #5670FF;
        }

        .save::after {
            content: '';
            width: 28px;
            height: 17px;
            background: url("/img/save.svg") no-repeat;
        }

        .save:hover::after {
            background: url("/img/save-hover.svg") no-repeat;
        }

        .save:active::after {
            margin-top: 6px;
            background: url("/img/save-active.svg") no-repeat;
        }

        .sort::after {
            content: "";
            width: 27px;
            height: 22px;
            background: url("/img/sort.svg") no-repeat;
        }

        .sort:hover::after {
            background: url("/img/sort-hover.svg") no-repeat;
        }

        .sort:active::after {
            background: url("/img/sort-active.svg") no-repeat;
        }

        .options::after {
            content: '';
            width: 26px;
            height: 25px;
            background: url("/img/options.svg") no-repeat;
        }

        .options:hover::after {
            background: url("/img/options-hover.svg") no-repeat;
        }

        .options:active::after {
            background: url("/img/options-active.svg") no-repeat;
        }

        .find::after {
            content: '';
            width: 27px;
            height: 27px;
            background: url("/img/find.svg") no-repeat;
        }

        .find:hover::after {
            background: url("/img/find-hover.svg") no-repeat;
        }

        .find:active::after {
            background: url("/img/find-active.svg") no-repeat;
        }

        .aside > .dropdown > .dropdown-menu {
            width: 265px;
            position: absolute;
        }

        .dropdown-menu {
            padding: 0;
            border-radius: 4px;
            border: none;
            /* height: 400px; */
        }

        .dropdown-menu-options,
        .dropdown-menu-sort,
        .dropdown-menu-find,
        .dropdown-menu-sort-groups,
        .dropdown-menu-find-groups,
        .dropdown-menu-sort-trans,
        .dropdown-menu-find-trans,
        .dropdown-menu-options-trans {
            position: absolute;
            border: none !important;
            padding: 0 !important;
            -moz-box-shadow: 1px 2px 2px #939292;
            -webkit-box-shadow: 1px 2px 2px #939292;
            box-shadow: 1px 2px 2px #939292;
        }

        .dropdown-menu-options {
            left: -147px !important;
        }

        .dropdown-menu-sort {
            left: -80px !important;
        }

        .dropdown-menu-find {
            left: -213px !important;
        }

        .dropdown-menu-sort-groups {
            left: -113px !important;
        }

        .dropdown-menu-find-groups {
            left: -202px !important;
        }

        .dropdown-menu-sort-trans {
            left: -80px !important;
        }

        .dropdown-menu-options-trans {
            left: -147px !important;
        }

        .dropdown-menu-find-trans {
            left: -213px !important;
        }

        .field-wrapper {
            margin-top: 8px;
            border-top: 1px solid #E8EBED;
            width: 100%;
            padding: 15px 20px !important;
            cursor: pointer;
        }

        .description {
            min-height: 60px;
        }

        .find-field {
            border: 1px solid #6E6E6E;
            outline: none;
            border-radius: 4px;
            width: 100%;
            padding: 4px 14px;
            margin: 5px 0;
            font: 300 14px/19px Roboto;
        }

        .find-field:focus {
            border-color: #5670FF;
        }

        .find-field::placeholder {
            color: #D6D6D6;
            font: 300 14px/19px Roboto;
        }

        #statusOptions {
            display: none;
        }

        #lang-options {
            display: none;
            padding: 10px 19px;
            border-top: 1px solid #E8EBED;
        }

        #lang-options ul {
            margin: 0;
            padding: 0;
            padding-top: 10px;
        }

        #lang-options ul li {
            padding: 0 10px;
        }

        #langFilter, #statusFilter, #statusLink {
            position: relative;
            margin: 0;
            padding: 10px 20px !important;
        }

        #langFilter:after, #statusFilter:after, #statusLink:after {
            content: '';
            position: absolute;
            top: 21px;
            right: 12px;
            width: 12px;
            height: 7px;
            background: url("/img/arrow.svg") no-repeat;
            cursor: pointer;
            transform: rotate(-90deg);
            transition-duration: 500ms;
        }

        .show-options {
            display: block !important;
        }

        .form-check {
            height: 44px;
            border-top: 1px solid #E8EBED;
            display: flex;
            align-items: center;
            font: 400 14px/19px Roboto;
            padding-left: 20px;
        }

        .form-check-label {
            padding-left: 30px;
            color: #919191;
        }

        .form-check-input:checked:after {
            background: #8CB302;
        }

        .form-check-input:checked + .form-check-label {
            color: #000000;
        }

        .form-check-input {
            margin: 0;
            width: 22px;
            height: 22px;
        }

        .form-check-input:after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 22px;
            height: 22px;
            background: #919191;
            border-radius: 4px;
        }

        #not-checked:checked:after {
            background: #EC4439;
        }

        #all:checked:after {
            background: #1595BA;
        }

        #checked:checked:after {
            background: #8CB302;
        }

        .td-aproved {
            border: 1.5px solid #8CB302 !important;
        }

        .td-default {
            border: 1.5px solid #1595BA !important;
        }

        .td-warning {
            border: 1.5px solid #EC4439 !important;
        }

        .panel {
            background-color: #fff;
            border-radius: 4px;
            padding-bottom: 8px;
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

        .button {
            background: #5670FF;
            border: none;
            border-radius: 15px !important;
            color: #FFFFFF;
            font: 300 14px/19px Roboto;
            margin: 0 4px;
        }

        .button:hover {
            background: #5670FF;
            color: #FFFFFF;
            font: 300 14px/19px Roboto;
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

        .btn-icon {
            display: flex;
        }

        .btn-light {
            margin: 0 4px;
            border: 1px solid #5670FF !important;
            background: #FFFFFF !important;
            color: #5670FF !important;

        }

        .btn-light:hover, .btn-light:active {
            border: 1px solid #5670FF !important;
            background: #FFFFFF !important;
            color: #5670FF !important;
        }

        .update-icon {
            width: 12px;
            height: 12px;
            background: url("/img/update.svg") no-repeat;
            margin: 4px;
        }

        .check-icon {
            width: 13px;
            height: 12px;
            background: url("/img/checked.svg") no-repeat;
            margin: 4px;
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
            /* height: 48px; */
            font: 300 14px/19px Roboto;
            text-align: left;
            /* max-width: 25%; */
        }

        /* td {
            overflow-y: hidden;
        } */
        /* th:last-child, td:last-child{
            text-align: right !important;
        } */
        .table_wrapper {
            width: 1200px !important;
            max-width: 1200px !important;
            overflow-x: scroll !important;
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
            min-width: 217px !important;
            width: 217px !important;
            max-width: 217px !important;
            max-height: 48px !important;
            font: 300 14px/30px Roboto;
            text-align: left;
            padding: 9px !important;
            border-right: 1px solid #E5E5E5;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        table.dataTable td.dataTables_empty {
            text-align: center !important;
        }

        .table.dataTable thead th {
            border: none;
        }

        .table.dataTable {
            table-layout: fixed;
            word-wrap: break-word;
        }

        .table.dataTable thead th:first-child {
            border-right: 1px solid #E5E5E5;
        }

        .dropdown {
            overflow-y: visible;
        }

        .dropdown .checked {
            background: #28a7454d;
        }

        .dropdown .unchecked {
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

        .active-status-wrapper {
            width: 100%;
            margin-left: 5px;
        }

        .value-group {
            display: flex;
        }

        .lang-value {
            width: 100%;
            border: 1px solid #E5E5E5;
            border-radius: 4px;
            padding: 5px 7px;
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

        .dropdown-toggle::after {
            display: none;
        }

        .key {
            float: right;
            width: 28px;
            height: 28px;
            background: #FCFCFC;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
        }

        .key::before {
            position: absolute;
            content: "";
            top: 7px;
            left: 7px;
            width: 14px;
            height: 14px;
            background: url("/img/stretch.svg") center no-repeat;
        }

        .key:hover {
            background: #536CF5;
        }

        .key:hover::before {
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


        .dataTables_wrapper {
            margin-top: 60px;
        }

        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: center;
        }

        #transTable_wrapper > .dataTables_scroll > .dataTables_scrollBody > table > tbody > tr > td:first-child > .form-control {
            border: none;
        }

        #transTable_wrapper,
        #groupTable_wrapper,
        #langTable_wrapper {
            min-height: 150px;
        }

        #groupTable_previous, #groupTable_next,
        #transTable_previous, #transTable_next,
        #langTable_next, #langTable_previous {
            font-size: 0;
            position: relative;
        }

        #transTable_next:after,
        #groupTable_next:after,
        #langTable_next:after {
            content: '';
            position: absolute;
            top: 18px;
            width: 12px;
            height: 7px;
            left: 6px;
            background: url("/img/arrow.svg") no-repeat;
            transform: rotate(270deg);
            cursor: pointer;
        }

        #transTable_previous:after,
        #groupTable_previous:after,
        #langTable_previous:after {
            content: '';
            position: absolute;
            top: 18px;
            right: 6px;
            width: 12px;
            height: 7px;
            background: url("/img/arrow.svg") no-repeat;
            cursor: pointer;
            transform: rotate(90deg);
        }

        .disabled#groupTable_previous:after, .disabled#groupTable_next:after,
        .disabled#transTable_next:after, .disabled#transTable_previous:after,
        .disabled#langTable_next:after, .disabled#langTable_previous:after {
            top: 16px;
            width: 7px;
            height: 12px;
            background: url("/img/disabled.svg") no-repeat;
            transform: rotate(180deg);
            cursor: default;
        }

        .disabled#groupTable_previous:after,
        .disabled#transTable_previous:after,
        .disabled#langTable_previous:after {
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


        /* scroll */
        .dataTables_wrapper.no-footer .dataTables_scrollBody {
            border: none;
        }

        .dataTables_wrapper.no-footer .dataTables_scrollBody::-webkit-scrollbar {
            background-color: #E8EBED;
            height: 4px;
        }

        .dataTables_wrapper.no-footer .dataTables_scrollBody::-webkit-scrollbar-thumb {
            border-radius: 60px;
            max-width: 100px;
            width: 100px;
            background: #5670FF;
        }

        .dataTables_wrapper.no-footer .dataTables_scrollBody::-webkit-scrollbar:vertical {
            display: none;
        }

        table.dataTable thead .sorting_asc {
            background: transparent;
        }


        /* dropdown edit element */
        .edit-wrapper {
            width: 100%;
            height: 25px;
            position: relative;
        }

        .dropdown-toggle-arrow {
            position: absolute;
            top: 9px;
            right: 0;
            width: 12px;
            height: 7px;
            background: url("/img/arrow.svg") no-repeat;
            cursor: pointer;
        }

        .dropdown-toggle-arrow::after {
            display: none;
        }

        .dropdown-menu-edit {
            top: 15px !important;
            z-index: 20;
            overflow: visible;
            -moz-box-shadow: 0px 0px 2px #939292;
            -webkit-box-shadow: 0px 0px 2px #939292;
            box-shadow: 0px 0px 2px #939292;
        }

        .action-link {
            cursor: pointer;
        }

        .action-edit, .action-delete {
            cursor: pointer;
            width: 100%;
            height: 37px;
            padding: 0 19px;
            display: flex;
            align-items: center;
        }

        .action-edit:hover, .action-delete:hover {
            background: #E8EBED;
        }

        /*END dropdown edit element */

        .block, .table.dataTable thead th {
            max-width: 166px;
            text-overflow: clip;
        }

        .table.dataTable thead th {
            width: 166px !important;
            max-width: 166px !important;
        }

        table.dataTable thead .sorting_desc {
            width: 166px !important;;
            max-width: 166px !important;
        }

        .row {
            max-height: 28px !important;
        }

        .row .sorting_desc {
            width: 166px !important;;
            max-width: 166px !important;
        }

        table {
            table-layout: fixed !important;
        }

        /* td{
            overflow:hidden;
            text-overflow: ellipsis;
        } */
        .table tbody tr td {
            min-width: 217px !important;
            width: 217px !important;
            max-width: 217px !important;
            max-height: 48px !important;
            font: 300 14px/19px Roboto;
            text-align: left;
            padding: 0px 5px;
        }

        #langTable tbody tr td {
            border-right: 1px solid #E5E5E5;
        }

        .table tbody tr td:last-child {
            border-right: none;
        }

        .field {
            height: 28px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font: 300 14px/19px Roboto;
            position: relative;
        }

        .key-field {
            float: left;
            width: calc(100% - 40px);
            height: 28px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: default;
            border: none;
        }

        table.dataTable tbody tr, table.dataTable thead {
            max-height: 40px;
            padding-bottom: 1px !important;
        }

        .dataTables_length, .dataTables_info {
        }

        .table.dataTable thead th {
            font: 500 14px/19px Roboto;
        }

        .field {
            background: transparent;
        }


        /* index.blade.php  OLD*/
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
            padding: 4px 7px;
            font: 300 14px/19px Roboto;
        }

        .form-control::placeholder {
            color: #E5E5E5;
        }

        .select {
            width: calc(100% - 124px - 15px);
        }

        /* .btn {
            width: 124px;
            height: 30px;
            position: absolute;
            bottom: 0;
            right: 15px;
            border-radius: 15px;
            background: #5670FF;
            padding: 0;
        } */
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
            /* height: 48px; */
            font: 300 14px/19px Roboto;
            text-align: left;
            max-width: 25%;
        }

        /* td {
            overflow-y: hidden;
        } */
        th:last-child, td:last-child {
            text-align: right !important;
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
            background-color: #F3F5F6 !important;
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
            max-height: 40px;
        }

        /* td {
            overflow-y: hidden;
        } */
        .dropdown {
            overflow-y: visible;
        }

        .dropdown-arrow {
            overflow-y: visible;
        }

        .dropdown-menu-arrow {
            padding: 0;
            border-radius: 4px;
            border: none;
            /* height: 400px; */
            -moz-box-shadow: 0px 1px 2px #939292;
            -webkit-box-shadow: 0px 1px 2px #939292;
            box-shadow: 0px 1px 2px #939292;
            margin: 40px;
        }

        .dropdown-menu-arrow span {
            height: 37px;
            padding: 0 25px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .dropdown-menu-arrow span:hover {
            background: #E8EBED;
        }

        .dropdown-menu-arrow {
            height: 100px;
            width: 200px;
            background: #367333;
        }

        th:last-child, td:last-child {
            text-align: right !important;
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
            cursor: pointer;
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

        .btn-center {
            display: flex;
            justify-content: center;
            margin-right: 16px;
        }


        /* new styles */

        #langTable .row {
            height: 50px;
            paddin
        }

        table.#langTable tbody tr {
            height: 50px;
            padding: 0;
        }

        table.dataTable tbody tr {
            height: 50px;
            padding: 0;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <nav id="navbar" class="navbar">
            <span class="navbar-brand">@lang('system::main.translate')</span>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('translate.langs.index') }}"><span>@lang('system::main.langs')</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('translate.groups.type', ['type' => 'interface']) }}"><span>@lang('system::main.interface-trans')</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('translate.groups.type', ['type' => 'system']) }}"><span>@lang('system::main.system-trans')</span></a>
                </li>
            </ul>
        </nav>

        <section class="page-content">
        @foreach(['success', 'error'] as $type)
            @if (Session::has($type))
            <div class="alert alert-{{ $type !== 'error' ? $type : 'danger' }}" role="alert">
                {!! Session::get($type) !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            @endif
        @endforeach

        </section>

        <section class="page-content">
            @yield('content')
        </section>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="/vendor/vocabulare/js/script.js"></script>
@yield('vocabulare-js')
</html>

@extends('vocabulare::layouts.main')

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">

            <h5 class="panel-title">Title</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@lang('main.id')</th>
                        <th>@lang('main.email')</th>
                        <th>@lang('main.name')</th>
                        <th>@lang('main.message')</th>
                        <th>@lang('main.files')</th>
                        <th>@lang('main.actions')</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>


    </div>
    <!-- /individual column searching (text inputs) -->

    <script>


    </script>
@endsection